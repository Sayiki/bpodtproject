<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWisataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'wisata_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_wisata' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'detail_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'peta' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('wisata_id', true);
        $this->forge->createTable('wisata');
    }

    public function down()
    {
        $this->forge->dropTable('wisata');
    }
}
