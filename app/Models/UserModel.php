<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['username', 'password_hash', 'pegawai_id'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getUser($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }

    public function getUserWithPegawai($id)
    {
        $id = session()->get('pegawai_id');

        if ($id === false) {
            return $this->findAll();
        }

        return $this->select('users.*, pegawai.nama as nama')
            ->join('pegawai', 'users.pegawai_id = pegawai.id')
            ->where('users.pegawai_id', $id)
            ->first();
    }

    public function gantiPassword($id, $new_password)
    {
        $data = [
            'password_hash' => password_hash($new_password, PASSWORD_DEFAULT),
        ];
        return $this->update($id, $data);
    }
}