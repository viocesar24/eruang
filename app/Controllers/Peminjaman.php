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

        // $model->save([
        //     'id_pegawai' => $post['id_pegawai'],
        //     'id_ruangan' => $post['id_ruangan'],
        //     'tanggal' => $post['tanggal'],
        //     'waktu_mulai' => $post['waktu_mulai'],
        //     'waktu_selesai'  => $post['waktu_selesai'],
        // ]);

        // return view('templates/header', ['title' => 'Buat ruangan'])
        //     . view('peminjaman/success')
        //     . view('templates/footer');

        // Mengambil data waktu dari form
        $id_ruangan = $post['id_ruangan'];
        $tanggal = $post['tanggal'];
        $waktu_mulai = $post['waktu_mulai'];
        $waktu_selesai = $post['waktu_selesai'];

        // Mengubah string waktu menjadi integer
        $waktu_mulai_int = strtotime($waktu_mulai);
        $waktu_selesai_int = strtotime($waktu_selesai);

        // Membandingkan nilai waktu
        if ($waktu_mulai_int >= $waktu_selesai_int) {
            // Menampilkan pesan error jika waktu mulai lebih besar atau sama dengan waktu selesai
            return view('templates/header', ['title' => 'Anda tidak berhasil meminjam ruangan, waktu selesai harus lebih besar dari waktu mulai'])
                . view('peminjaman/success')
                . view('templates/footer');
        } else {
            // Mengecek apakah ada data waktu yang tumpang tindih
            $model = model(PeminjamanModel::class);
            $result = $model->query("SELECT * FROM peminjaman WHERE id_ruangan = ? AND tanggal = ? AND (waktu_mulai BETWEEN ? AND ? OR waktu_selesai BETWEEN ? AND ?)", [$id_ruangan, $tanggal, $waktu_mulai, $waktu_selesai, $waktu_mulai, $waktu_selesai])->getResult();

            // Jika tidak ada data waktu yang tumpang tindih
            if (empty($result)) {
                // Menyimpan data ke database
                $model->save([
                    'id_pegawai' => $post['id_pegawai'],
                    'id_ruangan' => $id_ruangan,
                    'tanggal' => $tanggal,
                    'waktu_mulai' => $waktu_mulai,
                    'waktu_selesai' => $waktu_selesai,
                ]);

                return view('templates/header', ['title' => 'Anda berhasil meminjam ruangan'])
                    . view('peminjaman/success')
                    . view('templates/footer');
            } else {
                // Menampilkan pesan error
                return view('templates/header', ['title' => 'Anda tidak berhasil meminjam ruangan, waktu yang Anda pilih sudah terisi'])
                    . view('peminjaman/success')
                    . view('templates/footer');
            }

            // Menyimpan data ke database jika waktu mulai lebih kecil dari waktu selesai
            // $model->save([
            //     'id_pegawai' => $post['id_pegawai'],
            //     'id_ruangan' => $post['id_ruangan'],
            //     'tanggal' => $post['tanggal'],
            //     'waktu_mulai' => $waktu_mulai,
            //     'waktu_selesai' => $waktu_selesai,
            // ]);

            // return view('templates/header', ['title' => 'Anda berhasil meminjam ruangan'])
            //     . view('peminjaman/success')
            //     . view('templates/footer');
        }
    }
}
