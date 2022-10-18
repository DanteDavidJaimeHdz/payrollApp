<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    public $timestamps = true;
    protected $fillable = ['description', 'subtotal', 'total'];

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductOrder::class,
            'product_id', // Foreign key on the environments table...
            'environment_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }
}
