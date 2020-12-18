<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class PostImage extends Model 
{
    protected $fillable = ['post_id', 'image'];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
