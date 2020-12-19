<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\CustomUrl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\StoreCategoryPost;
use App\Http\Requests\UpdateCategoryPut;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $categories = Category::orderBy('created_at','desc')->paginate(5);
        return view('dashboard.category.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // tenenmos que pasar como parámetro una instancia a una cat vacío porque la view _form necesita una variable
        // cat para rellenar los campos por defecto
        return view('dashboard.category.create',['category'=>new Category()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPost $request)
    {
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
        $validator = Validator::make($requestData, StoreCategoryPost::myRules());
        if ($validator->fails()) {
            return redirect('dashboard/category/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        // llamada al Category Post para añadir a la base de datos 
        Category::create($requestData);

        return back()->with('status','Categoría creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.category.show',['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {        
        return view('dashboard.category.edit',['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryPut $request, Category $category)
    {
        $category->update($request->validated());

        return back()->with('status','Categoría actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('status','Categoría eliminada con éxito');
    }
}
