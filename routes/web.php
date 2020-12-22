<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/test', function () {
    return "HOLA MUNDO" ;
});

Route::get('/hola/{nombre?}', function ($nombre='Juan') {
    return "Hola $nombre <a href='".route("nosotros1")."'>Sobre nosotros</a>" ;
});

Route::get('/sobre-nosotros', function () {
    return "<h1>Todo sobre nosotros</h1>" ;
})->name("nosotros1");
/*
Route::get('home/{nombre?}/{apellido?}', function ($nombre='Eric', $apellido='Pons') {
    //return view('home')->with("nombre",$nombre)->with("apellido",$apellido);
    $posts=["Post1","Post2","Post3","Post4"];
    return view('home',['nombre' => $nombre, 'apellido' => $apellido,'posts'=> $posts]);
})->name("home");
*/
Route::resource('dashboard/post', 'dashboard\PostController');
Route::post('dashboard/post/{post}/image', 'dashboard\PostController@image')->name('post.image');
// Ruta para cargar las imagenes dentro del editor CKeditor
Route::post('dashboard/post/content_image', 'dashboard\PostController@contentImage');

Route::resource('dashboard/category', 'dashboard\CategoryController');

Route::get('/', 'web\WebController@index')->name('index');

Route::get('detail/{id}','web\WebController@detail');
Route::get('post-category/{id}','web\WebController@post_category');
Route::get('categories','web\WebController@categories');

Route::get('contact','web\WebController@contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('dashboard/user', 'dashboard\UserController');

Route::resource('dashboard/contact', 'dashboard\ContactController')->only('index','show','destroy');

Route::resource('dashboard/post-comment', 'dashboard\PostCommentController')->only('index','show','destroy');
// devuelve los comentarios de un post
Route::get('dashboard/post-comment/{post}/post', 'dashboard\PostCommentController@post')->name('post-comment.post');
Route::get('dashboard/post-comment/j-show/{postComment}', 'dashboard\PostCommentController@jshow');
Route::post('dashboard/post-comment/process/{postComment}', 'dashboard\PostCommentController@process');
