<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'cpf',
    ];
    protected $table = 'client';
    public function products()
    {
        return $this->belongsToMany(Product::class, 'client_products', 'client_id','product_id')->withPivot('quantity', 'discount', 'price_sales', 'status','date', 'created_at', 'update_at');
    }   

    
    
}
