@extends('adminlte::page')

@section('template_title')
    {{ __('Detalle de Historial #') . $animalHistory->id }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Detalle de Historial') }} #{{ $animalHistory->id }}</span>
                    </div>
                    <div class="card-body bg-white">
                        <div class="mb-3">
                            <strong>Hoja de Animal:</strong> #{{ $animalHistory->animal_file_id }}
                        </div>
                        <div class="mb-3">
                            <strong>Animal:</strong> {{ $animalHistory->animalFile?->animal?->nombre ?? '-' }}
                        </div>
                        <div class="mb-3">
                            <strong>Fecha de cambio:</strong> {{ $animalHistory->changed_at ?? '' }}
                        </div>
                        <div class="mb-3">
                            <strong>Observaciones:</strong>
                            @php
                                $obs = $animalHistory->observaciones;
                                $obsText = is_array($obs) ? ($obs['texto'] ?? json_encode($obs, JSON_UNESCAPED_UNICODE)) : ($obs ?? '-');
                            @endphp
                            <div>{{ $obsText }}</div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ __('Valores Nuevos') }}</h5>
                                <pre style="white-space: pre-wrap">{{ json_encode($animalHistory->valores_nuevos, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                            <div class="col-md-6">
                                <h5>{{ __('Valores Antiguos') }}</h5>
                                <pre style="white-space: pre-wrap">{{ json_encode($animalHistory->valores_antiguos, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>

                        <a href="{{ route('animal-histories.index') }}" class="btn btn-secondary mt-3">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


