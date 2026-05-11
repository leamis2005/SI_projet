<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nom',
        'email',
        'mot_de_passe',
        'genre',
        'date_naissance',
        'role',
        'wallet',
        'gold',
    ];
}
