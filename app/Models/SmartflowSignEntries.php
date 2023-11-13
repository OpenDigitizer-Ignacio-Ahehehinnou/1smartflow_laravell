<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowSignEntries extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentId', 'personId', 'level', 'statusAgreement',
        'comment', 'signature'
    ];
}
