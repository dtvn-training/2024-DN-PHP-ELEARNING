<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Authentication extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'authentications';
    
    protected $primaryKey = 'authentication_id';

    protected $fillable = [
        'account',
        'password',
        'identifier_email',
        'authentication_state',
        'authorization_id',
        'deleted_flag',
    ];
    
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'authentication_state' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
