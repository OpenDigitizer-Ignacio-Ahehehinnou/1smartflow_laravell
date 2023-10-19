<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowFunction extends Model
{
    use HasFactory;

    protected $primaryKey = 'functionId';
    protected $table = 'smartflow_functions';

    protected $fillable = [
        'libelle',
        'createdAt',
        'deletedFlag',
        'userIdForLog',
        'enterpriseId',
        'createdBy',
        'updatedBy',
        'updatedAt',
        'softDeletedBy',
        'softDeletedAt',
    ];

    public function enterprise()
    {
        return $this->belongsTo(SmartflowEnterprise::class, 'enterpriseId', 'enterpriseId');
    }

    public function smartflowPersons()
    {
        return $this->hasMany(SmartflowPerson::class, 'functionId', 'functionId');
    }
}
