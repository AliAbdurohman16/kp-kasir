<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('backend.password.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'password_old' => 'required|min:8',
            'password' => 'required|min:8|confirmed'
        ]);

        if (!Hash::check($request->password_old, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Kata sandi lama salah!');
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diubah!');
    }
}
