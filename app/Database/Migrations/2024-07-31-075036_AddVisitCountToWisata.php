<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVisitCountToWisata extends Migration
{
    public function up()
    {
        $this->forge->addColumn('wisata', [
            'visit_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'peta'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('wisata', 'visit_count');
    }
}