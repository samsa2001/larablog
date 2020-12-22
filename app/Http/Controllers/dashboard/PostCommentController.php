<?php

namespace App\Http\Controllers\dashboard;

use App\PostComment;
use App\Http\Controllers\Controller;
use App\Post;

class PostCommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // este middleware controla que el usuario está autenticado antes de poder acceder a las rutas de dashboard/comment 
    // sino lo redirige al login
    public function __construct()
    {
        $this->middleware(['auth','rol.admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // almacenamos en $postComments los datos obtenidos con el modelo PostComment. Para recuperar los datos podemos utilizar el get() o paginate()
        $postComments = PostComment::orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.post-comment.index', ['postComments' => $postComments]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(Post $post)
    {
        $posts = Post::all();
        $postComments = PostComment::
            orderBy('created_at', 'desc')
            ->where('post_id','=',$post->id)
            ->paginate(10);

        return view('dashboard.post-comment.post', [
            'postComments' => $postComments, 
            'posts'=>$posts,
            'post'=>$post ]);
    }
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
    {
        return view('dashboard.postComment.show',['postComment' => $postComment]);
    }

    public function jshow(PostComment $postComment)
    {
        return response()->json($postComment);
    }

    public function process(PostComment $postComment)
    {
        if($postComment->approved == '0'){
            $postComment->approved='1';
        } else {
            $postComment->approved='0';
        }
        
        $postComment->save();

        return response()->json($postComment->approved);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostComment $postComment)
    {
        $postComment->delete();

        return back()->with('status','Comentario eliminado con éxito');
    }
}
