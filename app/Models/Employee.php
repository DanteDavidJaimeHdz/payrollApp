<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
    //public $timestamps = true;
    protected $fillable = ['name', 'lastname', 'role_id','created_at', 'updated_at', 'deleted_at'];
}
