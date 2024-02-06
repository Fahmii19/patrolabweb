<?php

namespace App\Models;

use App\Http\Controllers\AssetClientCheckpointController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolCheckpointLog extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'patrol_checkpoint_log';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function pleton()
    {
        return $this->belongsTo(Pleton::class, 'pleton_id', 'id');
    }

    public function checkpoint()
    {
        return $this->belongsTo(CheckPoint::class, 'checkpoint_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function asset_client_checkpoint()
    {
        return $this->belongsTo(CheckpointAssetClient::class, 'safe_asset_client_checkpoint_id', 'id');
    }

    public function asset_patrol_checkpoint_log()
    {
        return $this->hasMany(AssetPatrolCheckpointLog::class, 'patrol_checkpoint_log_id', 'id');
    }

    public function getStatusAttribute()
    {
        $unsafeCount = $this->asset_patrol_checkpoint_log->where('status', 'UNSAFE')->count();

        return ($unsafeCount > 0) ? 'unsafe' : 'safe';
    }
}
