<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\PegawaiModel;

class Pegawai extends BaseController
{
    public function index()
    {
        $model = model(PegawaiModel::class);

        $data = [
            'pegawai'  => $model->getPegawai(),
            'title' => 'Pegawai archive',
        ];

        return view('templates/header', $data)
            . view('pegawai/index')
            . view('templates/footer');
    }

    public function view($id = null)
    {
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
        if (!$this->validateData($post, [
            'nama'  => 'required',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Create a pegawai item'])
                . view('pegawai/create')
                . view('templates/footer');
        }

        $model = model(PegawaiModel::class);

        $model->save([
            'nama'  => $post['nama'],
        ]);

        return view('templates/header', ['title' => 'Create a pegawai item'])
            . view('pegawai/success')
            . view('templates/footer');
    }
}
