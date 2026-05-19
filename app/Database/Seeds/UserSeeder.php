<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nom'      => 'Admin FitSpace',
                'email'    => 'admin@fitspace.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'nom'      => 'Jean Dupont',
                'email'    => 'client@fitspace.com',
                'password' => password_hash('client', PASSWORD_DEFAULT),
                'role'     => 'client',
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
