<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowRight extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'description', 'enterpriseId', 'createdBy', 'createdAt',
        'updatedBy', 'updatedAt', 'softDeletedBy', 'softDeletedAt',
        'userIdForLog', 'deletedFlag'
    ];
}
