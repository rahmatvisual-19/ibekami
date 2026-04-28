<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::all();
        return view('backend.pages.banner', compact('banner'));
    }

    public function create(Request $request)
    {
        // Hanya boleh ada 1 banner (video tunggal)
        if (Banner::count() >= 1) {
            return redirect()->route('banner.index')
                ->with('error', 'Only 1 banner is allowed. Please edit or delete the existing one first.');
        }

        $request->validate([
            'banner_picture' => 'required|mimes:jpg,jpeg,png,webp,mp4,webm,ogg|max:51200|dimensions:max_width=2880,max_height=1200'
        ],[
            'banner_picture.required' => 'Media cannot be empty',
            'banner_picture.mimes'    => 'File formats must be jpg, png, jpeg, webp, mp4, webm, or ogg',
            'banner_picture.max'      => 'Maximum file size is 50MB',
            'banner_picture.dimensions' => 'Resolusi gambar maksimal 2880x1200 px'
        ]);

        $banner              = new Banner;
        $banner->title       = '';
        $banner->description = '';
        $banner->alt         = '';

        if ($request->hasFile('banner_picture')) {
            $file     = $request->file('banner_picture');
            $fileName = $this->storeMedia($file);
            $banner->image_url = $fileName;
        }

        $banner->save();

        session()->flash('Success', 'Media has been successfully added');
        return redirect('/dashboard/banner');
    }

    public function delete($id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            $this->deleteImageFile($banner->image_url);
            $banner->delete();
            return redirect('/dashboard/banner')->with('Success', 'Media has been successfully deleted');
        }
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('backend.pages.editbanner', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'banner_picture' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,webm,ogg|max:51200|dimensions:max_width=2880,max_height=1200'
        ],[
            'banner_picture.mimes' => 'File formats must be jpg, png, jpeg, webp, mp4, webm, or ogg',
            'banner_picture.max'   => 'Maximum file size is 50MB',
            'banner_picture.dimensions' => 'Resolusi gambar maksimal 2880x1200 px'
        ]);

        $banner = Banner::findOrFail($id);

        if ($request->hasFile('banner_picture')) {
            if ($banner->image_url) {
                $this->deleteImageFile($banner->image_url);
            }

            $file     = $request->file('banner_picture');
            $fileName = $this->storeMedia($file);
            $banner->image_url = $fileName;
        }

        $banner->save();

        session()->flash('Success', 'Media has been successfully edited');
        return redirect('/dashboard/banner');
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    /**
     * Store uploaded media.
     * - Images: resized to 1440x600 max and saved as WebP.
     * - Videos: saved as MP4 first, then converted to WebM via ffmpeg.
     *           If conversion succeeds, MP4 is deleted and WebM filename is returned.
     *           If conversion fails, MP4 is kept as fallback.
     */
    private function storeMedia(\Illuminate\Http\UploadedFile $file): string
    {
        $ext      = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $isVideo  = in_array($ext, ['mp4', 'webm', 'ogg', 'mov']);

        if (!$isVideo) {
            // Image — resize & save as WebP
            $fileName = uniqid() . '.webp';
            $savePath = storage_path('app/public/banner_picture/' . $fileName);
            
            $this->resizeAndSaveWebp($file->getRealPath(), $savePath, 1440, 600, 85);
            
            return $fileName;
        }

        // Video — store original first, then convert to WebM
        $baseName  = uniqid();
        $origName  = $baseName . '.' . $ext;
        $webmName  = $baseName . '.webm';

        $origPath  = storage_path('app/public/banner_picture/' . $origName);
        $webmPath  = storage_path('app/public/banner_picture/' . $webmName);

        $file->storeAs('banner_picture', $origName, 'public');

        // If already WebM, no conversion needed
        if ($ext === 'webm') {
            return $origName;
        }

        // Try converting to WebM using ffmpeg
        try {
            $ffmpegBin = base_path('node_modules/@ffmpeg-installer/win32-x64/ffmpeg.exe');

            // Fallback: try system ffmpeg
            if (!file_exists($ffmpegBin)) {
                $ffmpegBin = 'ffmpeg';
            }

            $cmd = sprintf(
                '%s -i %s -c:v libvpx-vp9 -crf 40 -b:v 0 -vf scale=720:-2 -c:a libopus -b:a 64k -deadline good -cpu-used 4 -row-mt 1 %s 2>&1',
                escapeshellarg($ffmpegBin),
                escapeshellarg($origPath),
                escapeshellarg($webmPath)
            );

            exec($cmd, $output, $returnCode);

            if ($returnCode === 0 && file_exists($webmPath) && filesize($webmPath) > 0) {
                // Conversion success — delete original
                @unlink($origPath);
                return $webmName;
            }

            // Conversion failed — keep original
            Log::warning('BannerController: WebM conversion failed, keeping original.', [
                'file'   => $origName,
                'output' => implode("\n", $output),
            ]);
            return $origName;

        } catch (\Throwable $e) {
            Log::error('BannerController: ffmpeg exception: ' . $e->getMessage());
            return $origName;
        }
    }

    private function deleteImageFile(string $imagePath): void
    {
        $fileName = basename($imagePath);

        foreach ([
            public_path('storage/banner_picture/' . $fileName),
            storage_path('app/public/banner_picture/' . $fileName),
        ] as $path) {
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    /**
     * Resize gambar dan save sebagai WebP dengan kualitas optimal
     * 
     * @param string $sourcePath Path file upload
     * @param string $savePath Path tujuan save
     * @param int $maxWidth Lebar maksimal (default 1440)
     * @param int $maxHeight Tinggi maksimal (default 600)
     * @param int $quality Kualitas WebP 0-100 (default 85)
     */
    private function resizeAndSaveWebp($sourcePath, $savePath, $maxWidth = 1440, $maxHeight = 600, $quality = 85)
    {
        // Deteksi tipe gambar
        $imageInfo = getimagesize($sourcePath);
        $mimeType = $imageInfo['mime'];

        // Load gambar berdasarkan tipe
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                throw new \Exception('Format gambar tidak didukung');
        }

        // Dapatkan dimensi asli
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Hitung dimensi baru (maintain aspect ratio)
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        
        // Jangan perbesar gambar kecil
        if ($ratio > 1) {
            $ratio = 1;
        }

        $newWidth = (int)($originalWidth * $ratio);
        $newHeight = (int)($originalHeight * $ratio);

        // Buat canvas baru
        $resized = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency untuk PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefill($resized, 0, 0, $transparent);
        }

        // Resize
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        // Save as WebP
        imagewebp($resized, $savePath, $quality);

        // Cleanup
        imagedestroy($image);
        imagedestroy($resized);
    }
}