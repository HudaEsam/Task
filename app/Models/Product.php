<?php

namespace App\Models;

use Throwable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id','name','description','price',
    ];
public function category(){
    return $this->belongsTo(Category::class);

}

}
