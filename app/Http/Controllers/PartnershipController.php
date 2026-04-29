<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class PartnershipController extends Controller
{
    public function indexPartner()
    {
        $partner = Partnership::all();
        return view('backend.pages.partner', compact('partner'));
    }

    public function store(Request $request)
    {
        //Validate
        $request->validate([
            'category' => 'required',
            'gambar_partner' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048|dimensions:max_width=800,max_height=400'
        ],[
            'category.required' => 'Jenis partner tidak boleh kosong',
            'gambar_partner.required' => 'Gambar Partner Tidak Boleh Kosong !',
            'gambar_partner.image' => 'Format File Harus Berupa Gambar !',
            'gambar_partner.mimes' => 'Format harus png/jpg/jpeg/webp !',
            'gambar_partner.max' => 'Ukuran File Gambar Maksimal 2MB !',
            'gambar_partner.dimensions' => 'Resolusi maksimal 800x400 px !',
        ]);

        $partners = new Partnership;
        $partners->category = $request->category;

        if($request->hasFile('gambar_partner'))
        {
            // Resize & compress gambar ke 400x200 max, save as WebP
            $fileName = uniqid() . '.webp';
            $savePath = storage_path('app/public/gambar_partner/' . $fileName);
            
            $this->resizeAndSaveWebp($request->file('gambar_partner')->getRealPath(), $savePath, 400, 200, 85);
            
            $partners->image_url = $fileName;
        }

        $partners->save();

        // Clear cache setelah tambah partner
        \App\Helpers\CacheHelper::clearPartnerCache();

        session()->flash('success', 'Partner berhasil ditambahkan!');
        
        return redirect('/dashboard/partnership');
    }

    public function delete($id)
    {
        $partnerd = Partnership::find($id);

        if($partnerd)
        {
            $this->deleteImageFile($partnerd->image_url);
            $partnerd->delete();
            
            // Clear cache setelah hapus partner
            \App\Helpers\CacheHelper::clearPartnerCache();
            
            return redirect('/dashboard/partnership')->with('delete', 'Kamu berhasil menghapus!');
        }
    }

    public function edit($id)
    {
        $partner = Partnership::find($id);
        return view('backend.pages.editpartner', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category' => 'required',
            'gambar_partner' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048|dimensions:max_width=800,max_height=400'
        ],[
            'category.required' => 'Jenis partner tidak boleh kosong',
            'gambar_partner.image' => 'Format File Harus Berupa Gambar !',
            'gambar_partner.mimes' => 'Format harus png/jpg/jpeg/webp !',
            'gambar_partner.max' => 'Ukuran File Gambar Maksimal 2MB !',
            'gambar_partner.dimensions' => 'Resolusi maksimal 800x400 px !',
        ]);

        $partner = Partnership::findOrfail($id);
        $partner->category = $request->category;

        if($request->hasFile('gambar_partner'))
        {
            if ($partner->image_url) {
                $this->deleteImageFile($partner->image_url);
            }
            
            // Resize & compress gambar ke 400x200 max, save as WebP
            $fileName = uniqid() . '.webp';
            $savePath = storage_path('app/public/gambar_partner/' . $fileName);
            
            $this->resizeAndSaveWebp($request->file('gambar_partner')->getRealPath(), $savePath, 400, 200, 85);
            
            $partner->image_url = $fileName;
        }

        $partner->save();

        // Clear cache setelah update partner
        \App\Helpers\CacheHelper::clearPartnerCache();

        session()->flash('success', 'Partner berhasil diperbaharui!');
        
        return redirect()->route('partner');
    }

    private function deleteImageFile($imagePath)
    {
        $filename = basename($imagePath);

        $publicPath = public_path('storage/gambar_partner/' . $filename);
        $storagePath = storage_path('app/public/gambar_partner/' . $filename);

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
