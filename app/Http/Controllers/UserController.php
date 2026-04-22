<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function daftaruser() {
        $users = User::all();
        return view('backend.pages.user', compact('users'));
    }

    public function index()
    {
        return view('backend.pages.TambahUser');
    }

    public function create(Request $request)
    {
        $request->validate([
            'username_user' => 'required|min:3',
            'name_user' => 'required|min:3',
            'password_user' => 'required|min:4',
        ], [
            'username_user.required' => 'Username harus diisi',
            'name_user.required' => 'Name harus diisi',
            'password_user.min' => 'Password minimal 4 karakter'
        ]);

        $user = new User;
        $user->username = $request->username_user;
        $user->name = $request->name_user; 
        $user->password = Hash::make($request->password_user); 

        $user->save();

        session()->flash('success', 'User berhasil ditambahkan!');
        
        return redirect('/dashboard/Daftar-User');
    }

    public function delete($username)
    {
        $user = User::where('username', $username)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'User tidak ditemukan!');
    }
        $user->delete();

        return redirect('/dashboard/Daftar-User')->with('delete', 'Kamu berhasil menghapus!');
    }

    public function edit($username)
    {
        $users = User::find($username);
        return view('backend.pages.EditUser', compact('users'));
    }

    public function update(Request $request, $username) {

        $validated = $request->validate([
            'username_user' => 'required|min:3',
            'name_user' => 'required|min:3',
            'password_user' => 'required|min:4',
        ], [
            'username_user.required' => 'Username harus diisi',
            'name_user.required' => 'Name harus diisi',
            'password_user.min' => 'Password minimal 4 karakter'
        ]);

    
        $user = User::findOrFail($username);
        $user->username = $request->username_user;
        $user->name = $request->name_user;
        $user->password = Hash::make($request->password_user); 

        $user->save();
    
        session()->flash('success', 'User berhasil diperbarui!');
    
        return redirect()->route('user.index');
    }
}
