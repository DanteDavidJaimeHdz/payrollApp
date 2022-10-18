<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    use HasFactory;
    protected $table = "payroll_settings";
    public $timestamps = true;
    protected $fillable = ['min_salary', 'default_isr', 'extra_isr'];
}
