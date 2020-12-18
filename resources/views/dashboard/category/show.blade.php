@extends('dashboard.master')
@section('content')  

@include('dashboard.partials.validation-error')    
    <form action="{{ route("category.store")}}" method="POST">
    <?php // @csrf añade un token de seguridad para enviar el form, sin este token el formulario no funciona ?>
    @csrf  
    <div class="form-group">
        <label for="title">Titulo</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input readonly type="text" name="title" class="form-control" id="title" value="{{ $category->title}}">

        @error('title')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="url_clean">URL limpia</label>
        <input readonly type="text" name="url_clean" class="form-control" value="{{ $category->url_clean }}">

        @error('url_clean')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    </form>
@endsection