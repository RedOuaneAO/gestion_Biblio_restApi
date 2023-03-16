<?php

namespace App\Models;
use App\Models\books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $fillable=[  'category' ];

    public function books(){
        $this->hasMany(books::class);
    }
}
