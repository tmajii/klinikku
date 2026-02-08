<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $userModel = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username atau email
        $user = $userModel->where('username', $username)
                         ->orWhere('email', $username)
                         ->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Cek apakah user aktif
                if ($user['is_active'] == 1) {
                    // Update last login
                    $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
                    
                    // Get user with role
                    $userData = $userModel->getUserWithRole($user['id']);
                    
                    // Set session
                    $sessionData = [
                        'user_id' => $userData['id'],
                        'username' => $userData['username'],
                        'email' => $userData['email'],
                        'full_name' => $userData['full_name'],
                        'role_id' => $userData['role_id'],
                        'role_name' => $userData['role_name'],
                        'logged_in' => true
                    ];
                    session()->set($sessionData);
                    
                    return redirect()->to('/')->with('success', 'Login berhasil! Selamat datang ' . $userData['full_name']);
                } else {
                    return redirect()->back()->with('error', 'Akun Anda tidak aktif');
                }
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout');
    }
}
