<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table = 'ruangan';

    protected $allowedFields = ['nama'];

    // public function getRuangan($id = false)
    // {
    //     if ($id === false) {
    //         return $this->findAll();
    //     }

    //     return $this->where(['id' => $id])->first();
    // }

    public function getRuangan($id = false)
    {
        if ($id === false) {
            // Menggunakan whereNotIn untuk mengecualikan ruangan "sekretaris"
            return $this->whereNotIn('nama', ['auditorial', 'sekretaris'])->findAll();
            // return $this->whereNotIn('nama', ['auditorial'])->findAll();
            // return $this->whereNotIn('nama', ['sekretaris'])->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

}