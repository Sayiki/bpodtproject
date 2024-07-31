<?php

namespace App\Models;

use CodeIgniter\Model;

class WisataModel extends Model
{
    protected $table = 'wisata';
    protected $primaryKey = 'wisata_id';
    protected $allowedFields = ['nama_wisata', 'deskripsi', 'detail_url', 'image', 'peta'];

    public function getTotalWisata()
    {
        return $this->countAll();
    }

    public function incrementVisitCount($wisataId)
    {
        $this->where('wisata_id', $wisataId)
             ->set('visit_count', 'visit_count + 1', false)
             ->update();
    }

    public function getMostVisitedWisata($limit = 5)
    {
        return $this->select('nama_wisata, visit_count')
                    ->orderBy('visit_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
