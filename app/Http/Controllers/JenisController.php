<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;


class JenisController extends Controller
{
    public function daftarjenis(){
        $jeniss = Type::all();
        return view('backend.pages.jenisproduk',compact('jeniss'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|min:3',
            'gambar_jenis' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048|dimensions:max_width=800,max_height=400',
            
        ], [
            'nama_jenis.required' => 'Judul harus diisi',
            'gambar_jenis.required' => 'Gambar harus diisi',
            'nama_jenis.min' => 'Judul minimal 3 karakter',
            'gambar_jenis.mimes' => 'Format Gambar harus png/jpg/jpeg/webp',
            'gambar_jenis.image' => 'Harus foto/gambar',
            'gambar_jenis.max' => 'Ukuran maksimal 2MB',
            'gambar_jenis.dimensions' => 'Resolusi maksimal 800x400 px',
        ]);

        $jenis = new Type;
        $jenis->name = $request->nama_jenis;

        if ($request->hasFile('gambar_jenis')) {
            // Resize & compress gambar ke 400x200 max, save as WebP
            $fileName = uniqid() . '.webp';
            $savePath = storage_path('app/public/gambar_jenis/' . $fileName);
            
            $this->resizeAndSaveWebp($request->file('gambar_jenis')->getRealPath(), $savePath, 400, 200, 85);
            
            $jenis->image_url = $fileName;
        }

        $jenis->save();
        session()->flash('success', 'Kategori berhasil ditambahkan!');
        
        return redirect('/dashboard/jenis-produk');
    
    }
    public function delete($id)
    {
        $jeniss = Type::find($id);
        
        if ($jeniss) {
            $this->deleteImageFile($jeniss->image_url);
            $jeniss->delete();
            return redirect('/dashboard/jenis-produk')->with('delete', 'Kamu berhasil menghapus!');
        }

    }
    public function edit($id)
    {
        $jeniss = Type::find($id);
        return view('backend.pages.editJenis', compact('jeniss'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|min:3',
            'gambar_jenis' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048|dimensions:max_width=800,max_height=400',
        ], [
            'nama_jenis.required' => 'Judul harus diisi',
            'gambar_jenis.image' => 'Harus foto/gambar',
            'nama_jenis.min' => 'Judul minimal 3 karakter',
            'gambar_jenis.mimes' => 'Format Gambar harus png/jpg/jpeg/webp',
            'gambar_jenis.max' => 'Ukuran maksimal 2MB',
            'gambar_jenis.dimensions' => 'Resolusi maksimal 800x400 px',
        ]);

        $jenis = Type::findOrFail($id);
        $jenis->name = $request->nama_jenis;

        if ($request->hasFile('gambar_jenis')) {
            if ($jenis->image_url) {
                $this->deleteImageFile($jenis->image_url);
            }

            // Resize & compress gambar ke 400x200 max, save as WebP
            $fileName = uniqid() . '.webp';
            $savePath = storage_path('app/public/gambar_jenis/' . $fileName);
            
            $this->resizeAndSaveWebp($request->file('gambar_jenis')->getRealPath(), $savePath, 400, 200, 85);
            
            $jenis->image_url = $fileName;
        }

        $jenis->save();

        session()->flash('success', 'Jenis produk berhasil diperbarui!');
        return redirect()->route('jenis.index');
    }

    private function deleteImageFile($imagePath)
    {
        $filename = basename($imagePath);

        $publicPath = public_path('storage/gambar_jenis/' . $filename);
        $storagePath = storage_path('app/public/gambar_jenis/' . $filename);

        if (file_exists($publicPath)) {
            unlink($publicPath);
        }

        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
    }

    /**
     * Resize gambar dan save sebagai WebP dengan kualitas optimal
     * 
     * @param string $sourcePath Path file upload
     * @param string $savePath Path tujuan save
     * @param int $maxWidth Lebar maksimal (default 400)
     * @param int $maxHeight Tinggi maksimal (default 200)
     * @param int $quality Kualitas WebP 0-100 (default 85)
     */
    private function resizeAndSaveWebp($sourcePath, $savePath, $maxWidth = 400, $maxHeight = 200, $quality = 85)
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
