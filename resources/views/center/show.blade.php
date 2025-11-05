@extends('adminlte::page')
@section('template_title')
    {{ $center->name ?? __('Show') . " " . __('Center') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Center</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('centers.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $center->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Telefono:</strong>
                                    {{ $center->telefono }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Longitud:</strong>
                                    {{ $center->longitud }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Latitud:</strong>
                                    {{ $center->latitud }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion:</strong>
                                    {{ $center->direccion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Capacidad Maxima:</strong>
                                    {{ $center->capacidad_maxima }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Creacion:</strong>
                                    {{ $center->fecha_creacion }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
