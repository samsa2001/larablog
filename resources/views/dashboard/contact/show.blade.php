@extends('dashboard.master')
@section('content')  

    <div class="form-group">
        <label for="title">nombre</label>
        <input readonly type="text" class="form-control"  value="{{ $contact->name}}">
    </div>
    <div class="form-group">
        <label for="url_clean">Apellido</label>
        <input readonly type="text" name="url_clean" class="form-control" value="{{ $contact->surname }}">
    </div>
    <div class="form-group">
        <label for="url_clean">Email</label>
        <input readonly type="text" name="url_clean" class="form-control" value="{{ $contact->email }}">
    </div>
    <div class="form-group">
        <label for="content">Contenido</label>
        <textarea readonly name="content" class="form-control"  rows="3">{{ $contact->message }}</textarea>
    </div>
    </form>
@endsection