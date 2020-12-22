<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Helpers\CustomUrl;
use App\Post;
use App\PostImage;
use App\Http\Requests\StorePostPost;
use App\Http\Requests\UpdatePostPut;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // este middleware controla que el usuario está autenticado antes de poder acceder a las rutas de dashboard/post 
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
        // almacenamos en $posts los datos obtenidos con el modelo Post. Para recuperar los datos podemos utilizar el get() o paginate()
        //$posts = Post::orderBy('created_at','desc')->get();
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('dashboard.post.index',['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // tenenmos que pasar como parámetro una instancia a un post vacío porque la view _form necesita una variable
        // post para rellenar los campos por defecto
        $tags = Tag::pluck('id','title');
        $categories = Category::pluck('id','title');
        return view('dashboard.post.create',['post'=>new Post(), 'categories'=>$categories, 'tags'=>$tags]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostPost $request)
    {
        // Se validan en Request fichero StorePostPost
        /*
        $request->validate([
            'title' => 'required|min:5|max:500',
            //'url_clean' => 'required|min:5|max:500',
            'content' => 'required|min:5'
        ]);
        */

        // CustomUrl:: es un helper que contiene algunas funciones que se utilizan en nuestra app, el helper está 
        // en app/Helper . Para que el helper pueda llamarse debe declararse en composer.json -> autoload_dev -> files
        // y ejecutar en comando desde consola 'composer dump-autoload'
        if($request->url_clean == ""){
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->title),'-',true);
        } else {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->url_clean),'-',true);
        }
        // validamos con las reglas que hemos definido en 'Requests->StorePostPost
        $requestData = $request->validated();
        $requestData['url_clean'] = $urlClean;
        // validamos con el validador de laravel 
        // la función make necesita dos parámetros, el segundo son nuestras própias validaciones
        $validator = Validator::make($requestData, StorePostPost::myRules());
        if ($validator->fails()) {
            return redirect('dashboard/post/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        // llamada al modelo Post para añadir a la base de datos 
        Post::create($requestData);
        // añadimos una imagen vacia para este post, ultimo creado
        $ultimoPost= Post::orderBy('created_at', 'desc')->first();
        PostImage::create(['image'=>"", 'post_id'=>$ultimoPost->id]);

        return back()->with('status','Post creado con éxito');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function show($id)
    {
        $post=Post::findOrFail($id);
        return view('dashboard.post.show',['post' => $post]);
    }
    */
    public function show(Post $post)
    {
        return view('dashboard.post.show',['post' => $post]);
    }
    /**
     * Display the specified resource con una url limpia.
     *
     * @param  string $url_clean
     * @return \Illuminate\Http\Response
     */
/*     public function url_clean(String $url_clean)
    {
        return view('dashboard.post.show',['post' => $post]);
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {        
        //dd($post->tags);
        // pluck devuelve una coleccion pero sólo de las claves especificadas
        $tags = Tag::pluck('id','title');
        $categories = Category::pluck('id','title');
        return view('dashboard.post.edit',['post' => $post, 'categories'=>$categories, 'tags'=>$tags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostPut $request, Post $post)
    {
        $post->update($request->validated());

        return back()->with('status','Post actualizado con éxito');
    }

    /**
     * Update an image for the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request, Post $post)
    {
        // recogemos el campo enviado por el formulario, image, y lo validamos
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,bmp,png|max:2048' // 2Mb
        ]);
        // añadimos un nombre, time=segundos desde 1970, + extensión del archivo
        $filename = time() . "." . $request->image->extension();
        
        // copiamos la imagen a la carpeta public\images + filename
        $request->image->move(public_path('images'), $filename);
        
        // comprobamos si ese post ya tiene una imagen principal
        $postsConEsaImagen= PostImage::where('post_id',$post->id)->get(); 
        if ($postsConEsaImagen != null){
            //dd($postsConEsaImagen);
            foreach($postsConEsaImagen as $postConEsaImagen){
                PostImage::where('id',$postConEsaImagen->id)->delete();
            }
        }

        // añadimos a la tabla PostImages un campo nuevo
        PostImage::create(['image'=>$filename, 'post_id'=>$post->id]);

        return back()->with('status','Imagen cargada con éxito');
    }
    /**
     * Update an image inside de Ckeditor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function contentImage(Request $request)
    {
        // recogemos el campo enviado por el formulario, image, y lo validamos
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,bmp,png|max:2048' // 2Mb
        ]);
        // añadimos un nombre, time=segundos desde 1970, + extensión del archivo
        $filename = time() . "." . $request->image->extension();
        
        // copiamos la imagen a la carpeta public\images + filename
        $request->image->move(public_path('images_post'), $filename);

        return response()->json(["default" => URL::to('/') . '/images_post/' . $filename]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('status','Post eliminado con éxito');
    }
}
