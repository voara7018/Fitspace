<?php 

namespace App\Models;
use CodeIgniter\Model;

class ReservationModel extends Model
{

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    
    protected $allowedFields =  [
        'users_id',
        'creneaux_id',
        'statut'
    ];

    
}