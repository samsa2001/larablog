<?php

namespace App\Http\Controllers\api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends ApiResponseController
{
    public function all(){
        return $this->successResponse(Category::all());
    }
    public function index(){
        return $this->successResponse(Category::paginate(10));
    }
}
