<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                @php
                    $options = ['evaluacion' => 'Evaluación', 'tratamiento' => 'Tratamiento', 'cuidado' => 'Cuidado'];
                    $current = old('tipo', $healthRecord?->tipo);
                @endphp
                @foreach($options as $value => $label)
                    <option value="{{ $value }}" {{ $current === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="descripcion" class="form-label">{{ __('Descripcion') }}</label>
            <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $healthRecord?->descripcion) }}" id="descripcion" placeholder="Descripcion">
            {!! $errors->first('descripcion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tratamiento" class="form-label">{{ __('Tratamiento') }}</label>
            <input type="text" name="tratamiento" class="form-control @error('tratamiento') is-invalid @enderror" value="{{ old('tratamiento', $healthRecord?->tratamiento) }}" id="tratamiento" placeholder="Tratamiento">
            {!! $errors->first('tratamiento', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_revision" class="form-label">{{ __('Fecha Revision') }}</label>
            <input type="date" name="fecha_revision" class="form-control @error('fecha_revision') is-invalid @enderror" value="{{ old('fecha_revision', optional($healthRecord?->fecha_revision)->format('Y-m-d')) }}" id="fecha_revision">
            {!! $errors->first('fecha_revision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>