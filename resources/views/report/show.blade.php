@extends('adminlte::page')

@section('template_title')
    {{ $report->name ?? __('Show') . " " . __('Report') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Report</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('reports.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Reporte Id:</strong>
                                    {{ $report->reporte_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Reportador Id:</strong>
                                    {{ $report->reportador_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad Animales:</strong>
                                    {{ $report->cantidad_animales }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Longitud:</strong>
                                    {{ $report->longitud }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Latitud:</strong>
                                    {{ $report->latitud }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion:</strong>
                                    {{ $report->direccion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Centro Id:</strong>
                                    {{ $report->centro_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Aprobado Id:</strong>
                                    {{ $report->aprobado_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Detalle Aprobado:</strong>
                                    {{ $report->detalle_aprobado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Creacion:</strong>
                                    {{ $report->fecha_creacion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Actualizacion:</strong>
                                    {{ $report->fecha_actualizacion }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
