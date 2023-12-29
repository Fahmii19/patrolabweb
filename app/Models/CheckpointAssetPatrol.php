<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckpointAssetPatrol extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'asset_patrol_checkpoint';
    public $timestamps = true;
    
    public function checkpoint()
    {
        return $this->belongsTo(CheckPoint::class, 'checkpoint_id', 'id');
    }

    public function asset()
    {
        return $this->belongsTo(Aset::class, 'asset_master_id', 'id');
    }
}
