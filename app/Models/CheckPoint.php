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
    public function cpas()
    {
        return $this->hasMany(CheckpointAset::class, 'id_check_point');
    }
}
