<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id_regime';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nom',
        'prix_base',
        'duree',
        'viande_percent',
        'poisson_percent',
        'volaille_percent',
        'variation_poids',
        'prix_par_jour',
    ];
}
