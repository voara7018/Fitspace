<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCreneaux extends Migration
{
    public function up()
    {
     
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'auto_increment' => true,
            ],
            'ressources_id' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'date_debut' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'date_fin' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'places_dispo' => [
                'type' => 'INTEGER',
                'null' => false,
            ],
            'actif' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
        ]);


        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ressources_id', 'ressources', 'id');
        $this->forge->createTable('creneaux');
    }


    public function down()
    {
        $this->forge->dropTable('creneaux');
    }
}
