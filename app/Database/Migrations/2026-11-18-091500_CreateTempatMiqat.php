<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTempatMiqat extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_miqat'  => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'keterangan'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tempat_miqat', true);

        // Seed data awal tempat miqat standar
        $defaults = [
            [
                'nama_miqat' => "Tan'im, Makkah Al-Mukarramah",
                'keterangan' => 'Masjid Sayyidah Aisyah (Miqat terdekat dari Makkah)',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_miqat' => 'Bir Ali (Zulhulaifah)',
                'keterangan' => 'Miqat bagi jamaah yang datang dari arah Madinah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_miqat' => 'Ji\'ranah',
                'keterangan' => 'Miqat arah timur laut Kota Makkah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_miqat' => 'Hudaibiyah',
                'keterangan' => 'Miqat bersejarah arah barat Kota Makkah',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_miqat' => 'Yalamlam',
                'keterangan' => 'Miqat bagi jamaah dari arah Yaman & rute pesawat selatan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_miqat' => 'Qarnul Manazil',
                'keterangan' => 'Miqat (As-Sail Al-Kabir) bagi jamaah dari Najd/Taif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tempat_miqat')->insertBatch($defaults);
    }

    public function down(): void
    {
        $this->forge->dropTable('tempat_miqat', true);
    }
}
