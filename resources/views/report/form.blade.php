<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="reporte_id" class="form-label">{{ __('Reporte Id') }}</label>
            <input type="text" name="reporte_id" class="form-control @error('reporte_id') is-invalid @enderror" value="{{ old('reporte_id', $report?->reporte_id) }}" id="reporte_id" placeholder="Reporte Id">
            {!! $errors->first('reporte_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="reportador_id" class="form-label">{{ __('Reportador') }}</label>
            <input type="number" name="reportador_id" class="form-control @error('reportador_id') is-invalid @enderror" id="reportador_id" value="{{ old('reportador_id', $report?->reportador_id) }}" placeholder="Reportador ID">
            {!! $errors->first('reportador_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="cantidad_animales" class="form-label">{{ __('Cantidad Animales') }}</label>
            <input type="number" name="cantidad_animales" class="form-control @error('cantidad_animales') is-invalid @enderror" id="cantidad_animales" value="{{ old('cantidad_animales', $report?->cantidad_animales) }}" placeholder="Cantidad Animales">
            {!! $errors->first('cantidad_animales', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="longitud" class="form-label">{{ __('Longitud') }}</label>
            <input type="text" name="longitud" class="form-control @error('longitud') is-invalid @enderror" id="longitud" value="{{ old('longitud', $report?->longitud) }}" placeholder="Longitud">
            {!! $errors->first('longitud', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="latitud" class="form-label">{{ __('Latitud') }}</label>
            <input type="text" name="latitud" class="form-control @error('latitud') is-invalid @enderror" id="latitud" value="{{ old('latitud', $report?->latitud) }}" placeholder="Latitud">
            {!! $errors->first('latitud', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Direccion') }}</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" id="direccion" value="{{ old('direccion', $report?->direccion) }}" placeholder="Direccion">
            {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="centro_id" class="form-label">{{ __('Centro') }}</label>
            <input type="number" name="centro_id" class="form-control @error('centro_id') is-invalid @enderror" id="centro_id" value="{{ old('centro_id', $report?->centro_id) }}" placeholder="Centro ID">
            {!! $errors->first('centro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="aprobado_id" class="form-label">{{ __('Aprobado ID') }}</label>
            <input type="text" name="aprobado_id" class="form-control @error('aprobado_id') is-invalid @enderror" id="aprobado_id" value="{{ old('aprobado_id', $report?->aprobado_id) }}" placeholder="Aprobado ID">
            {!! $errors->first('aprobado_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="detalle_aprobado" class="form-label">{{ __('Detalle Aprobado') }}</label>
            <input type="text" name="detalle_aprobado" class="form-control @error('detalle_aprobado') is-invalid @enderror" id="detalle_aprobado" value="{{ old('detalle_aprobado', $report?->detalle_aprobado) }}" placeholder="Detalle Aprobado">
            {!! $errors->first('detalle_aprobado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="fecha_creacion" class="form-label">{{ __('Fecha Creacion') }}</label>
            <input type="date" name="fecha_creacion" class="form-control @error('fecha_creacion') is-invalid @enderror" id="fecha_creacion" value="{{ old('fecha_creacion', $report?->fecha_creacion?->format('Y-m-d')) }}">
            {!! $errors->first('fecha_creacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="fecha_actualizacion" class="form-label">{{ __('Fecha Actualizacion') }}</label>
            <input type="date" name="fecha_actualizacion" class="form-control @error('fecha_actualizacion') is-invalid @enderror" id="fecha_actualizacion" value="{{ old('fecha_actualizacion', $report?->fecha_actualizacion?->format('Y-m-d')) }}">
            {!! $errors->first('fecha_actualizacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>