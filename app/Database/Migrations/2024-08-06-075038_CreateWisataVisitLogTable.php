<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWisataVisitLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'wisata_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
            ],
            'visit_date' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('unique_visit', ['wisata_id', 'ip_address', 'visit_date']);
        $this->forge->createTable('wisata_visit_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('wisata_visit_log', true);
    }
}
