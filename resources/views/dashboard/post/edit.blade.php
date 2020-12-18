@extends('dashboard.master')
@section('content')  

@include('dashboard.partials.validation-error')    

<form action="{{ route('post.update',$post->id)}}" method="POST">
    {{-- especificamos el método de envío en PUT tal y como está definida la ruta 'php artisan route:list' --}}
    @method('PUT')
    @include('dashboard.post._form')
</form>
<form action="{{ route('post.image',$post->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row my-4">
        <div class="col">
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="col">
            <input type="submit" class="btn btn-primary" value="Subir">
        </div>
    </div>    
</form>
@endsection