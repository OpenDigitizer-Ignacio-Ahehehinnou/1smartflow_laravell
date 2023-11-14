<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowPersonLite extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'verificationCode', 'password', 'personId'
    ];
}
