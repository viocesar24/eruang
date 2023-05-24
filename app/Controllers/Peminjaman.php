<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\PeminjamanModel;
use App\Models\PegawaiModel;
use App\Models\RuanganModel;
use App\Models\UserModel;

class Peminjaman extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        helper('form');

        $model = model(PeminjamanModel::class);
        $modelRuangan = model(RuanganModel::class);

        $data = [
            'peminjaman' => $model->getPeminjaman(),
            'ruangan' => $modelRuangan->getRuangan(),
            'title' => 'Daftar Peminjaman Semua User',
        ];

        return view('templates/header', $data)
            . view('peminjaman/index')
            . view('templates/footer');
    }

    public function viewPeminjamanUser()
    {
        helper('form');

        $modelPeminjaman = model(PeminjamanModel::class);
        $modelRuangan = model(RuanganModel::class);

        $data = [
            'peminjaman' => $modelPeminjaman->getPeminjamanByUser(),
            'ruangan' => $modelRuangan->getRuangan(),
            'title' => 'Buat ruangan',
        ];

        // if (empty($data['peminjaman'])) {
        //     throw new PageNotFoundException('Cannot find the peminjaman item');
        // }

        $data['title'] = 'Daftar Peminjaman User: ';

        return view('templates/header', $data)
            . view('peminjaman/view')
            . view('templates/footer');
    }

    public function view($id = null)
    {
        $modelPeminjaman = model(PeminjamanModel::class);
        $modelRuangan = model(RuanganModel::class);

        $data = [
            'peminjaman' => $modelPeminjaman->getPeminjaman($id),
            'ruangan' => $modelRuangan->getRuangan(),
            'title' => 'Buat ruangan',
        ];

        // if (empty($data['peminjaman'])) {
        //     throw new PageNotFoundException('Cannot find the peminjaman item: ' . $id);
        // }

        $data['title'] = 'Detail Peminjaman:';

        return view('templates/header', $data)
            . view('peminjaman/view')
            . view('templates/footer');
    }

    public function create($id = null)
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        helper('form');

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
            // Mengambil data dari tabel Pegawai dan Ruangan
            $modelUser = model(UserModel::class);
            $modelPegawai = model(PegawaiModel::class);
            $modelRuangan = model(RuanganModel::class);

            $data = [
                'user' => $modelUser->getUserWithPegawai($id),
                'pegawai' => $modelPegawai->getPegawai(),
                'ruangan' => $modelRuangan->getRuangan(),
                'title' => 'Buat ruangan',
            ];
            // The form is not submitted, so returns the form.
            return view('templates/header', $data)
                . view('peminjaman/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['id_pegawai', 'id_ruangan', 'tanggal', 'acara', 'waktu_mulai', 'waktu_selesai']);

        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validateData($post, [
                'id_pegawai' => 'required',
                'id_ruangan' => 'required',
                'tanggal' => 'required',
                'acara' => 'required',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ])
        ) {
            // Mengambil data dari tabel Pegawai dan Ruangan
            $modelUser = model(UserModel::class);
            $modelPegawai = model(PegawaiModel::class);
            $modelRuangan = model(RuanganModel::class);

            $data = [
                'user' => $modelUser->getUserWithPegawai($id),
                'pegawai' => $modelPegawai->getPegawai(),
                'ruangan' => $modelRuangan->getRuangan(),
                'title' => 'Buat ruangan',
            ];
            // The validation fails, so returns the form.
            return view('templates/header', $data)
                . view('peminjaman/create')
                . view('templates/footer');
        }

        $model = model(PeminjamanModel::class);

        // Mengambil data waktu dari form
        $id_ruangan = $post['id_ruangan'];
        $tanggal = $post['tanggal'];
        $acara = $post['acara'];
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
                    'acara' => $acara,
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
        }
    }

    public function edit()
    {
        helper('form');

        $model = model(PeminjamanModel::class);

        if (
            $this->request->getMethod() === 'post' && $this->validate([
                'id' => 'min_length[0]',
                'id_pegawai' => 'required',
                'id_ruangan' => 'required',
                'tanggal' => 'required',
                'acara' => 'required',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ])
        ) {
            $model->replace([
                'id' => $this->request->getPost('id'),
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'id_ruangan' => $this->request->getPost('id_ruangan'),
                'tanggal' => $this->request->getPost('tanggal'),
                'acara' => $this->request->getPost('acara'),
                'waktu_mulai' => $this->request->getPost('waktu_mulai'),
                'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            ]);

            $this->session->setFlashdata('editBerhasil', 'Item Peminjaman telah berhasil diubah.');

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function hapus()
    {
        helper('form');

        $model = model(PeminjamanModel::class);

        if (
            $this->request->getMethod() === 'post' && $this->validate([
                'id' => 'min_length[0]',
            ])
        ) {
            $model->delete([
                'id' => $this->request->getPost('id'),
            ]);

            if ($model->errors()) {
                print_r($model->errors());
            }

            $this->session->setFlashdata('hapusBerhasil', 'Item Peminjaman telah berhasil dihapus.');

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}