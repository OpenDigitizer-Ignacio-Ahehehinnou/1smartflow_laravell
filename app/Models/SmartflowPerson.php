<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartflowPerson extends Model
{
    use HasFactory;
        protected $table = 'smartflow_persons';

        protected $fillable = [
            'firstName',
            'lastName',
            'password',
            'telephone',
            'username',
            'enterpriseId',
            'functionId',
            'signature',
            'createdAt',
            'createdBy',
            'deletedFlag',
            'isAccountNonExpired',
            'isAccountNonLocked',
            'isCredentialsNonExpired',
            'isEnabled',
            'userIdForLog',
            'roleId',
            'updatedBy',
            'updatedAt',
            'softDeletedBy',
            'softDeletedAt',
        ];

        public function smartflowRole()
        {
            return $this->belongsTo('SmartflowRole', 'roleId');
        }

        public function smartflowFunction()
        {
            return $this->belongsTo('SmartflowFunction', 'functionId');
        }

        public function smartflowEnterprise()
        {
            return $this->belongsTo('SmartflowEnterprise', 'enterpriseId');
        }

        public function listOfSmartflowAuditTrail()
        {
            return $this->hasMany('SmartflowAuditTrail', 'personId');
        }

        public function listOfSmartflowFormAgreement()
        {
            return $this->hasMany('SmartflowFormAgreement', 'personId');
        }

        public function listOfSmartflowFormView()
        {
            return $this->hasMany('SmartflowFormView', 'personId');
        }

        public function listOfSmartflowNotification()
        {
            return $this->hasMany('SmartflowNotification', 'personId');
        }

        public function listOfSmartflowDocumentAgreement()
        {
            return $this->hasMany('SmartflowDocumentAgreement', 'personId');
        }
    }

