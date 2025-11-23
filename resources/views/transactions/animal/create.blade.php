@extends('adminlte::page')

@section('template_title')
    {{ __('Registrar Animal (Transaccional)') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Registrar Animal + Hoja (Transacción única)') }}</span>
                    </div>
                    <div class="card-body bg-white">
                        <div class="callout callout-info">
                            <h5 class="mb-1"><i class="fas fa-link"></i> {{ __('Transacción combinada') }}</h5>
                            <p class="mb-0">{{ __('Completa los datos y guarda para crear el Animal y su Hoja en una sola operación.') }}</p>
                        </div>
                        <form method="POST" action="{{ route('animal-transactions.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-3">{{ __('Datos del Animal') }}</h5>
                            @include('animal.form', [
                                'animal' => $animal ?? null,
                                'reports' => $reports ?? [],
                                'showSubmit' => false
                            ])

                            <hr class="my-4"/>

                            <h5 class="mb-3">{{ __('Hoja del Animal') }}</h5>
                            @include('animal-file.form', [
                                'animalFile' => $animalFile ?? null,
                                'animalTypes' => $animalTypes ?? [],
                                'species' => $species ?? [],
                                'animalStatuses' => $animalStatuses ?? [],
                                'showAnimalSelect' => false,
                                'showSubmit' => false
                            ])

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar transacción') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


