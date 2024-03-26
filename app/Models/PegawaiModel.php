<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table = 'pegawai';

    protected $allowedFields = ['nama', 'urutan'];

    public function getPegawai($id = false)
    {
        if ($id === false) {
            // return All but with order by "urutan"
            return $this->orderBy('urutan', 'ASC')->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}