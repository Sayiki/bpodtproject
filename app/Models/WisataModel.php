<?php

namespace App\Models;

use CodeIgniter\Model;

class WisataModel extends Model
{
    protected $table = 'wisata';
    protected $primaryKey = 'wisata_id';
    protected $allowedFields = ['nama_wisata', 'deskripsi', 'detail_url', 'image', 'peta'];
}
