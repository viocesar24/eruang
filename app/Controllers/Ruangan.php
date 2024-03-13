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
            'ruangan' => $model->getRuangan(),
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
            return view('templates/header', ['title' => 'Create a ruangan item'])
                . view('ruangan/create')
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
            return view('templates/header', ['title' => 'Create a ruangan item'])
                . view('ruangan/create')
                . view('templates/footer');
        }

        $model = model(RuanganModel::class);

        $model->save([
            'nama' => $post['nama'],
        ]);

        return view('templates/header', ['title' => 'Create a ruangan item'])
            . view('ruangan/success')
            . view('templates/footer');
    }
}
