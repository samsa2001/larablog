<?php

namespace App;
use App\PostImage;
use App\Tag;

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
    public function lastPost(){
        return $this->first();
    }

    public function tags(){
        // la relacion a muchos necesita una tabla pivote en nuestro caso post_tag 
        // si hemos nombrado la tabla con los modelos a relacionarse en sigular y alfabeticamente 
        // y hemos añadido el modelo_id a los campos podemos omitir los parámetros si no utilizar
        //return $this->belongsToMany(Tag::class, 'post_tag','post_id','tag_id')
        return $this->belongsToMany(Tag::class);
    }
}
