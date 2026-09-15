<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'uuid'               => ['type' => 'VARCHAR', 'constraint' => 36, 'unique' => true], // Untuk link sertifikat
            'nama_pemesan'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'no_wa_pemesan'      => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama_diumrahkan'    => ['type' => 'VARCHAR', 'constraint' => 150],
            'paket_pilihan'      => ['type' => 'VARCHAR', 'constraint' => 50], // Misal: 'Paket Standar', 'Paket Paripurna'
            'nama_pelaksana'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true], // Nama Mutawwif
            'file_ttd_pelaksana' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tempat_miqat'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tanggal_miqat'      => ['type' => 'DATE', 'null' => true],
            'tanggal_cetak'      => ['type' => 'DATE', 'null' => true],
            'status'             => ['type' => 'ENUM', 'constraint' => ['pending', 'proses', 'selesai'], 'default' => 'pending'],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('pendaftaran');
    }
}
