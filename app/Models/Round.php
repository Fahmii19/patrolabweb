<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'rounds';

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id');
    }

    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'id_project', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    public function checkpoint()
    {
        return $this->hasMany(CheckPoint::class, 'round_id', 'id');
    }
}
