<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    protected $table = "movements";
    public $timestamps = true;
    protected $fillable = ['employee_id', 'month', 'deliveries', 'base','extra_bonus', 'food_bonus','extra_deliveries', 'subtotal', 'total_isr', 'total_payroll'];
}
