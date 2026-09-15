<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'pengaturan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['setting_key', 'setting_value'];

    // Aktifkan timestamp otomatis (created_at, updated_at)
    protected $useTimestamps = true;

    // Fungsi bantuan khusus untuk mengambil nilai pengaturan (misal: nama direktur)
    public function getSetting($key)
    {
        $data = $this->where('setting_key', $key)->first();
        return $data ? $data['setting_value'] : null;
    }
}
