<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FitspaceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nom' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($data);

        $data = [
            [
                'ressources_id' => 1,
                'date_debut' => '2026-05-20 08:00:00',
                'date_fin' => '2026-05-20 10:00:00',
                'places_dispo' => 10,
                'actif' => true
            ],
            [
                'ressources_id' => 1,
                'date_debut' => '2026-05-20 10:00:00',
                'date_fin' => '2026-05-20 12:00:00',
                'places_dispo' => 5,
                'actif' => true
            ],
            [
                'ressources_id' => 2,
                'date_debut' => '2026-05-21 08:00:00',
                'date_fin' => '2026-05-21 10:00:00',
                'places_dispo' => 15,
                'actif' => true
            ]
        ];

        $this->db->table('creneaux')->insertBatch($data);

         $data = [
            [
                'nom' => 'Salle A',
                'type' => 'Salle',
                'capacite' => 30,
                'description' => 'Salle informatique'
            ],
            [
                'nom' => 'Salle B',
                'type' => 'Salle',
                'capacite' => 20,
                'description' => 'Salle multimedia'
            ]
        ];

        $this->db->table('ressources')->insertBatch($data);
    }
}