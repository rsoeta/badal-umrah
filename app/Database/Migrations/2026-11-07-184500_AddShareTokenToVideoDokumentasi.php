<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShareTokenToVideoDokumentasi extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('video_dokumentasi', [
            'share_token' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
        ]);
        $this->forge->addKey('share_token', false, true, 'video_dokumentasi_share_token_unique');
        $this->forge->processIndexes('video_dokumentasi');
    }

    public function down(): void
    {
        $this->forge->dropKey('video_dokumentasi', 'video_dokumentasi_share_token_unique', false);
        $this->forge->dropColumn('video_dokumentasi', 'share_token');
    }
}
