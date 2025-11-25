@extends('adminlte::page')

@section('template_title')
{{ __('Create') }} {{ __('Report') }}
@endsection

@section('content')
    <section class="content container-fluid pt-4" style="background-color:#f4f6f9;">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} {{ __('Report') }}</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('reports.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('report.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
