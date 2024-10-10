<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use App\Models\PeminjamanModel;
use App\Models\PegawaiModel;
use App\Models\RuanganModel;
use App\Models\UserModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        // Mendapatkan tanggal 1 bulan sebelum hari ini
        $tanggal_sebulan_lalu = date('Y-m-d', strtotime('-1 month'));

        // Check if the user is an admin with pegawai id 58 or 35
        if (session()->get('pegawai_id') == 58 || session()->get('pegawai_id') == 35) {
            $data = [
                'peminjaman' => $model->where('tanggal >=', $tanggal_sebulan_lalu)->getPeminjaman(),
                'ruangan' => $modelRuangan->getRuangan(),
                'title' => 'Daftar Peminjaman Semua User',
            ];
        }
        // Check if there is no user logged in or the user is not an admin with pegawai id 58 or 35
        elseif (!session()->has('user_id') || (session()->has('user_id') && session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
            $data = [
                'peminjaman' => $model->where('tanggal >=', date('Y-m-d'))->getPeminjaman(),
                'ruangan' => $modelRuangan->getRuangan(),
                'title' => 'Daftar Peminjaman Semua User',
            ];
        }

        return view('templates/header', $data)
            . view('peminjaman/index')
            . view('templates/footer');
    }

    public function viewPeminjamanUser()
    {
        if (!session()->has('pegawai_id')) {
            // Session tidak ada, arahkan ke halaman login
            session()->setFlashdata('error', 'Anda belum login, silahkan login terlebih dahulu.');
            return redirect()->to('/login');
        }

        helper('form');

        $modelPeminjaman = model(PeminjamanModel::class);
        $modelRuangan = model(RuanganModel::class);

        $data = [
            'peminjaman' => $modelPeminjaman->where('tanggal >=', date('Y-m-d'))->getPeminjamanByUser(),
            'ruangan' => $modelRuangan->getRuangan(),
            'title' => 'Buat ruangan',
        ];

        $data['title'] = 'Daftar Peminjaman - ' . session()->get('pegawai_id_user');

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

        $data['title'] = 'Detail Peminjaman:';

        return view('templates/header', $data)
            . view('peminjaman/view')
            . view('templates/footer');
    }

    public function create()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        helper('form');

        // Mengambil data dari tabel Pegawai dan Ruangan
        $modelUser = model(UserModel::class);
        $modelPegawai = model(PegawaiModel::class);
        $modelRuangan = model(RuanganModel::class);

        $data = [
            'user' => $modelUser->getUserWithPegawai(),
            'pegawai' => $modelPegawai->getPegawai(),
            'ruangan' => $modelRuangan->getRuangan(),
            'title' => 'Buat ruangan',
        ];

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
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
                'acara' => 'required',
                'tanggal' => 'required',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ])
        ) {
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
        $waktu_mulai = date('H:i:s', strtotime($post['waktu_mulai'] . ' ' . date_default_timezone_get()));
        $waktu_selesai = date('H:i:s', strtotime($post['waktu_selesai'] . ' ' . date_default_timezone_get()));

        // Mengubah string waktu menjadi integer
        $waktu_mulai_int = strtotime($waktu_mulai);
        $waktu_selesai_int = strtotime($waktu_selesai);

        // Membandingkan nilai waktu
        if ($waktu_mulai_int >= $waktu_selesai_int) {
            // Menampilkan pesan error jika waktu mulai lebih besar atau sama dengan waktu selesai
            session()->setFlashdata('error', 'Anda Tidak Berhasil Meminjam Ruangan, Waktu Selesai Harus Lebih Besar dari Waktu Mulai.');
            return view('templates/header', $data)
                . view('peminjaman/create')
                . view('templates/footer');
        } else {
            // Mengecek apakah ada data waktu yang tumpang tindih
            $model = model(PeminjamanModel::class);
            $result = $model->query("
                SELECT * FROM peminjaman 
                WHERE id_ruangan = ? 
                AND tanggal = ? 
                AND (
                    (? >= waktu_mulai AND ? <= waktu_selesai) -- Cek jika waktu mulai baru berada di antara atau sama dengan waktu mulai/selesai peminjaman lain
                    OR 
                    (? >= waktu_mulai AND ? <= waktu_selesai) -- Cek jika waktu selesai baru berada di antara atau sama dengan waktu mulai/selesai peminjaman lain
                    OR
                    (waktu_mulai >= ? AND waktu_mulai <= ?) -- Cek jika waktu mulai peminjaman lain berada di antara waktu mulai dan selesai baru
                    OR
                    (waktu_selesai >= ? AND waktu_selesai <= ?) -- Cek jika waktu selesai peminjaman lain berada di antara waktu mulai dan selesai baru
                    OR
                    (? < waktu_mulai AND ? > waktu_selesai) -- Cek jika peminjaman baru mencakup keseluruhan peminjaman lain
                )
            ", [
                $id_ruangan, $tanggal, 
                $waktu_mulai, $waktu_mulai, // Untuk cek waktu mulai baru berada di antara waktu peminjaman lain
                $waktu_selesai, $waktu_selesai, // Untuk cek waktu selesai baru berada di antara waktu peminjaman lain
                $waktu_mulai, $waktu_selesai, // Untuk cek waktu mulai peminjaman lain berada di antara waktu baru
                $waktu_mulai, $waktu_selesai, // Untuk cek waktu selesai peminjaman lain berada di antara waktu baru
                $waktu_mulai, $waktu_selesai // Untuk cek jika peminjaman baru mencakup keseluruhan peminjaman lain
            ])->getResult();

            // Jika tidak ada data waktu yang tumpang tindih
            if (empty($result)) {
                // Mendapatkan tanggal dan waktu sekarang
                $tanggal_sekarang = date("Y-m-d");
                $waktu_sekarang = date("H:i:s");

                // Mengecek jika pegawai_id valid
                // Mengambil data pegawai dari database
                $ruangan = $modelRuangan->where('id', $id_ruangan)->first();

                // Jika data pegawai tidak ditemukan, maka input tidak valid
                if ($ruangan == null) {
                    session()->setFlashdata('error', 'ID Ruangan tidak valid.');
                    return redirect()->to('peminjaman/create');
                }

                // Membandingkan data waktu dengan tanggal dan waktu sekarang
                if ($tanggal < $tanggal_sekarang || ($tanggal == $tanggal_sekarang && ($waktu_mulai < $waktu_sekarang || $waktu_selesai < $waktu_sekarang))) {
                    // Menampilkan pesan error jika data waktu kurang dari tanggal dan waktu sekarang
                    session()->setFlashdata('error', 'Anda Tidak Berhasil Meminjam Ruangan, Tanggal dan Waktu yang Anda Pilih Sudah Berlalu.');
                    return view('templates/header', $data)
                        . view('peminjaman/create')
                        . view('templates/footer');
                } else {
                    // Menyimpan data ke database
                    $model->save([
                        'id_pegawai' => $post['id_pegawai'],
                        'id_ruangan' => $id_ruangan,
                        'acara' => $acara,
                        'tanggal' => $tanggal,
                        'waktu_mulai' => $waktu_mulai,
                        'waktu_selesai' => $waktu_selesai,
                    ]);

                    session()->setFlashdata('pinjamBerhasil', 'Anda Berhasil Meminjam Ruangan!');
                    if (!session()->has('pegawai_id') || (session()->get('pegawai_id') != 58 && session()->get('pegawai_id') != 35)) {
                        return redirect()->to('/view');
                    } else {
                        return redirect()->to('/peminjaman');
                    }
                }
            } else {
                // Menampilkan pesan error
                session()->setFlashdata('error', 'Anda Tidak Berhasil Meminjam Ruangan, Waktu yang Anda Pilih Sudah Terisi.');
                return view('templates/header', $data)
                    . view('peminjaman/create')
                    . view('templates/footer');
            }
        }
    }

    // fungsi edit yang digunakan untuk mengedit data peminjaman ruangan
    public function edit()
    {
        // Fungsi ini memeriksa apakah pengguna sudah masuk atau belum.
        // Jika belum, pengguna akan diarahkan ke halaman login.
        // Jika sudah masuk, fungsi ini akan memuat data pengguna, pegawai, dan ruangan dari model yang sesuai dan menampilkannya di halaman pembuatan peminjaman.
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        helper('form');

        // Mengambil data dari tabel Pegawai dan Ruangan
        $modelUser = model(UserModel::class);
        $modelPegawai = model(PegawaiModel::class);
        $modelRuangan = model(RuanganModel::class);

        $data = [
            'user' => $modelUser->getUserWithPegawai(),
            'pegawai' => $modelPegawai->getPegawai(),
            'ruangan' => $modelRuangan->getRuangan(),
            'title' => 'Buat ruangan',
        ];

        // Checks whether the form is submitted.
        if (!$this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', $data)
                . view('peminjaman/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['id', 'id_pegawai', 'id_ruangan', 'tanggal', 'acara', 'waktu_mulai', 'waktu_selesai']);

        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validateData($post, [
                'id_pegawai' => 'required',
                'id_ruangan' => 'required',
                'acara' => 'required',
                'tanggal' => 'required',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'required',
            ])
        ) {
            // The validation fails, so returns the form.
            return view('templates/header', $data)
                . view('peminjaman/create')
                . view('templates/footer');
        }

        $model = model(PeminjamanModel::class);

        // Mengambil data waktu dari form
        $id = $post['id'];
        $id_pegawai = $post['id_pegawai'];
        $id_ruangan = $post['id_ruangan'];
        $tanggal = $post['tanggal'];
        $acara = $post['acara'];
        $waktu_mulai = date('H:i:s', strtotime($post['waktu_mulai'] . ' ' . date_default_timezone_get()));
        $waktu_selesai = date('H:i:s', strtotime($post['waktu_selesai'] . ' ' . date_default_timezone_get()));

        // Mengubah string waktu menjadi integer
        $waktu_mulai_int = strtotime($waktu_mulai);
        $waktu_selesai_int = strtotime($waktu_selesai);

        // Membandingkan nilai waktu
        if ($waktu_mulai_int >= $waktu_selesai_int) {
            // Menampilkan pesan error jika waktu mulai lebih besar atau sama dengan waktu selesai
            session()->setFlashdata('error', 'Anda Tidak Berhasil Mengedit, Waktu Selesai Harus Lebih Besar dari Waktu Mulai.');
            return redirect()->back();
        } else {
            // Mengecek apakah ada data waktu yang tumpang tindih
            $model = model(PeminjamanModel::class);
            $result = $model->query("
                SELECT * FROM peminjaman 
                WHERE id_ruangan = ? 
                AND tanggal = ? 
                AND (
                    (? >= waktu_mulai AND ? <= waktu_selesai) -- Cek jika waktu mulai baru berada di antara atau sama dengan waktu mulai/selesai peminjaman lain
                    OR 
                    (? >= waktu_mulai AND ? <= waktu_selesai) -- Cek jika waktu selesai baru berada di antara atau sama dengan waktu mulai/selesai peminjaman lain
                    OR
                    (waktu_mulai >= ? AND waktu_mulai <= ?) -- Cek jika waktu mulai peminjaman lain berada di antara waktu mulai dan selesai baru
                    OR
                    (waktu_selesai >= ? AND waktu_selesai <= ?) -- Cek jika waktu selesai peminjaman lain berada di antara waktu mulai dan selesai baru
                    OR
                    (? < waktu_mulai AND ? > waktu_selesai) -- Cek jika peminjaman baru mencakup keseluruhan peminjaman lain
                )
            ", [
                $id_ruangan, $tanggal, 
                $waktu_mulai, $waktu_mulai, // Untuk cek waktu mulai baru berada di antara waktu peminjaman lain
                $waktu_selesai, $waktu_selesai, // Untuk cek waktu selesai baru berada di antara waktu peminjaman lain
                $waktu_mulai, $waktu_selesai, // Untuk cek waktu mulai peminjaman lain berada di antara waktu baru
                $waktu_mulai, $waktu_selesai, // Untuk cek waktu selesai peminjaman lain berada di antara waktu baru
                $waktu_mulai, $waktu_selesai // Untuk cek jika peminjaman baru mencakup keseluruhan peminjaman lain
            ])->getResult();

            // Jika tidak ada data waktu yang tumpang tindih
            if (empty($result)) {
                // Mendapatkan tanggal dan waktu sekarang
                $tanggal_sekarang = date("Y-m-d");
                $waktu_sekarang = strtotime(date("H:i:s"));

                // Membandingkan data waktu dengan tanggal dan waktu sekarang
                if ($tanggal <= $tanggal_sekarang && $waktu_mulai_int <= $waktu_sekarang) {
                    // Menampilkan pesan error jika data waktu kurang dari tanggal dan waktu sekarang
                    session()->setFlashdata('error', 'Anda Tidak Berhasil Meminjam Ruangan, Tanggal dan Waktu yang Anda Pilih Sudah Berlalu.');
                    return redirect()->back();
                } else {
                    // Menyimpan data ke database
                    $model->replace([
                        'id' => $id,
                        'id_pegawai' => $id_pegawai,
                        'id_ruangan' => $id_ruangan,
                        'acara' => $acara,
                        'tanggal' => $tanggal,
                        'waktu_mulai' => $waktu_mulai,
                        'waktu_selesai' => $waktu_selesai,
                    ]);

                    session()->setFlashdata('editBerhasil', 'Anda Berhasil Mengedit!');
                    return redirect()->back();
                }
            } else {
                // Menampilkan pesan error
                session()->setFlashdata('error', 'Anda Tidak Berhasil Mengedit, Waktu yang Anda Pilih Sudah Terisi.');
                return redirect()->back();
            }
        }
    }

    public function end($id)
    {
        // cek session
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        // load model
        $modelPeminjaman = model(PeminjamanModel::class);
        $modelRuangan = model(RuanganModel::class);

        // cari data peminjaman
        $peminjaman = $modelPeminjaman->find($id);
        if (!$peminjaman) {
            throw PageNotFoundException::forPageNotFound();
        }

        // cari data ruangan
        $ruangan = $modelRuangan->find($peminjaman['id_ruangan']);
        if (!$ruangan) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Ambil waktu sekarang
        $waktu_sekarang = date("H:i");

        // Update waktu_mulai menjadi waktu sekarang dikurangi 2 menit
        $timestamp_mulai = strtotime($waktu_sekarang . ':00') - 120; // kurangi 120 detik (2 menit)
        $peminjaman['waktu_mulai'] = date("H:i:00", $timestamp_mulai); // tambahkan detik 00

        // Update waktu_selesai menjadi waktu sekarang dikurangi 1 menit
        $timestamp_selesai = strtotime($waktu_sekarang . ':00') - 60; // kurangi 60 detik (1 menit)
        $peminjaman['waktu_selesai'] = date("H:i:00", $timestamp_selesai); // tambahkan detik 00

        // Simpan perubahan ke database
        $modelPeminjaman->save($peminjaman);

        // Redirect ke halaman view dengan pesan sukses
        session()->setFlashdata('pinjamBerhasil', 'Anda Telah Mengakhiri Peminjaman!');
        return redirect()->back();
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
