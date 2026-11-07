<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoJamaahToPendaftaran extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('pendaftaran', [
            'foto_jamaah' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('pendaftaran', 'foto_jamaah');
    }
}
