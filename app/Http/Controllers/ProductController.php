<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Type;


class ProductController extends Controller
{
    public function index(): View
    {   
        $products = Product::with(['type', 'category'])->get()->map(function($product) {
            $product->type_name     = $product->type->name     ?? 'N/A';
            $product->category_name = $product->category->name ?? 'N/A';
            return $product;
        });
        return view('backend.pages.Product', compact('products'));
    }

    public function create()
    {
        $jenis=Type::with('categories')->get();
        return view('backend.pages.tambahproduct', compact('jenis'));
    }

    public function store(Request $request)
    {
        //Validate Input
        $request->validate(
            [
                'nama_produk' => 'required|string|max:255',
                'jenis_produk' => 'required|exists:types,id',
                'kategori_produk' => 'required|exists:categories,id',
                'deskripsi_produk' => 'required|string',
                'gambar_produk' => 'required|array',
                'gambar_produk.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
            ],
            [
                'nama_produk.required' => 'Nama Produk Tidak Boleh Kosong !',
                'jenis_produk.required' => 'Jenis Produk Tidak Boleh Kosong !',
                'kategori_produk.required' => 'Kategori Produk Tidak Boleh Kosong !',
                'deskripsi_produk.required' => 'Deskripsi Produk Tidak Boleh Kosong !',
                'gambar_produk.required' => 'Gambar Produk Tidak Boleh Kosong !',
                'gambar_produk.*.image' => 'Semua file harus berupa gambar !',
                'gambar_produk.*.mimes' => 'Format gambar harus: png, jpg, jpeg, webp !',
                'gambar_produk.*.max' => 'Ukuran maksimal 5Mb !'
            ],
        );

        $details = [];

        foreach ($request->input('details', []) as $detail) {
            if (!empty($detail['key']) && !empty($detail['value'])) {
                $details[$detail['key']] = $detail['value'];
            }
        }

        $imagePaths = [];
        
        $type_name = Category::find($request->kategori_produk)->name ?? "";

        foreach ($request->file('gambar_produk') as $image) {
            // Use extension derived from actual MIME type to guarantee .webp when converted
            $ext = $image->getClientOriginalExtension() ?: $image->extension();
            $filename = $type_name . '_' . uniqid() . '.' . $ext;
            $image->storeAs('gambar_produk', $filename, 'public');
            $imagePaths[] = $filename;
        }

        Product::create([
            'name' => $request->nama_produk,
            'product_type' => $request->jenis_produk,
            'category_type' => $request->kategori_produk,
            'description' => $request->deskripsi_produk,
            'status' => $request->status,
            'detail' => $details,
            'image_url' => $imagePaths
        ]);

        session()->flash('success', 'Daftar barang berhasil ditambahkan!');
        return redirect('dashboard/daftar-product');
    }

    public function delete($product_id)
    {
        $product = Product::find($product_id);

        if (!$product) {
            return redirect('dashboard/daftar-product')->with('delete', 'Produk tidak ditemukan!');
        }

        $images = $product->image_url;

        if ($images) {
            $imagePaths = is_array($images) ? $images : json_decode($images, true);

            foreach ($imagePaths as $imagePath) {
                $this->deleteImageFile($imagePath);
            }
        }

        $product->delete();
        return redirect('dashboard/daftar-product')->with('delete', 'Kamu berhasil menghapus!');
    }

    public function edit($product_id)
    {
        $jenis = Type::all();
        $category = Category::all();
        $product = Product::find($product_id);
        return view('backend.pages.editproduk', compact('product', 'category', 'jenis'));
    }

    public function update(Request $request, $product_id)
    {
        $validated = $request->validate([
            'jenis_produk' => 'required',
            'kategori_produk' => 'required',
            'nama_produk' => 'required',
            'deskripsi_produk' => 'required',
        ], [
            'jenis_produk.required' => 'Jenis produk tidak boleh kosong !',
            'kategori_produk.required' => 'Kategori produk tidak boleh kosong !',
            'nama_produk.required' => 'Nama produk tidak boleh kosong !',
            'deskripsi_produk.required' => 'Deskripsi produk tidak boleh kosong !',
        ]);

        $product = Product::findOrFail($product_id);
        $product->product_type = $request->jenis_produk;
        $product->category_type = $request->kategori_produk;
        $product->name = $request->nama_produk;
        $product->description = $request->deskripsi_produk;
        $product->status = $request->status;

        $details = [];

        foreach ($request->input('details', []) as $detail) {
            if (!empty($detail['key']) && !empty($detail['value'])) {
                $details[$detail['key']] = $detail['value'];
            }
        }

        $product->detail = $details;

        $currentImages = $product->image_url ?? [];

        $remainingImages = [];
        foreach ($currentImages as $image) {
            if ($this->imageExistsInRequest($image, $request)) {
                $remainingImages[] = $image;
            } else {
                $this->deleteImageFile($image);
            }
        }

        $newImagePaths = [];
        
        $type_name = Category::find($request->kategori_produk)->name ?? "";
        
        if ($request->hasFile('gambar_produk')) {
            foreach ($request->file('gambar_produk') as $image) {
                $ext = $image->getClientOriginalExtension() ?: $image->extension();
                $filename = $type_name . '_' . uniqid() . '.' . $ext;
                $image->storeAs('gambar_produk', $filename, 'public');
                $newImagePaths[] = $filename;
            }
        }

        $product->image_url = array_merge($remainingImages, $newImagePaths);
        $product->save();

        session()->flash('success', 'Daftar barang berhasil diedit !');
        return redirect('dashboard/daftar-product');
    }

    private function imageExistsInRequest($imagePath, $request)
    {
        $filename = basename($imagePath);
        $remainingImageNames = $request->input('remaining_images', []);

        if (is_string($remainingImageNames)) {
            $remainingImageNames = json_decode($remainingImageNames, true) ?: [];
        }

        return in_array($filename, $remainingImageNames);
    }

    private function deleteImageFile($imagePath)
    {
        $filename = basename($imagePath);

        $publicPath = public_path('storage/gambar_produk/' . $filename);
        $storagePath = storage_path('app/public/gambar_produk/' . $filename);

        if (file_exists($publicPath)) {
            unlink($publicPath);
        }

        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
    }
    
    public function orderClickIncrement(Request $request)
    {
        $product = Product::find($request->product_id);

        $product->increment('order_click_count');
    }
}

