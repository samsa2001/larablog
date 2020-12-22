@extends('dashboard.master')
@section('content')  

    <div class="form-group">
        <label for="title">Titulo</label>
        <input readonly type="text" class="form-control"  value="{{ $postComment->title}}">
    </div>
    <div class="form-group">
        <label for="url_clean">Usuario</label>
        <input readonly type="text" name="url_clean" class="form-control" value="{{ $postComment->user->name }}">
    </div>
    <div class="form-group">
        <label for="url_clean">Aprobado</label>
        <input readonly type="text" name="url_clean" class="form-control" value="{{ $postComment->approved }}">
    </div>
    <div class="form-group">
        <label for="content">Contenido</label>
        <textarea readonly name="content" class="form-control"  rows="3">{{ $postComment->message }}</textarea>
    </div>
    </form>
@endsection