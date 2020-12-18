@extends('dashboard.master')
@section('content')  

@include('dashboard.partials.validation-error')    

<form action="{{ route('user.update',$user->id)}}" method="POST">
    {{-- especificamos el método de envío en PUT tal y como está definida la ruta 'php artisan route:list' --}}
    @method('PUT')
    @include('dashboard.user._form',['pasw'=>false])
</form>

@endsection