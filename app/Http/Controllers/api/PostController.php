<?php

namespace App\Http\Controllers\api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use PhpParser\Node\Expr\Cast\String_;

// en vez de extender de Controller extiende de un controlador que hemos creado y que llama al trait que hemos creado ApiResponse
class PostController extends ApiResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                
        $posts = Post::
        join('post_images','post_images.post_id','=','posts.id')->
        join('categories','categories.id','=','posts.category_id')->
        select('posts.*','categories.title as category','post_images.image')->
        orderBy('posts.created_at','desc')->paginate(6);
        // se referencia esta petición y se envía al método del trait successResponse que devuelve los datos
        return $this -> successResponse($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->image;
        $post->category;
        //return response()->json(array('data' => $post, 'code' => 500, 'msj' =>''),500);
        return $this -> successResponse($post);
    }

    /**
     * Display the specified resource with an url_clean.
     *
     * @param  String  $url_clean
     * @return \Illuminate\Http\Response
     */
    public function url_clean(String $url_clean='0')
    {
        $post=Post::where('url_clean',$url_clean)->firstOrFail();
        $post->image;
        $post->category;
        return $this -> successResponse($post);
    }

    /**
     * Devuelve los post de una categoria.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {       
        $posts = Post::
        join('post_images','post_images.post_id','=','posts.id')->
        join('categories','categories.id','=','posts.category_id')->
        select('posts.*','categories.title as category','post_images.image')->
        orderBy('posts.created_at','desc')->
        where('categories.id',$category->id)->
        paginate(6);
        // se referencia esta petición y se envía al método del trait successResponse que devuelve los datos        
        return $this -> successResponse(['posts' => $posts, 'category' =>$category]);
    }

}
