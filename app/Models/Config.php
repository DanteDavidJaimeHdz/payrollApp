<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $table = "payroll_settings";
    public $timestamps = true;
    protected $fillable = ['semanal_days', 'day_hours', 'min_salary', 'default_hour_salary', 'default_isr', 'extra_isr'];
}
