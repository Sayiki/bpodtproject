<?php

namespace App\Controllers;


class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function validate_login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi login (contoh sederhana, ganti dengan validasi sebenarnya)
        if ($username == 'admin' && $password == 'password') {
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

}

    