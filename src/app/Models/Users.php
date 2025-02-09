<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *i
     * @var array<int, string>
     */


    public $timestamps = false;
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'joined_date',
        'password',
    ];
    // serve para buscar a funcao de um usuario
    public function role(){
        return $this->belongsTo(Roles::class);
    }

}
