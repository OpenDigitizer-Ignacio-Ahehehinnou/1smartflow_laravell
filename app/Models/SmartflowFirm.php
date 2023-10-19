<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowFirm extends Model
{
    use HasFactory;

    protected $table = 'smartflow_firms';

    protected $primaryKey = 'enterpriseId';

    public $timestamps = false;

    protected $fillable = [
        'enterpriseAdress', 'enterpriseEmail', 'enterpriseIfu', 'enterpriseName','enterprisePhone',
        'personFirstname', 'personLastname', 'personPassword', 'enterpriseParentCompanyId',
        'personUsername', 'personSignature', 'personFunction', 'personPhone',
    ];
}
