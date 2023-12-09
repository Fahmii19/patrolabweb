<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolCheckpointLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'patrol_checkpoint_log';

    public function guards()
    {
        return $this->belongsTo(Guard::class, 'guard_id', 'id');
    }    
    public function checkpoint()
    {
        return $this->belongsTo(CheckPoint::class, 'checkpoint_id', 'id');
    }

    public function asset_checkpoint_log()
    {
        return $this->hasMany(AssetCheckpointLog::class, 'patrol_checkpoint_id', 'id');
    }
}
