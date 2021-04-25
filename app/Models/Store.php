<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',
        'image',
        'code'

    ];

    protected $hidden = [
        'status',
        'user_id', 
        // 'updated_at',
        // 'created_at'
    ];



}
