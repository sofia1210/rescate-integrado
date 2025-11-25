@extends('adminlte::page')

@section('template_title')
    Transfers
@endsection

@section('content')
    <div class="container-fluid page-pad">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Transfers') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('transfers.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <ul class="nav nav-pills mb-3" id="transferTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab">{{ __('Primer traslado') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="internal-tab" data-toggle="tab" href="#internal" role="tab">{{ __('Traslado entre centros') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab">{{ __('Historial') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                                <div class="row">
                                    @forelse(($reportsFirst ?? []) as $report)
                                        <div class="col-md-6">
                                            <div class="card card-outline card-secondary mb-3">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title mb-0">{{ __('Hallazgo aprobado') }} #{{ $report->id }}</h3>
                                                    <span class="small text-muted">{{ optional($report->created_at)->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-2">
                                                        <strong>{{ __('Condición') }}:</strong> {{ $report->condicionInicial?->nombre ?? '-' }}
                                                    </div>
                                                    <form method="POST" action="{{ route('transfers.store') }}" class="form-inline">
                                                        @csrf
                                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                                        <div class="form-group mr-2 mb-2">
                                                            <label for="centro_r{{ $report->id }}" class="sr-only">{{ __('Centro') }}</label>
                                                            <select id="centro_r{{ $report->id }}" name="centro_id" class="form-control form-control-sm">
                                                                <option value="">{{ __('Seleccionar centro...') }}</option>
                                                                @foreach(($centers ?? []) as $c)
                                                                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-outline-primary btn-sm mb-2">
                                                            {{ __('Enviar a centro') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="text-muted">{{ __('No hay hallazgos pendientes de primer traslado.') }}</div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="tab-pane fade" id="internal" role="tabpanel" aria-labelledby="internal-tab">
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title mb-0">{{ __('Nuevo traslado entre centros') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('transfers.store') }}" role="form" enctype="multipart/form-data">
                                            @csrf
                                            @include('transfer.form')
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead">
                                            <tr>
                                                <th>No</th>
                                                <th>{{ __('Persona') }}</th>
                                                <th>{{ __('Centro') }}</th>
                                                <th>{{ __('Observaciones') }}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transfers as $transfer)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $transfer->person?->nombre ?? '-' }}</td>
                                                    <td>{{ $transfer->center?->nombre ?? $transfer->center?->id }}</td>
                                                    <td>{{ $transfer->observaciones }}</td>
                                                    <td>
                                                        <form action="{{ route('transfers.destroy', $transfer->id) }}" method="POST">
                                                            <a class="btn btn-sm btn-primary" href="{{ route('transfers.show', $transfer->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                            <a class="btn btn-sm btn-success" href="{{ route('transfers.edit', $transfer->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm js-confirm-delete"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! $transfers->withQueryString()->links() !!}
            </div>
        </div>
    </div>
    @include('partials.page-pad')
@endsection
