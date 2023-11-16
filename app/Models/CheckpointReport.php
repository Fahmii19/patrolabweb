<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckpointReport extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'patrol_checkpoint_log';
}
