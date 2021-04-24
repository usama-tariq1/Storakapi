<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'user_id',
        'status',

    ];

    protected $hidden = [
        'status',
        'user_id', 
        'updated_at',
        'created_at'
    ];


    public function Category(){
        return $this->belongsTo(Category::class);
    }
}
