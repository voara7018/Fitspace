<?php 

namespace App\Models;
use CodeIgniter\Model;

class RessourcesModel extends Model
{

    protected $table = 'ressources';
    protected $primaryKey = 'id';
    
    protected $allowedFields =  [
        'nom',
        'type',
        'capacite',
        'description' 

    ];

    
    
    
    
}