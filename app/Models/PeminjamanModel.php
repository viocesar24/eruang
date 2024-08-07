<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_pegawai', 'id_ruangan', 'acara', 'tanggal', 'waktu_mulai', 'waktu_selesai'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPeminjaman($id = false)
    {
        if ($id === false) {
            // Memilih kolom yang ingin ditampilkan dari ketiga tabel
            $this->select('peminjaman.*, pegawai.nama as nama_pegawai, ruangan.nama as nama_ruangan');

            // Melakukan join dengan tabel pegawai berdasarkan kolom id_pegawai
            $this->join('pegawai', 'peminjaman.id_pegawai = pegawai.id');

            // Melakukan join dengan tabel ruangan berdasarkan kolom id_ruangan
            $this->join('ruangan', 'peminjaman.id_ruangan = ruangan.id');

            // Mengembalikan hasil query dalam bentuk array
            return $this->findAll();
        }
        // Memilih kolom yang ingin ditampilkan dari ketiga tabel
        $this->select('peminjaman.*, pegawai.nama as nama_pegawai, ruangan.nama as nama_ruangan');

        // Melakukan join dengan tabel pegawai berdasarkan kolom id_pegawai
        $this->join('pegawai', 'peminjaman.id_pegawai = pegawai.id');

        // Melakukan join dengan tabel ruangan berdasarkan kolom id_ruangan
        $this->join('ruangan', 'peminjaman.id_ruangan = ruangan.id');

        // Mengembalikan hasil query dalam bentuk array
        return $this->where(['peminjaman.id' => $id])->first();
    }

    public function getPeminjamanByUser($pegawaiId = null)
    {
        $pegawaiId = session()->get('pegawai_id');

        if ($pegawaiId === false) {
            return $this->findAll();
        }

        $this->select('peminjaman.*, pegawai.nama as nama_pegawai, ruangan.nama as nama_ruangan');

        $this->join('pegawai', 'peminjaman.id_pegawai = pegawai.id');

        $this->join('ruangan', 'peminjaman.id_ruangan = ruangan.id');

        return $this->where(['peminjaman.id_pegawai' => $pegawaiId])->findAll();
    }
}
