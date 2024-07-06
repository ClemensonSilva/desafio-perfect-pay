<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable  = [
        'id',
        'client_id',
        'product_id',
        'description',
        'quantity',
        'name',
        'date',
        'status',
        'price'
    ];
    protected $table = 'products';
    public function clients() 
    {
        return $this->belongsToMany(Client::class, 'client_products','product_id', 'client_id' )->withPivot('quantity', 'discount', 'status','date', 'created_at', 'update_at');
    }
}