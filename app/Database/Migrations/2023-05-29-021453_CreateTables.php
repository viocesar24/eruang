<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        // Create pegawai table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pegawai');

        // Create ruangan table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ruangan');

        // Create peminjaman table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_pegawai' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_ruangan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'acara' => [
                'type' => 'LONGTEXT',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'waktu_mulai' => [
                'type' => 'TIME',
            ],
            'waktu_selesai' => [
                'type' => 'TIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pegawai', 'pegawai', 'id');
        $this->forge->addForeignKey('id_ruangan', 'ruangan', 'id');
        $this->forge->createTable('peminjaman');

        // Create users table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pegawai_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            // Assuming pegawai_id is a foreign key to pegawai table
            // If not, please change accordingly
            // Also, you may want to add other fields such as email, role, etc.
            // depending on your application logic
            // This is just a basic example
            // You can also use the Myth\Auth library for authentication
            // https://github.com/lonnieezell/myth-auth
            // It has many features such as roles, permissions, password reset, etc.

            // pegawai_id is a foreign key to pegawai table
            // If not, please change accordingly
            // Also, you may want to add other fields such as email, role, etc.
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('pegawai_id');
        $this->forge->addForeignKey('pegawai_id', 'pegawai', 'id');

        $this->forge->createTable('users');
    }

    public function down()
    {
        // Drop tables in reverse order of creation
        $this->forge->dropTable('users');
        $this->forge->dropTable('peminjaman');
        $this->forge->dropTable('ruangan');
        $this->forge->dropTable('pegawai');
    }
}
