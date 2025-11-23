@extends('adminlte::page')

@section('template_title')
    {{ __('Historial de Animales') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Historial de Animales') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Hoja</th>
                                    <th>Animal</th>
                                    <th>Fecha de cambio</th>
                                    <th>Resumen</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($histories as $h)
                                    @php
                                        $nuevo = $h->valores_nuevos ?? [];
                                        $care = $nuevo['care'] ?? [];
                                        $descripcion = $care['descripcion'] ?? null;
                                        $observTxt = is_array($h->observaciones ?? null) ? ($h->observaciones['texto'] ?? null) : null;
                                    @endphp
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>#{{ $h->animal_file_id }}</td>
                                        <td>{{ $h->animalFile?->animal?->nombre ?? '-' }}</td>
                                        <td>{{ $h->changed_at ?? '' }}</td>
                                        <td>
                                            {{ $descripcion ? Str::limit($descripcion, 60) : ($observTxt ? Str::limit($observTxt, 60) : '-') }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ route('animal-histories.show', $h->id) }}">
                                                <i class="fa fa-fw fa-eye"></i> {{ __('Show') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $histories->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection


