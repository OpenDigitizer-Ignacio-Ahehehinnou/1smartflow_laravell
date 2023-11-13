<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowDocumentAgreement extends Model
{
        protected $table = 'smartflow_document_agreements';

        public $timestamps = false;

        protected $fillable = [
            'documentId', 'personId', 'level', 'documentAgreementSignature',
            'deletedFlag', 'statusAgreement', 'approvedAt', 'receivedAt',
            'comment', 'lastRelance', 'userIdForLog', 'createdAt', 'createdBy'
        ];

        public function smartflowDocument()
        {
            return $this->belongsTo(SmartflowDocument::class, 'documentId');
        }

        public function smartflowPerson()
        {
            return $this->belongsTo(SmartflowPerson::class, 'personId');
        }

        public function getApprovedAtAttribute($value)
        {
            return date('Y-m-d H:i:s', strtotime($value));
        }

        public function getReceivedAtAttribute($value)
        {
            return date('Y-m-d H:i:s', strtotime($value));
        }

        public function getCreatedAtAttribute($value)
        {
            return date('Y-m-d H:i:s', strtotime($value));
        }
    }
