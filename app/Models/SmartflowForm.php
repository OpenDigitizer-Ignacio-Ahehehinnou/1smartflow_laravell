<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowForm extends Model
{
    use HasFactory;

    protected $table = 'smartflow_forms';

    public $timestamps = false;

    protected $fillable = [
        'formId', 'content', 'name', 'agreeLevelNumber', 'createdBy', 'createdAt',
        'deletedFlag', 'status', 'userIdForLog', 'updatedAt',
        'softDeletedAt', 'updatedBy', 'softDeletedBy'
    ];

    public function listOfSmartflowFormAgreement()
    {
        return $this->hasMany(SmartflowFormAgreement::class, 'formId');
    }

    public function listOfSmartflowDocument()
    {
        return $this->hasMany(SmartflowDocument::class, 'formId');
    }

    public function listOfSmartflowFormView()
    {
        return $this->hasMany(SmartflowFormView::class, 'formId');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }
}
