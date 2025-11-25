<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ["name"];
    public $timestamps = false;

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'department_id');
    }

    public function officers()
    {
        return $this->hasMany(User::class)->whereHas('roles', function ($q) {
            $q->where('name', 'officer');
        });
    }
}
