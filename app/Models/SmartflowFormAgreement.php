<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowFormAgreement extends Model
{
    use HasFactory;

        protected $table = 'smartflow_form_agreements';

        public $timestamps = false;

        protected $fillable = [
            'level', 'formId', 'personId', 'createdAt',
            'levelName', 'deletedFlag', 'userIdForLog', 'createdBy'
        ];

        public function smartflowForm()
        {
            return $this->belongsTo(SmartflowForm::class, 'formId');
        }

        public function smartflowPerson()
        {
            return $this->belongsTo(SmartflowPerson::class, 'personId');
        }

        public function getCreatedAtAttribute($value)
        {
            return date('Y-m-d H:i:s', strtotime($value));
        }

    }
