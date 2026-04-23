<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MachineController extends Controller
{
    public function index()
    {
        $machine = Machine::all();
        return view('backend.pages.machine', compact('machine'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'machine_title' => 'required|min:4',
            'machine_picture' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
        ],[
            'machine_title.required' => 'Title cannot be empty',
            'machine_title.min' => 'Input at least 4 characters for the title',
            'machine_picture.required' => 'Banner Picture cannot be empty',
            'machine_picture.image' => 'The file must be an image',
            'machine_picture.mimes' => 'File formats must be jpg, png, jpeg, webp',
            'machine_picture.max' => 'Maximum file size is 5MB'
        ]);

        $machine = new Machine;

        $machine->title = $request->machine_title;
       

        if($request->hasFile('machine_picture')){
            $file=$request->file('machine_picture');
            $ext = $file->getClientOriginalExtension() ?: $file->extension();
            $fileName=uniqid() . '.' . $ext;
            $file->storeAs('machine_picture', $fileName, 'public');
            $machine->image_url = $fileName;
        }

        $machine->save();

        session() -> flash('Success', 'Machine has been successfully added');
        return redirect('/dashboard/machine');
    }

    public function delete($id)
    {
        $machine = Machine::find($id);

        if($machine){
            $this->deleteImageFile($machine->image_url);
            $machine->delete();
            return redirect('/dashboard/machine')->with('Success', 'Machine has been successfully deleted');
        }
    }

     public function edit($id)
    {
        $machine = Machine::find($id);
        return view('backend.pages.editmachine', compact('machine'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_mesin' => 'required|min:3',
            'gambar_mesin' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nama_mesin.required' => 'Judul harus diisi',
            'gambar_mesin.image' => 'Harus foto/gambar',
            'nama_mesin.min' => 'Judul minimal 3 karakter',
            'gambar_mesin.mimes' => 'Format harus jpg/jpeg/png/webp',
            'gambar_mesin.max' => 'Ukuran maksimal 5Mb',
        ]);

        $machine = Machine::findOrFail($id);
        $machine->title = $request->nama_mesin;

        if ($request->hasFile('gambar_mesin')) {
            $file = $request->file('gambar_mesin');
            $ext = $file->getClientOriginalExtension() ?: $file->extension();
            $fileName = uniqid() . '.' . $ext;

            if ($machine->image_url) {
                $this->deleteImageFile($machine->image_url);
            }

            $file->storeAs('machine_picture', $fileName, 'public');
            $machine->image_url = $fileName;
        }

        $machine->save();

        session()->flash('success', 'Mesin berhasil diperbarui!');
        return redirect()->route('machine.index');
    }

    private function deleteImageFile($imagePath)
    {
        $fileName = basename($imagePath);

        $publicPath = public_path('storage/machine_picture/' . $fileName);
        $storagePath = storage_path('app/public/machine_picture' . $fileName);

        if(file_exists($publicPath)){
            unlink($publicPath);
        }

        if(file_exists($storagePath)){
            unlink($storagePath);
        }
    }
}
