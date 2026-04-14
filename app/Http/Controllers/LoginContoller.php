<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
                'admin_nama' => $admin->nama_lengkap,
            ]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_username', 'admin_nama']);
        return redirect()->route('admin.login')->with('success', 'Logout berhasil');
    }
}