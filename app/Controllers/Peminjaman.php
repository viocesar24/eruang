<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\PeminjamanModel;
use App\Models\PegawaiModel;
use App\Models\RuanganModel;

class Peminjaman extends BaseController
{
    // public function index()
    // {
    //     // KODE TAMBAHAN
    //     $db = \Config\Database::connect(); // Koneksi ke database
    //     $builder = $db->table('peminjaman'); // Pilih tabel peminjaman
    //     $builder->select('*'); // Pilih semua kolom
    //     $builder->join('pegawai', 'pegawai.id = peminjaman.id_pegawai'); // Join dengan tabel pegawai berdasarkan id_pegawai
    //     $builder->join('ruangan', 'ruangan.id = peminjaman.id_ruangan'); // Join dengan tabel ruangan berdasarkan id_ruangan
    //     $query = $builder->get(); // Eksekusi query
    //     $peminjaman = $query->getResultArray(); // Dapatkan hasil query sebagai array

    //     $data = [
    //         'peminjaman'  => $peminjaman, // Ganti dengan variabel yang berisi hasil query
    //         'title' => 'Peminjaman archive',
    //     ];

    //     return view('templates/header', $data)
    //         . view('peminjaman/index')
    //         . view('templates/footer');
    // }

    public function index()
    {
        $model = model(PeminjamanModel::class);

        $data = [
            'peminjaman'  => $model->getPeminjaman(),
            'title' => 'Peminjaman archive',
        ];

        return view('templates/header', $data)
            . view('peminjaman/index')
            . view('templates/footer');
    }

    public function view($id = null)
    {
        $model = model(PeminjamanModel::class);

        $data['peminjaman'] = $model->getPeminjaman($id);

        if (empty($data['peminjaman'])) {
            throw new PageNotFoundException('Cannot find the peminjaman item: ' . $id);
        }

        $data['title'] = 'Detail Peminjaman: ';

        return view('templates/header', $data)
            . view('peminjaman/view')
            . view('templates/footer');
    }

    public function create()
    {
        helper('form');

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
            // Mengambil data dari tabel Pegawai dan Ruangan
            $modelPegawai = model(PegawaiModel::class);
            $modelRuangan = model(RuanganModel::class);

            $data = [
                'pegawai'  => $modelPegawai->getPegawai(),
                'ruangan'  => $modelRuangan->getRuangan(),
                'title' => 'Buat ruangan',
            ];
            // The form is not submitted, so returns the form.
            return view('templates/header', $data)
                . view('peminjaman/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['id_pegawai', 'id_ruangan', 'tanggal', 'waktu_mulai', 'waktu_selesai']);

        // Checks whether the submitted data passed the validation rules.
        if (!$this->validateData($post, [
            'id_pegawai' => 'required',
            'id_ruangan' => 'required',
            'tanggal' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai'  => 'required',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Buat ruangan'])
                . view('peminjaman/create')
                . view('templates/footer');
        }

        $model = model(PeminjamanModel::class);

        $model->save([
            'id_pegawai' => $post['id_pegawai'],
            'id_ruangan' => $post['id_ruangan'],
            'tanggal' => $post['tanggal'],
            'waktu_mulai' => $post['waktu_mulai'],
            'waktu_selesai'  => $post['waktu_selesai'],
        ]);

        return view('templates/header', ['title' => 'Buat ruangan'])
            . view('peminjaman/success')
            . view('templates/footer');
    }
}
