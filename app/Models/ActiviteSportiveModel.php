<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteSportiveModel extends Model
{
    protected $table = 'activites_sportives';
    protected $primaryKey = 'id_activite';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nom',
        'calories_brulees',
        'description',
    ];
}
