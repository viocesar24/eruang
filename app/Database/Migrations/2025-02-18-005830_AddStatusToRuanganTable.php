<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToRuanganTable extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Nonaktif'],
                'default' => 'Aktif', // Set default value to 'Aktif'
                'after' => 'nama', // Menempatkan kolom 'status' setelah kolom 'nama'
            ],
        ];
        $this->forge->addColumn('ruangan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('ruangan', 'status');
    }
}
