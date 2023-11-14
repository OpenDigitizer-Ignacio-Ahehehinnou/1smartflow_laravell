<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowAuditTrail extends Model
{
    protected $table = 'smartflow_audit_trails';

    protected $primaryKey = 'auditTrailId';

    public $timestamps = false;

    protected $fillable = [
        'action', 'oldValue', 'newValue', 'tableName', 'createdAt',
        'deletedFlag', 'username', 'personId', 'personIp'
    ];

    public function smartflowPerson()
    {
        return $this->belongsTo(SmartflowPerson::class, 'personId');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

}

