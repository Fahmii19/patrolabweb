<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'audit_log';

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
