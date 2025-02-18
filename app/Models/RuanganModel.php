<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table = 'ruangan';

    protected $allowedFields = ['nama', 'status'];

    public function getRuangan($id = false, $filter_aktif = true)
    {
        if ($id === false) {
            if ($filter_aktif) {
                return $this->where('status', 'Aktif')->findAll(); // Langsung return dengan filter status
            }
            return $this->findAll(); // Return semua ruangan tanpa filter status
        }

        return $this->where(['id' => $id])->first();
    }
}
