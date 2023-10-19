<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowEnterprise extends Model
{
    use HasFactory;

    protected $table = 'smartflow_enterprises';

    protected $primaryKey = 'enterpriseId';

    public $timestamps = false;

    protected $fillable = [
        'address', 'email', 'ifu', 'name', 'manager', 'telephone',
        'createdAt', 'deletedFlag', 'userIdForLog', 'enterpriseParentCompanyId',
        'createdBy', 'updatedBy', 'updatedAt', 'softDeletedBy', 'softDeletedAt'
    ];

    public function smartflowEnterprise()
    {
        return $this->belongsTo(SmartflowEnterprise::class, 'enterpriseParentCompanyId');
    }

    public function listOfSmartflowPerson()
    {
        return $this->hasMany(SmartflowPerson::class, 'enterpriseId');
    }

    public function listOfSmartflowFunction()
    {
        return $this->hasMany(SmartflowFunction::class, 'enterpriseId');
    }

    public function listOfSmartflowRole()
    {
        return $this->hasMany(SmartflowRole::class, 'enterpriseId');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function getSoftDeletedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

}


