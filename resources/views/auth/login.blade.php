@extends('adminlte::auth.login')
@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('register') }}">Crear cuenta nueva</a>
    </p>
@endsection
@push('css')
<style>
    .main-sidebar { display: none !important; }
    .content-wrapper { margin-left: 0 !important; }
</style>
@endpush