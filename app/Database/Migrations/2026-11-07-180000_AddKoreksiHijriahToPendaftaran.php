<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKoreksiHijriahToPendaftaran extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('pendaftaran', [
            'koreksi_hijriah' => ['type' => 'INT', 'null' => true],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('pendaftaran', 'koreksi_hijriah');
    }
}
