<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $allowedFields = ['visit_date', 'visit_count'];

    public function incrementDailyVisits()
    {
        $today = date('Y-m-d');
        $existingRecord = $this->where('visit_date', $today)->first();

        if ($existingRecord) {
            $this->where('visit_date', $today)
                ->set('visit_count', 'visit_count + 1', false)
                ->update();
        } else {
            $this->insert(['visit_date' => $today, 'visit_count' => 1]);
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