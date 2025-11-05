<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                @php
                    $options = ['traslado' => 'Traslado', 'adopcion' => 'Adopción', 'liberacion' => 'Liberación'];
                    $current = old('tipo', $disposition?->tipo);
                @endphp
                @foreach($options as $value => $label)
                    <option value="{{ $value }}" {{ $current === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label class="form-label">{{ __('Ubicación') }}</label>
            <div id="disposition-map" style="height: 320px;"></div>
            <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $disposition?->latitud) }}">
            <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $disposition?->longitud) }}">
            <small id="coordsHelp" class="text-muted">
                {{ __('Haz click en el mapa para seleccionar la ubicación (lat/lng).') }}
            </small>
            {!! $errors->first('latitud', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
            {!! $errors->first('longitud', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="center_id" class="form-label">{{ __('Center Id') }}</label>
            <input type="text" name="center_id" class="form-control @error('center_id') is-invalid @enderror" value="{{ old('center_id', $disposition?->center_id) }}" id="center_id" placeholder="Center Id">
            {!! $errors->first('center_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    const coordsHelp = document.getElementById('coordsHelp');

    const initialLat = parseFloat(latInput.value || '');
    const initialLng = parseFloat(lngInput.value || '');
    const hasInitial = !isNaN(initialLat) && !isNaN(initialLng);

    const map = L.map('disposition-map');
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    map.setView(hasInitial ? [initialLat, initialLng] : [0, 0], hasInitial ? 14 : 2);

    let marker = null;
    if (hasInitial) {
        marker = L.marker([initialLat, initialLng]).addTo(map);
        coordsHelp.textContent = `Lat: ${initialLat.toFixed(6)}, Lng: ${initialLng.toFixed(6)}`;
    }

    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
        coordsHelp.textContent = `Lat: ${latInput.value}, Lng: ${lngInput.value}`;
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
    });
});
</script>