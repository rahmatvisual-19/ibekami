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
            'gambar_jenis' => 'required|image|mimes:png,jpg,jpeg,webp|max:5120',
            
        ], [
            'nama_jenis.required' => 'Judul harus diisi',
            'gambar_jenis.required' => 'Gambar harus diisi',
            'nama_jenis.min' => 'Judul minimal 3 karakter',
            'gambar_jenis.mimes' => 'Format Gambar harus png/jpg/jpeg/webp',
            'gambar_jenis.image' => 'Harus foto/gambar',
            'gambar_jenis.max' => 'Ukuran maksimal 5Mb',
        ]);

        $jenis = new Type;
        $jenis->name = $request->nama_jenis;


        if ($request->hasFile('gambar_jenis')) {
            $file = $request->file('gambar_jenis');
            $ext = $file->getClientOriginalExtension() ?: $file->extension();
            $fileName = uniqid() . '.' . $ext;
            $file->storeAs('gambar_jenis', $fileName, 'public');
            $jenis->image_url = $fileName;
        }

        $jenis ->save();
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
            'gambar_jenis' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
        ], [
            'nama_jenis.required' => 'Judul harus diisi',
            'gambar_jenis.image' => 'Harus foto/gambar',
            'nama_jenis.min' => 'Judul minimal 3 karakter',
            'gambar_jenis.mimes' => 'Format Gambar harus png/jpg/jpeg/webp',
            'gambar_jenis.max' => 'Ukuran maksimal 5Mb',
        ]);

        $jenis = Type::findOrFail($id);
        $jenis->name = $request->nama_jenis;

        if ($request->hasFile('gambar_jenis')) {
            $file = $request->file('gambar_jenis');
            $ext = $file->getClientOriginalExtension() ?: $file->extension();
            $fileName = uniqid() . '.' . $ext;

            if ($jenis->image_url) {
                $this->deleteImageFile($jenis->image_url);
            }

            $file->storeAs('gambar_jenis', $fileName, 'public');
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
}
