<?php

namespace App;
use App\PostImage;

use Illuminate\Database\Eloquent\Model;

// laravel usa como nombre de la tabla de DB el nombre de la clase en plural, en este caso Posts
class Post extends Model
{
    protected $fillable = ['title', 'url_clean', 'content','category_id','posted'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function image(){
        return $this->hasOne(PostImage::class);
    }
}
