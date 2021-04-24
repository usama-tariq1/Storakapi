<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',

    ];

    protected $hidden = [
        'status',
        'user_id', 
        'updated_at',
        'created_at'
    ];

    public function subcategories(){
        return $this->hasMany(SubCategory::class);
    }
}
