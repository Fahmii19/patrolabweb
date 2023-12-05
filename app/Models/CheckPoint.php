<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckPoint extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'checkpoint';

    public function round()
    {
        return $this->belongsTo(Round::class, 'round_id');
    }
    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'id_project');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }
    public function checkpoint_asset_client()
    {
        return $this->hasMany(CheckpointAssetClient::class, 'checkpoint_id');
    }
    public function checkpoint_asset_patrol()
    {
        return $this->hasMany(CheckpointAssetPatrol::class, 'checkpoint_id');
    }
}
