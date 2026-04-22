<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::all();
        return view('backend.pages.banner', compact('banner'));
    }

    public function create(Request $request)
    {
        // Validasi disesuaikan: hapus teks, hapus aturan 'image', tambahkan ekstensi video, naikkan max size ke 50MB (51200 KB)
        $request->validate([
            'banner_picture' => 'required|mimes:jpg,jpeg,png,webp,mp4,webm,ogg|max:51200'
        ],[
            'banner_picture.required' => 'Media cannot be empty',
            'banner_picture.mimes' => 'File formats must be jpg, png, jpeg, webp, mp4, webm, or ogg',
            'banner_picture.max' => 'Maximum file size is 50MB'
        ]);

        $banner = new Banner;

        // Berikan nilai string kosong karena form sudah tidak mengirimkan data ini
        $banner->title = '';
        $banner->description = '';
        $banner->alt = '';

        if($request->hasFile('banner_picture')){
            $file=$request->file('banner_picture');
            $fileName=uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('banner_picture', $fileName, 'public');
            $banner->image_url = $fileName;
        }

        $banner->save();

        session() -> flash('Success', 'Media has been successfully added');
        return redirect('/dashboard/banner');
    }

    public function delete($id)
    {
        $banner = Banner::find($id);

        if($banner){
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
            // Ubah menjadi nullable agar admin tidak wajib re-upload file jika hanya ingin update hal lain (kalau ada)
            'banner_picture' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,webm,ogg|max:51200'
        ],[
            'banner_picture.mimes' => 'File formats must be jpg, png, jpeg, webp, mp4, webm, or ogg',
            'banner_picture.max' => 'Maximum file size is 50MB'
        ]);

        $banner = Banner::findOrFail($id);

        if($request->hasFile('banner_picture')){
            $file=$request->file('banner_picture');
            $fileName=uniqid() . '.' . $file->getClientOriginalExtension();

            if($banner->image_url){
                $this->deleteImageFile($banner->image_url);
            }
            // FIX: Standardisasi path penyimpanan agar seragam dengan fungsi create
            $file->storeAs('banner_picture', $fileName, 'public');
            $banner->image_url = $fileName;
        }

        $banner->save();

        session() -> flash('Success', 'Media has been successfully edited');
        return redirect('/dashboard/banner');
    }

    private function deleteImageFile($imagePath)
    {
        $fileName = basename($imagePath);

        $publicPath = public_path('storage/banner_picture/' . $fileName);
        // Memperbaiki backslash yang kurang pada baris ini di kode sebelumnya
        $storagePath = storage_path('app/public/banner_picture/' . $fileName);

        if(file_exists($publicPath)){
            unlink($publicPath);
        }

        if(file_exists($storagePath)){
            unlink($storagePath);
        }
    }
}