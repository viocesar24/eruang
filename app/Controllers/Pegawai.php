<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\PeminjamanModel;

class Pegawai extends BaseController
{
    public function index()
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data pegawai.');
            return redirect()->to('/peminjaman');
        }

        $model = model(PegawaiModel::class);

        $data = [
            'pegawai' => $model->getPegawai(),
            'title' => 'Pegawai archive',
        ];

        return view('templates/header', $data)
            . view('pegawai/index')
            . view('templates/footer');
    }

    public function view($id = null)
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data pegawai.');
            return redirect()->to('/peminjaman');
        }

        $model = model(PegawaiModel::class);

        $data['pegawai'] = $model->getPegawai($id);

        if (empty($data['pegawai'])) {
            throw new PageNotFoundException('Cannot find the pegawai item: ' . $id);
        }

        $data['title'] = 'Detail Pegawai: ';

        return view('templates/header', $data)
            . view('pegawai/view')
            . view('templates/footer');
    }

    public function create()
    {
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            // Session tidak ada atau tidak sama dengan 58 dan 35, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda tidak diperkenankan melihat data pegawai.');
            return redirect()->to('/peminjaman');
        }

        helper('form');

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Create a pegawai item'])
                . view('pegawai/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['nama']);

        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validateData($post, [
                'nama' => 'required',
            ])
        ) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Create a pegawai item'])
                . view('pegawai/create')
                . view('templates/footer');
        }

        $model = model(PegawaiModel::class);

        $model->save([
            'nama' => $post['nama'],
        ]);

        return view('templates/header', ['title' => 'Create a pegawai item'])
            . view('pegawai/success')
            . view('templates/footer');
    }

    public function delete()
    {
        helper('form');

        // Cek apakah session pegawai_id ada dan apakah memiliki nilai 58 atau 35
        if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            session()->setFlashdata('pegawaiError', 'Anda tidak diperkenankan menghapus data pegawai.');
            return redirect()->to('/peminjaman');
        }

        $modelPegawai = model(PegawaiModel::class);
        $modelPeminjaman = model(PeminjamanModel::class);
        $modelUser = model(UserModel::class);

        // Cek apakah metode request adalah POST dan validasi input
        if ($this->request->getMethod() === 'post' && $this->validate(['id' => 'required|is_natural_no_zero'])) {
            $id = $this->request->getPost('id');

            // Cek apakah ID pegawai ada di database sebelum menghapus
            if ($modelPegawai->find($id) !== null) {
                // Cek apakah ID pegawai ada di tabel Peminjaman sebelum menghapus
                if ($modelPeminjaman->where('id_pegawai', $id)->first()) {
                    // Hapus data terkait dari tabel peminjaman
                    $modelPeminjaman->where('id_pegawai', $id)->delete();
                }

                // Cek apakah ID pegawai ada di tabel User sebelum menghapus
                if ($modelUser->where('pegawai_id', $id)->first()) {
                    // Hapus data terkait dari tabel user
                    $modelUser->where('pegawai_id', $id)->delete();
                }

                // Hapus data pegawai
                $modelPegawai->delete($id);

                // Cek apakah ada error saat penghapusan
                if ($modelPegawai->errors()) {
                    session()->setFlashdata('pegawaiError', 'Terjadi kesalahan saat penghapusan');
                    return redirect()->to('/pegawai');
                }

                session()->setFlashdata('pegawaiSuccess', 'Data pegawai dan data terkait berhasil dihapus.');
            } else {
                session()->setFlashdata('pegawaiError', 'ID pegawai tidak ditemukan.');
            }
            return redirect()->to('/pegawai');
        } else {
            // Jika bukan POST atau validasi gagal, arahkan kembali ke halaman pegawai
            return redirect()->to('/pegawai');
        }
    }
}
