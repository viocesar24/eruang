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

        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $modelPegawai = model(PegawaiModel::class);
            $user = $userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password_hash'])) {
                $pegawai = $modelPegawai->where('id', $user['pegawai_id'])->first();
                // Login successful
                session()->set('user_id', $user['id']);
                session()->set('pegawai_id', $user['pegawai_id']);
                session()->set('pegawai_id_user', $pegawai['nama']);
                session()->setFlashdata('loginBerhasil', 'Anda Berhasil Masuk. Selamat Melakukan Peminjaman Ruangan!');
                return redirect()->to('/peminjaman');
            } else {
                // Login failed
                session()->setFlashdata('error', 'Username atau Password Salah.');
            }
        }

        return view('templates/header')
            . view('user/login')
            . view('templates/footer');
    }

    public function signup()
    {
        if (session()->get('user_id') !== null) {
            return redirect()->to('/peminjaman');
        }

        helper('form');

        if ($this->request->getMethod() == 'post') {

            // Menambahkan fungsi validateData untuk memvalidasi input dari form
            $rules = [
                'username' => 'required|is_unique[users.username]',
                'password' => 'required|min_length[3]',
                'pegawai_id' => 'required|is_unique[users.pegawai_id]'
            ];

            if ($this->validate($rules)) {
                // Input valid
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $pegawai_id = $this->request->getPost('pegawai_id');

                $userModel = model(UserModel::class);

                // Mengecek jika pegawai_id valid
                // Mengambil data pegawai dari database
                $modelPegawai = model(PegawaiModel::class);
                $pegawai = $modelPegawai->where('id', $pegawai_id)->first();

                // Jika data pegawai tidak ditemukan, maka input tidak valid
                if ($pegawai == null) {
                    session()->setFlashdata('error', 'Pegawai ID tidak valid.');
                    return redirect()->to('/signup');
                }

                // Menyimpan data user ke database
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
                    session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data user.');
                }
            } else {
                // Input tidak valid
                session()->setFlashdata('error', $this->validator->listErrors());
            }
        }

        if (session()->get('user_id') !== null) {
            return redirect()->to('/');
        }

        $modelPegawai = model(PegawaiModel::class);
        $modelUser = model(UserModel::class);

        // Dapatkan semua pegawai_id dari tabel User
        $user_ids = array_column($modelUser->getUser(), 'pegawai_id');

        // Filter pegawai berdasarkan pegawai_id
        $filtered_pegawai = array_filter($modelPegawai->getPegawai(), function ($item) use ($user_ids) {
            // Hanya kembalikan elemen yang pegawai_id tidak ada di $user_ids
            return !in_array($item['id'], $user_ids);
        });

        return view('templates/header', ['filtered_pegawai' => $filtered_pegawai])
            . view('user/signup')
            . view('templates/footer');
    }

    public function changePassword()
    {
        $model = model(UserModel::class);

        $old_password = $this->request->getPost('old_password');
        $new_password = $this->request->getPost('new_password');
        $confirm_password = $this->request->getPost('confirm_password');

        if ($new_password !== $confirm_password) {
            // The passwords do not match
            session()->setFlashData('error', 'Password tidak sama.');
            return redirect()->back();
        }

        $user = $model->getUserWithPegawai(session()->get('user_id'));

        if (!password_verify($old_password, $user['password_hash'])) {
            // The old password is incorrect
            session()->setFlashData('error', 'Password lama salah.');
            return redirect()->back();
        }

        $model->gantiPassword(session()->get('user_id'), $new_password);

        session()->remove('user_id');
        session()->setFlashData('success', 'Password Anda berhasil diganti. Silahkan masuk lagi dengan password yang baru.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/peminjaman');
    }
}