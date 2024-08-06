<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIpAddressToVisitors extends Migration
{
    public function up()
    {
        $fields = [
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true, // adjust based on your requirements
            ],
        ];
        $this->forge->addColumn('visitors', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('visitors', 'ip_address');
    }
}
