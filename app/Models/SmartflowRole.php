<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowRole extends Model
{
    use HasFactory;

    protected $table = 'smartflow_roles';

    protected $primaryKey = 'roleId';

    public $timestamps = false;

    protected $fillable = [
        'label', 'description', 'enterpriseId', 'createdBy', 'createdAt',
        'updatedBy', 'updatedAt', 'softDeletedBy', 'softDeletedAt',
        'userIdForLog', 'deletedFlag', 'listOfSmartflowRightId'
    ];

     protected $casts = [
        'listOfSmartflowRightId' => 'array',
    ];

    public function listOfSmartflowPerson()
    {
        return $this->hasMany(SmartflowPerson::class, 'roleId');
    }

    public function smartflowEnterprise()
    {
        return $this->belongsTo(SmartflowEnterprise::class, 'enterpriseId');
    }

    public function listOfSmartflowRight()
    {
        return $this->hasMany(SmartflowRight::class, 'roleId');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

}
