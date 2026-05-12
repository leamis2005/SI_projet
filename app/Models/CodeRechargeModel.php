<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeRechargeModel extends Model
{
    protected $table = 'codes_recharge';
    protected $primaryKey = 'id_code';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'code',
        'montant',
        'statut',
    ];
}
