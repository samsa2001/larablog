
    <?php // @csrf añade un token de seguridad para enviar el form, sin este token el formulario no funciona ?>
    @csrf  
    <div class="form-group">
        <label for="name">Nombre</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input type="text" name="name" class="form-control" id="name" value="{{ old('name',$user->name) }}">

        @error('name')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="surname">Apellido</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input type="text" name="surname" class="form-control" id="surname" value="{{ old('surname',$user->surname) }}">

        @error('surname')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input type="email" name="email" class="form-control" id="email" value="{{ old('email',$user->email) }}">

        @error('email')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    @if ($pasw)
    <div class="form-group">
        <label for="password">Password</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input type="password" name="password" class="form-control" id="password" value="{{ old('password',$user->password) }}">

        @error('password')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>    
    @endif

    <input type="submit" value="Enviar" class="btn btn-primary">
