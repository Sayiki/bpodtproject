<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $allowedFields = ['visit_date', 'visit_count', 'ip_address'];

    public function incrementDailyVisits($ipAddress)
    {
        $today = date('Y-m-d');
        $existingRecord = $this->where('visit_date', $today)
                               ->where('ip_address', $ipAddress)
                               ->first();

        if ($existingRecord) {
            // IP already visited today, do nothing
            return;
        } else {
            // New visit for this IP today
            $this->insert([
                'visit_date' => $today,
                'visit_count' => 1,
                'ip_address' => $ipAddress
            ]);
        }
    }

    public function getTotalVisits()
    {
        $result = $this->selectSum('visit_count')->get()->getRow();
        if ($result) {
            return $result->visit_count ?? 0;
        }
        return 0;
    }

    public function getVisitsForDateRange($startDate, $endDate)
    {
        return $this->where('visit_date >=', $startDate)
                    ->where('visit_date <=', $endDate)
                    ->selectSum('visit_count')
                    ->get()
                    ->getRow()
                    ->visit_count ?? 0;
    }
}