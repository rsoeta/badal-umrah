<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoDokumentasiModel extends Model
{
    protected $table            = 'video_dokumentasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pendaftaran_id',
        'file_name',
        'original_name',
        'mime_type',
        'file_size',
        'share_token',
        'created_at',
    ];
    protected $useTimestamps    = false;
}
