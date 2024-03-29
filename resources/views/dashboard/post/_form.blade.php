
    <?php // @csrf añade un token de seguridad para enviar el form, sin este token el formulario no funciona ?>
    @csrf  
    <div class="form-group">
        <label for="title">Titulo</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input type="text" name="title" class="form-control" id="title" value="{{ old('title',$post->title) }}">

        @error('title')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="url_clean">URL limpia</label>
        <input type="text" name="url_clean" class="form-control" value="{{ old('url_clean',$post->url_clean) }}">

        @error('url_clean')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="category_id">Categoria</label>
        <select name="category_id" id="category_id" class="form-control">
            @foreach ($categories as $title=>$id)
                <option {{ $post->category_id == $id ? 'selected="selected"':''}} value="{{ $id }}">{{ $title }}</option>
            @endforeach            
        </select>
    </div>
    <div class="form-group">
        <label for="tags_id">Etiquetas</label>
        <select multiple name="tags_id[]" id="tags_id" class="form-control">
            @foreach ($tags as $title=>$id)
                <option {{ in_array($id,old('tags_id') ?: $post->tags()->pluck('id')->toArray()) ? "selected": "" }} value="{{ $id }}">{{ $title }}</option>
            @endforeach            
        </select>
    </div>
    <div class="form-group">
        <label for="posted">Publicado</label>
        <select name="posted" class="form-control">
            @include('dashboard.partials.option-yes-not', ['val' =>$post->posted])          
        </select>
    </div>
    <div class="form-group">
        <label for="content">Contenido</label>
        <textarea id="content" name="content"  class="form-control" rows="3">{{ old('content',$post->content) }}</textarea>

        @error('content')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
{{--     token para la carga de imagenes de CKeditor --}}
    <input type="hidden" id="token" value="{{ csrf_token()}}">
    
    <input type="submit" value="Enviar" class="btn btn-primary">
