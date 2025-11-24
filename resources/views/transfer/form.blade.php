<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="persona_id" class="form-label">{{ __('Persona que traslada') }}</label>
            <select name="persona_id" id="persona_id" class="form-control @error('persona_id') is-invalid @enderror">
                <option value="">Seleccione</option>
                @foreach(($people ?? []) as $p)
                    <option value="{{ $p->id }}" {{ (string)old('persona_id', $transfer?->persona_id) === (string)$p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
                @endforeach
            </select>
            {!! $errors->first('persona_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="primer_traslado" class="form-label d-block">{{ __('¿Es primer traslado?') }}</label>
            @php($isFirst = old('primer_traslado', (string)($transfer?->primer_traslado ?? '1')))
            <select name="primer_traslado" id="primer_traslado" class="form-control @error('primer_traslado') is-invalid @enderror" style="max-width: 220px;">
                <option value="1" {{ (string)$isFirst === '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ (string)$isFirst === '0' ? 'selected' : '' }}>No</option>
            </select>
            {!! $errors->first('primer_traslado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20" id="animal_wrap">
            <label for="animal_id" class="form-label">{{ __('Animal (si no es primer traslado)') }}</label>
            <select name="animal_id" id="animal_id" class="form-control @error('animal_id') is-invalid @enderror">
                <option value="">{{ __('Seleccione') }}</option>
                @foreach(($animals ?? []) as $a)
                    <option value="{{ $a->id }}" {{ (string)old('animal_id', $transfer?->animal_id) === (string)$a->id ? 'selected' : '' }}>
                        #{{ $a->id }} {{ $a->nombre ? '- ' . $a->nombre : '' }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('animal_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            <small class="text-muted d-block mt-1">{{ __('Si es “Sí” en primer traslado, no es necesario seleccionar animal.') }}</small>
        </div>
        <div class="form-group mb-2 mb20" id="current_center_wrap" style="display:none;">
            <label class="form-label">{{ __('Centro actual del animal') }}</label>
            <div id="current_center_name" class="form-control-plaintext"></div>
        </div>
        <div class="form-group mb-2 mb20" id="map_wrap">
            <label class="form-label">{{ __('Ubicación (primer traslado)') }}</label>
            <div id="transfer_map" style="height: 280px; border-radius: 4px;"></div>
            <input type="hidden" name="latitud" id="t_lat" value="{{ old('latitud', $transfer?->latitud) }}">
            <input type="hidden" name="longitud" id="t_lon" value="{{ old('longitud', $transfer?->longitud) }}">
        </div>
        <div class="form-group mb-2 mb20" id="center_wrap">
            <label for="centro_id" class="form-label">{{ __('Centro de destino') }}</label>
            <select name="centro_id" id="centro_id" class="form-control @error('centro_id') is-invalid @enderror">
                <option value="">{{ __('Seleccione') }}</option>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selFirst = document.getElementById('primer_traslado');
    const animalSel = document.getElementById('animal_id');
    const mapWrap = document.getElementById('map_wrap');
    const currentWrap = document.getElementById('current_center_wrap');
    const currentName = document.getElementById('current_center_name');
    const animalWrap = document.getElementById('animal_wrap');
    function toggleAnimal() {
        const isFirst = selFirst && String(selFirst.value) === '1';
        if (animalSel) {
            animalSel.disabled = isFirst;
        }
        if (animalWrap) animalWrap.style.display = isFirst ? 'none' : '';
        if (mapWrap) mapWrap.style.display = isFirst ? '' : 'none';
        if (currentWrap) currentWrap.style.display = isFirst ? 'none' : '';

        if (!isFirst) {
            const id = animalSel?.value;
            if (id) {
                fetch('{{ route('transfers.currentCenter', ['animal' => 'ID']) }}'.replace('ID', id))
                    .then(r => r.json())
                    .then(data => {
                        if (currentName) currentName.textContent = data.current ? ('#'+data.current.id+' '+data.current.nombre) : '{{ __('Sin centro registrado') }}';
                        const centerSel = document.getElementById('centro_id');
                        if (centerSel && data.destinations) {
                            const current = centerSel.value;
                            centerSel.innerHTML = '<option value="">{{ __('Seleccione') }}</option>';
                            data.destinations.forEach(c => {
                                const opt = document.createElement('option');
                                opt.value = c.id;
                                opt.textContent = c.nombre;
                                if (String(current) === String(c.id)) opt.selected = true;
                                centerSel.appendChild(opt);
                            });
                        }
                    })
                    .catch(() => {});
            }
        }
    }
    selFirst?.addEventListener('change', toggleAnimal);
    animalSel?.addEventListener('change', function () {
        if (selFirst && String(selFirst.value) === '0') toggleAnimal();
    });
    toggleAnimal();
});
</script>
@include('partials.leaflet')
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.initMapWithGeolocation({
        mapId: 'transfer_map',
        latInputId: 't_lat',
        lonInputId: 't_lon',
        start: { lat: -17.7833, lon: -63.1821, zoom: 13 },
        enableReverseGeocode: true
    });
});
</script>