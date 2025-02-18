<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    public function index()
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data ruangan.');
            return redirect()->to('/peminjaman');
        }

        $model = model(RuanganModel::class);

        $data = [
            // Panggil getRuangan() TANPA parameter kedua (atau parameter kedua diisi 'false') untuk mendapatkan SEMUA ruangan (tanpa filter status)
            'ruangan' => $model->getRuangan(false, false), // Ubah di sini, tambahkan parameter kedua 'false'
            'title' => 'Ruangan archive',
        ];

        return view('templates/header', $data)
            . view('ruangan/index')
            . view('templates/footer');
    }

    public function view($id = null)
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data ruangan.');
            return redirect()->to('/peminjaman');
        }

        $model = model(RuanganModel::class);

        $data['ruangan'] = $model->getRuangan($id);

        if (empty($data['ruangan'])) {
            throw new PageNotFoundException('Cannot find the ruangan item: ' . $id);
        }

        $data['title'] = 'Detail Ruangan: ';

        return view('templates/header', $data)
            . view('ruangan/view')
            . view('templates/footer');
    }

    public function create()
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data ruangan.');
            return redirect()->to('/peminjaman');
        }

        helper('form');

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Buat Ruangan Baru'])
                . view('ruangan/create')
                . view('templates/footer');
        }

        // Ambil data dari form, termasuk 'status'
        $post = $this->request->getPost(['nama', 'status']);

        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validateData($post, [
                'nama' => 'required',
                'status' => 'required|in_list[Aktif,Nonaktif]', // Validasi status: required dan hanya boleh Aktif atau Nonaktif
            ])
        ) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Buat Ruangan Baru'])
                . view('ruangan/create')
                . view('templates/footer');
        }

        $model = model(RuanganModel::class);

        // Simpan data ke database, termasuk 'status'
        $model->save([
            'nama' => $post['nama'],
            'status' => $post['status'], // Simpan nilai status dari form
        ]);

        return view('templates/header', ['title' => 'Buat Ruangan Baru'])
            . view('ruangan/success')
            . view('templates/footer');
    }

    public function edit($id = null)
    {
        helper('form');

        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data ruangan.');
            return redirect()->to('/peminjaman');
        }

        $model = model(RuanganModel::class);
        $ruangan = $model->getRuangan($id);

        if (empty($ruangan)) {
            throw new PageNotFoundException('Tidak dapat menemukan data ruangan dengan ID: ' . $id);
        }

        $data['ruangan'] = $ruangan;
        $data['title'] = 'Edit Status Ruangan: ';

        return view('templates/header', $data)
            . view('ruangan/edit') // Load view edit.php
            . view('templates/footer');
    }

    public function update($id = null)
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan mengubah data ruangan.');
            return redirect()->to('/peminjaman');
        }

        helper('form');

        // Ambil data dari form, termasuk 'status'
        $post = $this->request->getPost(['nama', 'status']);

        // Validasi data
        if (
            !$this->validateData($post, [
                'status' => 'required|in_list[Aktif,Nonaktif]', // Validasi status: required dan hanya boleh Aktif atau Nonaktif
            ])
        ) {
            // Jika validasi gagal, kembali ke form edit dengan error
            return $this->edit($id); // Kembali ke method edit dan kirimkan error validasi
        }

        $model = model(RuanganModel::class);
        $ruangan = $model->getRuangan($id);
        if (empty($ruangan)) {
            throw new PageNotFoundException('Tidak dapat menemukan data ruangan dengan ID: ' . $id);
        }

        // Update data ruangan di database
        $model->update($id, [
            'status' => $post['status'], // Hanya update status
        ]);

        session()->setFlashdata('success', 'Status ruangan berhasil diubah.');
        return redirect()->to('/ruangan'); // Redirect ke halaman daftar ruangan setelah sukses update
    }

    public function delete($id = null)
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan menghapus data ruangan.');
            return redirect()->to('/peminjaman');
        }

        $model = model(RuanganModel::class);
        $ruangan = $model->getRuangan($id);

        if (empty($ruangan)) {
            throw new PageNotFoundException('Tidak dapat menemukan data ruangan dengan ID: ' . $id);
        }

        // Hapus data ruangan dari database
        $model->delete($id);

        session()->setFlashdata('success', 'Data ruangan berhasil dihapus.');
        return redirect()->to('/ruangan'); // Redirect ke halaman daftar ruangan setelah hapus sukses
    }
}
