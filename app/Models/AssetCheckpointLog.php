<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCheckpointLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'asset_patrol_checkpoint_log';

    public function asset()
    {
        return $this->belongsTo(Aset::class, 'asset_id', 'id');
    }
    public function asset_unsafe_option()
    {
        return $this->belongsTo(AssetUnsafeOption::class, 'asset_unsafe_option_id', 'id');
    }
    public function patrol_checkpoint()
    {
        return $this->belongsTo(PatrolCheckpointLog::class, 'patrol_checkpoint_id', 'id');
    }
}
