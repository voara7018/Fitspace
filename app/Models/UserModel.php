<?php 

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prenom', 'nom', 'email', 'password', 'role'];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];


    protected $validationRules = [
        'prenom' => 'required|min_length[2]|max_length[50]',
        'nom' => 'required|min_length[2]|max_length[50]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[4]',
        'password_confirm' => 'required|matches[password]',
        'role' => 'required|in_list[client,admin]'
    ];

    protected $validationMessages = [
        'prenom' => [
            'required' => 'Le prénom est requis.',
            'min_length' => 'Le prénom doit comporter au moins 2 caractères.',
            'max_length' => 'Le prénom ne peut pas dépasser 50 caractères.'
        ],
        'nom' => [
            'required' => 'Le nom est requis.',
            'min_length' => 'Le nom doit comporter au moins 2 caractères.',
            'max_length' => 'Le nom ne peut pas dépasser 50 caractères.'
        ],
        'email' => [
            'required' => 'L\'adresse email est requise.',
            'valid_email' => 'L\'adresse email doit être valide.',
            'is_unique' => 'Cette adresse email est déjà utilisée.'
        ],
        'password' => [
            'required' => 'Le mot de passe est requis.',
            'min_length' => 'Le mot de passe doit comporter au moins 4 caractères.'
        ],
        'password_confirm' => [
            'matches' => 'La confirmation du mot de passe doit correspondre au mot de passe.'
        ],
        'role' => [
            'required' => 'Le rôle est requis.',
            'in_list' => 'Le rôle doit être soit "client" soit "admin".'
        ], 
    ];

    protected function hashPassword(array $data)
    {
       if (! isset($data['data']) || ! is_array($data['data'])) {
            return $data;
        }

        if (array_key_exists('password_confirm', $data['data'])) {
            unset($data['data']['password_confirm']);
        }

        if (isset($data['data']['password']) && $data['data']['password'] !== '') {
            $info = password_get_info($data['data']['password']);
            if (($info['algo'] ?? 0) === 0) {
                $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            }
        }

        return $data;
    }

}