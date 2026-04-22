<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;

class KategoriController extends Controller
{
    public function index() {
        $jenis = Type::all();
        return view('backend.pages.isikategori', compact('jenis'));
    }

    public function daftarkategori() {
        $kategoris = Category::all();
        return view('backend.pages.kategori', compact('kategoris'));
    }

    public function create(Request $request) {
        $request->validate([
            'jenis_produk' => 'required',
            'nama_kategori' => 'required',
        ], [
            'jenis_produk.required' => 'Jenis produk harus dipilih',
            'nama_kategori.required' => 'Kategori produk harus diisi',
        ]);
        
        $kategori = new Category();
        $kategori->type_id = $request->jenis_produk;
        $kategori->name = $request->nama_kategori;

        $kategori->save();

        session()->flash('success', 'Kategori berhasil ditambahkan!');
        
        return redirect('/dashboard/kategori-product');
    }

    public function delete($id)
    {
        $kategoris = Category::find($id);
        $kategoris->delete();

        return redirect('/dashboard/kategori-product')->with('delete', 'Kamu berhasil menghapus!');
    }

    public function edit($id)
    {
        $jenis = Type::all();
        $kategoris = Category::find($id);
        return view('backend.pages.editkategori', compact('kategoris', 'jenis'));
    }

    public function update(Request $request, $id) {

        $validated = $request->validate([
            'jenis_produk' => 'required',
            'nama_kategori' => 'required',
        ], [
            'jenis_produk.required' => 'Jenis produk harus dipilih',
            'nama_kategori.required' => 'Kategori produk harus diisi',
        ]);
    
        $kategori = Category::findOrFail($id);
        $kategori->type_id = $request->jenis_produk;
        $kategori->name = $request->nama_kategori;
    
        $kategori->save();
    
        session()->flash('success', 'Kategori berhasil diperbarui!');
    
        return redirect()->route('kategori.index');
    }   
}
