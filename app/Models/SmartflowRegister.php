<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'enterpriseName', 'enterpriseAdress', 'enterpriseEmail', 'enterpriseIfu', 'enterprisePhone',
        'personFirstname', 'personLastname', 'personPassword', 'personUsername', 'personSignature', 'personFunction',
        'personPhone',

    ];
}
