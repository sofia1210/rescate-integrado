@extends('adminlte::auth.register')
@push('css')
<style>
    .main-sidebar { display: none !important; }
    .content-wrapper { margin-left: 0 !important; }
</style>
@endpush

@section('auth_body')
    <form action="{{ route('register') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="text" name="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nombre completo" value="{{ old('name') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
            @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        <div class="input-group mb-3">
            <input type="email" name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Correo electrónico" value="{{ old('email') }}" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
            @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                class="form-control"
                placeholder="Confirmar contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="rol">Rol</label>
            <select name="rol" id="rol"
                class="form-control @error('rol') is-invalid @enderror" required>
                <option value="" disabled {{ old('rol') ? '' : 'selected' }}>Seleccione rol</option>
                <option value="ciudadano"   {{ old('rol')=='ciudadano' ? 'selected' : '' }}>Ciudadano</option>
                <option value="rescatista"  {{ old('rol')=='rescatista' ? 'selected' : '' }}>Rescatista</option>
                <option value="veterinario" {{ old('rol')=='veterinario' ? 'selected' : '' }}>Veterinario</option>
                <option value="cuidador"    {{ old('rol')=='cuidador' ? 'selected' : '' }}>Cuidador</option>
                <option value="encargado"   {{ old('rol')=='encargado' ? 'selected' : '' }}>Encargado</option>
                <option value="administrador" {{ old('rol')=='administrador' ? 'selected' : '' }}>Administrador</option>
            </select>
            @error('rol') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            Registrarme
        </button>
    </form>
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">Ya tengo una cuenta</a>
    </p>
@endsection