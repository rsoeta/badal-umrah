<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToPendaftaran extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('pendaftaran', [
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('pendaftaran', 'deleted_at');
    }
}
