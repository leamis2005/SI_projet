<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table = 'parametres';
    protected $primaryKey = 'id_param';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'cle',
        'valeur',
    ];
}
