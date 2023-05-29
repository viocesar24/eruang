<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{

    public function index()
    {
        $userModel = new UserModel();
        $user = $userModel->getUser();

        if (empty($user)) {
            // User is not logged in, redirect to login page
            return redirect()->to('/peminjaman');
        }

        $data = [
            'user' => $user,
            'title' => 'Daftar User:',
        ];

        return view('templates/header', $data)
            . view('user/view')
            . view('templates/footer');
    }

    public function profile($id = null)
    {
        $model = model(UserModel::class);
        $id = session()->get('user_id');
        $data['user'] = $model->getUserWithPegawai($id);

        if (empty($data['user'])) {
            throw new PageNotFoundException('Cannot find the user item: ' . $id);
        }

        $data['title'] = 'Detail User: ';

        return view('templates/header', $data)
            . view('user/profile')
            . view('templates/footer');
    }

    public function login()
    {
        if (session()->get('user_id') !== null) {
            return redirect()->to('/peminjaman');
        }

        helper('form');

        $data = [];
        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Login successful
                session()->set('user_id', $user['id']);
                session()->set('pegawai_id', $user['pegawai_id']);
                session()->setFlashdata('loginBerhasil', 'Anda Berhasil Masuk. Selamat Melakukan Booking Ruangan!');
                return redirect()->to('/peminjaman');
            } else {
                // Login failed
                session()->setFlashdata('error', 'Username atau Password Salah.');
            }
        }

        return view('templates/header', $data)
            . view('user/login')
            . view('templates/footer');
    }

    public function signup()
    {
        if (session()->get('user_id') !== null) {
            return redirect()->to('/peminjaman');
        }

        helper('form');

        $data = [];
        if ($this->request->getMethod() == 'post') {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $pegawai_id = $this->request->getPost('pegawai_id');

            $userModel = new UserModel();
            // Cek apakah username dan nama pegawai sudah digunakan
            $user = $userModel->where('username', $username)->first();
            $userIDPegawai = $userModel->where('pegawai_id', $pegawai_id)->first();
            if ($user) {
                // Username sudah digunakan
                session()->setFlashdata('error', 'Username Sudah Digunakan.');
            } elseif ($userIDPegawai) {
                // ID Pegawai sudah digunakan
                session()->setFlashdata('error', 'Nama Pegawai Sudah Digunakan.');
            } else {
                // Username belum digunakan
                if (
                    $userModel->insert([
                        'username' => $username,
                        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                        'pegawai_id' => $pegawai_id,
                    ])
                ) {
                    // Signup successful
                    session()->setFlashdata('signupBerhasil', 'Pendaftaran Berhasil. Silahkan Masuk dengan Memasukkan Username dan Kata Sandi Anda.');
                    return redirect()->to('/login');
                } else {
                    // Signup failed
                    session()->setFlashdata('error', 'Item Peminjaman telah berhasil diubah.');
                }
            }
        }

        if (session()->get('user_id') !== null) {
            return redirect()->to('/');
        }

        $modelPegawai = model(PegawaiModel::class);

        $data = [
            'pegawai' => $modelPegawai->getPegawai(),
        ];

        return view('templates/header', $data)
            . view('user/signup')
            . view('templates/footer');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/peminjaman');
    }
}