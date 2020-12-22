<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts(){
        // la relacion a muchos necesita una tabla pivote en nuestro caso post_tag 
        // si hemos nombrado la tabla con los modelos a relacionarse en sigular y alfabeticamente 
        // y hemos añadido el modelo_id a los campos podemos omitir los parámetros si no utilizar
        //return $this->belongsToMany(Tag::class, 'post_tag','post_id','tag_id')
        return $this->belongsToMany(Post::class);
    }
}

