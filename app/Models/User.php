<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username', 'name', 'password'
    ];
}
