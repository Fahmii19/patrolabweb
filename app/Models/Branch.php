<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'branch';

    // Define the fillable attributes
    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    // Define relationships here if needed
    // For example, if a branch has many projects
    // public function projects()
    // {
    //     return $this->hasMany(Project::class);
    // }
}
