<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilSanteModel extends Model
{
    protected $table = 'profil_sante';
    protected $primaryKey = 'id_profil';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_user',
        'taille',
        'poids',
        'imc',
    ];
}
