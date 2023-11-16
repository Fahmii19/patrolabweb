<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'projects';

    public function data_wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'city_id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'id_project');
    }

    public function data_guards()
    {
        return $this->belongsToMany(Guard::class,'pivot_guard_projects','id_guard','id_project');
    }

    public function checkpoints()
    {
        return $this->hasMany(CheckPoint::class, 'id_project');
    }

    public function selfpatrols()
    {
        return $this->hasMany(SelfPatrol::class, 'id_project');
    }

    public function atensis()
    {
        return $this->hasMany(Atensi::class, 'id_project');
    }

    public function incomingvehicle()
    {
        return $this->hasMany(incomingvehicle::class, 'id_project');
    }

    public function outcomingvehicle()
    {
        return $this->hasMany(incomingvehicle::class, 'id_project');
    }
    
}
