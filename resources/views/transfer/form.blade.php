<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="rescatista_id" class="form-label">{{ __('Rescatista') }}</label>
            <select name="rescatista_id" id="rescatista_id" class="form-control @error('rescatista_id') is-invalid @enderror">
                <option value="">Seleccione</option>
                @foreach(($rescuers ?? []) as $r)
                    <option value="{{ $r->id }}" {{ (string)old('rescatista_id', $transfer?->rescatista_id) === (string)$r->id ? 'selected' : '' }}>{{ $r->person?->nombre ?? ('#'.$r->id) }}</option>
                @endforeach
            </select>
            {!! $errors->first('rescatista_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="centro_id" class="form-label">{{ __('Centro') }}</label>
            <select name="centro_id" id="centro_id" class="form-control @error('centro_id') is-invalid @enderror">
                <option value="">Seleccione</option>
                @foreach(($centers ?? []) as $c)
                    <option value="{{ $c->id }}" {{ (string)old('centro_id', $transfer?->centro_id) === (string)$c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                @endforeach
            </select>
            {!! $errors->first('centro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="observaciones" class="form-label">{{ __('Observaciones') }}</label>
            <input type="text" name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" value="{{ old('observaciones', $transfer?->observaciones) }}" id="observaciones" placeholder="Observaciones">
            {!! $errors->first('observaciones', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>