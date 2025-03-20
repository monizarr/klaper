<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('user') == null) {
            return redirect()->to('auth/sekolah/login');
        }

        return redirect()->to('sekolah/dashboard');
    }
}
