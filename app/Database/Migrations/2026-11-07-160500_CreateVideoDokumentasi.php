<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideoDokumentasi extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pendaftaran_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'file_name'        => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'original_name'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'mime_type'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'file_size'        => ['type' => 'BIGINT', 'unsigned' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('pendaftaran_id');
        $this->forge->createTable('video_dokumentasi');
    }

    public function down(): void
    {
        $this->forge->dropTable('video_dokumentasi');
    }
}
