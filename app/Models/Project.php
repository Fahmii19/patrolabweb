<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'projects';

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'city_id', 'id');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'project_id', 'id');
    }

    public function data_guards()
    {
        return $this->belongsToMany(Guard::class, 'pivot_guard_projects', 'id_guard', 'id_project');
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

    public function gate()
    {
        return $this->hasMany(Gate::class, 'project_id', 'id');
    }
}
