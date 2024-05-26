<?php

namespace App\Http\Controllers;

use App\Models\M_users;
use Illuminate\Http\Request;

class Controller_users extends Controller
{
    //
    public function show()
    {
        $title = 'Kelola Users';
        $users = M_users::where('role', 'pengunjung')->paginate(5);
        return view('admin.users.index', compact('title', 'users'));
    }
    public function edit($id)
    {
        $title = 'Kelola Users';
        $user = M_users::findOrFail($id);
        return view('admin.users.edit', compact('title', 'user'));
    }
    public function create(Request $request)
    {
        $dataValidate = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:3',
        ]);

        $dataValidate['password'] = bcrypt($dataValidate['password']);
        $dataValidate['role'] = 'pengunjung';
        M_users::create($dataValidate);

        // Redirect dengan pesan sukses
        return redirect()->route('user')->with('success', 'Data ' . $request->username . ' berhasil ditambahkan');
    }

    public function update(Request $request, M_users $user)
    {
        $dataValidate = $request->validate([
            'username' => "required|string|max:255|unique:users,username,{$user->id}",
            'password' => 'required|string',
        ]);
        $user->username = $dataValidate['username'];
        if ($request->filled('password')) {
            $user->password = bcrypt($dataValidate['password']); // Mengenkripsi password jika diperbarui
        }
        $user->save();
        return redirect()->route('user')->with('success', 'User berhasil diperbarui!');
    }

    public function delete($id)
    {
        $user = M_users::findOrFail($id);
        $user->delete();
        redirect()->route('user')->with('success', 'user telah di hapus');
    }
}
