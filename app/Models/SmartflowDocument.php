<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowDocument extends Model
{
    protected $table = 'smartflow_documents';

    protected $primaryKey = 'documentId';

    public $timestamps = false;

    protected $fillable = [
        'content', 'name', 'formId', 'createdBy', 'createdAt',
        'deletedFlag', 'terminatedAt', 'status', 'agreeLevelNumber',
        'actualAgreeLevel', 'userIdForLog', 'updatedBy', 'updatedAt',
        'softDeletedBy', 'softDeletedAt','contentTable'
    ];

    public function smartflowForm()
    {
        return $this->belongsTo(SmartflowForm::class, 'formId');
    }

    public function listOfSmartflowDocumentAgreement()
    {
        return $this->hasMany(SmartflowDocumentAgreement::class, 'documentId');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

}

