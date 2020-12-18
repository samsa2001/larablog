
    <?php // @csrf añade un token de seguridad para enviar el form, sin este token el formulario no funciona ?>
    @csrf  
    <div class="form-group">
        <label for="title">Titulo</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input type="text" name="title" class="form-control" id="title" value="{{ old('title',$category->title) }}">

        @error('title')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="url_clean">URL limpia</label>
        <input type="text" name="url_clean" class="form-control" value="{{ old('url_clean',$category->url_clean) }}">

        @error('url_clean')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <input type="submit" value="Enviar" class="btn btn-primary">
