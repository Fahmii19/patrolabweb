<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'areas';

    public function project(){
        return $this->belongsTo(ProjectModel::class,'project_id');
    }
    public function data_guards(){
        return $this->hasMany(Area::class,'id_area');
    }

    public function checkpoints()
    {
        return $this->hasMany(CheckPoint::class, 'id_area');
    }

    public function selfpatrols()
    {
        return $this->hasMany(SelfPatrol::class, 'id_area');
    }

    public function atensis()
    {
        return $this->hasMany(Atensi::class, 'id_area');
    }

    public function incomingvehicle()
    {
        return $this->hasMany(incomingvehicle::class, 'id_area');
    }

    public function outcomingvehicle()
    {
        return $this->hasMany(incomingvehicle::class, 'id_area');
    }
}
