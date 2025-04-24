<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserApp as ModelUserApp;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Sekolah as ModelSekolah;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('user') && session()->get('user')["isLoggedIn"]) {
            return redirect()->to('/sekolah/dashboard');
        }

        return view('auth/index');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $sekolahModel = new ModelSekolah();
        $user = $sekolahModel->where('username', $username)->first();

        if (!isset($user)) {
            return redirect()->to('/auth/sekolah/login')->withInput()->with('error', 'Username tidak ditemukan');
        }

        if ($user['status'] == 'a') {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'isLoggedIn' => true,
                    'sekolah' => $user
                ];
                session()->set('user', $data);
                return redirect()->to('/sekolah/dashboard');
            }
        } else {
            return redirect()->to('/auth/sekolah/login')->withInput()->with('error', 'Status sekolah tidak aktif');
        }
        return redirect()->to('/auth/sekolah/login')->withInput()->with('error', 'Login failed');
    }

    public function loginAdmin()
    {
        if (session()->get('user') && session()->get('user')["isLoggedIn"]) {
            return redirect()->to('/admin/dashboard');
        }

        return view('auth/index');
    }

    public function storeLoginAdmin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new ModelUserApp();
        $user = $userModel->where('username', $username)->first();

        if (!isset($user)) {
            return redirect()->to('/admin/login')->withInput()->with('error', 'Username tidak ditemukan');
        }

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'isLoggedIn' => true
                ];

                session()->set('user', $data);
                return redirect()->to('/admin/dashboard');
            }
        }

        return redirect()->to('/admin/login')->withInput()->with('error', 'Login failed');
    }

    public function sekolahLogout()
    {
        session()->destroy();
        return redirect()->to('/auth/sekolah/login');
    }

    public function adminLogout()
    {
        session()->destroy();
        return redirect()->to('/auth/admin/login');
    }
}
