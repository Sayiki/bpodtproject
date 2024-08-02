<?php

namespace App\Models;

use CodeIgniter\Model;

class WisataModel extends Model
{
    protected $table = 'wisata';
    protected $primaryKey = 'wisata_id';
    protected $allowedFields = ['nama_wisata', 'deskripsi', 'detail_url', 'image', 'peta', 'visit_count'];

    public function getTotalWisata()
    {
        return $this->countAll();
    }

    public function incrementVisitCount($wisataId, $ipAddress)
    {
        // Check if this IP has already visited today
        $today = date('Y-m-d');
        $visitLog = $this->db->table('wisata_visit_log')
            ->where('wisata_id', $wisataId)
            ->where('ip_address', $ipAddress)
            ->where('visit_date', $today)
            ->get()
            ->getRow();

        if (!$visitLog) {
            // If no visit logged today, increment the count and log the visit
            $this->where('wisata_id', $wisataId)
                ->set('visit_count', 'visit_count + 1', false)
                ->update();

            $this->db->table('wisata_visit_log')->insert([
                'wisata_id' => $wisataId,
                'ip_address' => $ipAddress,
                'visit_date' => $today
            ]);
        }
    }

    public function getMostVisitedWisata($limit = 5)
    {
        return $this->select('nama_wisata, visit_count')
            ->orderBy('visit_count', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
