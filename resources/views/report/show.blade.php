@extends('adminlte::page')

@section('template_title')
    {{ $report->name ?? __('Show') . " " . __('Report') }}
@endsection

@section('content')
    <section class="content container-fluid page-pad">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div>
                            <span class="card-title">{{ __('Show') }} {{ __('Report') }}</span>
                        </div>
                        <div class="ml-auto">
                            <a class="btn btn-primary btn-sm" href="{{ route('reports.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Reportante:</strong>
                                    {{ $report->person?->nombre ?? '-' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Aprobado:</strong>
                                    {{ (int)$report->aprobado === 1 ? 'Sí' : 'No' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Imagen:</strong>
                                    @if($report->imagen_url)
                                        <div><img src="{{ asset('storage/' . $report->imagen_url) }}" alt="img" style="max-height:180px;"></div>
                                    @else
                                        <span>-</span>
                                    @endif
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Observaciones:</strong>
                                    {{ $report->observaciones ?: '-' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Cantidad Animales:</strong>
                                    {{ $report->cantidad_animales }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dirección:</strong>
                                    {{ $report->direccion ?: '-' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Latitud:</strong>
                                    {{ $report->latitud ?: '-' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Longitud:</strong>
                                    {{ $report->longitud ?: '-' }}
                                </div>
                                @if(!is_null($report->latitud) && !is_null($report->longitud))
                                <div class="form-group mb-2 mb20">
                                    <strong>Ubicación:</strong>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div id="report_map" style="height: 320px; border-radius: 6px; overflow: hidden;"></div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@include('partials.leaflet')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var rawLat = @json($report->latitud);
    var rawLon = @json($report->longitud);
    var lat = parseFloat(rawLat);
    var lon = parseFloat(rawLon);
    var hasLat = rawLat !== null && rawLat !== '' && Number.isFinite(lat);
    var hasLon = rawLon !== null && rawLon !== '' && Number.isFinite(lon);
    if (hasLat && hasLon) {
        window.initStaticMap({
            mapId: 'report_map',
            lat: lat,
            lon: lon,
            zoom: 16,
            popup: @json($report->direccion ?? null),
        });
    }
});
</script>
@include('partials.page-pad')
@endsection
