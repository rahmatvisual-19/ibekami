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
        $request -> validate([
            'category' => 'required',
            'gambar_partner' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ],[
            'category.required' => 'Jenis partner tidak boleh kosong',
            'gambar_partner.required' => 'Gambar Partner Tidak Boleh Kosong !',
            'gambar_partner.image' => 'Format File Harus Berupa Gambar !',
            'gambar_partner.max' => 'Ukurang File Gambar Maksimal 2Mb !',
        ]);

        $partners = new Partnership;
        $partners->category = $request->category;

        if($request->hasFile('gambar_partner'))
        {
            $file=$request->file('gambar_partner');
            $fileName=uniqid() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('gambar_partner', $fileName, 'public');

            $partners->image_url = $fileName;
        }

        $partners->save();

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
            'gambar_partner' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ],[
            'category.required' => 'Jenis partner tidak boleh kosong',
            'gambar_partner.required' => 'Gambar Partner Tidak Boleh Kosong !',
            'gambar_partner.image' => 'Format File Harus Berupa Gambar !',
            'gambar_partner.max' => 'Ukurang File Gambar Maksimal 2Mb !',
        ]);

        $partner = Partnership::findOrfail($id);
        $partner->category = $request->category;

        if($request->hasFile('gambar_partner'))
        {
            $file=$request->file('gambar_partner');
            $fileName=uniqid() . '.' . $file->getClientOriginalExtension();

            if ($partner->image_url) {
                $this->deleteImageFile($partner->image_url);
            }
            
            $file->storeAs('public/gambar_partner', $fileName);

            $partner->image_url = $fileName;
        }

        $partner->save();

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
}
