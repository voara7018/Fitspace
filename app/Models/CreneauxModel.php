<?php 

namespace App\Models;
use CodeIgniter\Model;

class CreneauxModel extends Model
{

    protected $table = 'creneaux';
    protected $primaryKey = 'id';
    
    protected $allowedFields =  [
        'ressources_id',
        'date_debut',
        'date_fin',
        'places_dispo',
        'actif'
    ];
    
    
    
    
}