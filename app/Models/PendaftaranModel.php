<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at';
    protected $protectFields    = true;

    // Kolom-kolom yang diizinkan untuk diisi (Mass Assignment)
    protected $allowedFields    = [
        'uuid',
        'nama_pemesan',
        'no_wa_pemesan',
        'nama_diumrahkan',
        'foto_jamaah',
        'paket_pilihan',
        'nama_pelaksana',
        'file_ttd_pelaksana',
        'tempat_miqat',
        'tanggal_miqat',
        'tanggal_cetak',
        'status',
        'deleted_at'
    ];

    // Aktifkan timestamp otomatis
    protected $useTimestamps = true;
}
