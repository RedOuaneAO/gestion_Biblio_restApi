<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\categories;

class books extends Model
{
    use HasFactory;
    protected $hidden = ['id', 'created_at', 'updated_at' , 'category_id'];
    protected $fillable=[
        'title',
        'image',
        'description',
        'price',
        'user_id',
        'category_id',
        'isbn',
        'auteur'
    ];
    public function category(){
        return $this->belongsTo(categories::class);
    }
}
