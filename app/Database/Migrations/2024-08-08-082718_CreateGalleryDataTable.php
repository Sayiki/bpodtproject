<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGalleryDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'order' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('gallery_data');
    }

    public function down()
    {
        $this->forge->dropTable('gallery_data');
    }
}