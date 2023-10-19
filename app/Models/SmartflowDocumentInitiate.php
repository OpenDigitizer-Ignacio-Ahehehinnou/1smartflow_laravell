<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartflowDocumentInitiate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'documentId', 'status', 'userIdForLog',
    ];
}
