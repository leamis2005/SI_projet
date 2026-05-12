<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRegimeModel extends Model
{
    protected $table = 'user_regime';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_user',
        'id_regime',
        'date_debut',
        'date_fin',
    ];
}
