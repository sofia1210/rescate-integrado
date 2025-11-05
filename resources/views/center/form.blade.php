<div class="row padding-1 p-1">
    <div class="col-md-12">
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $center?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="telefono" class="form-label">{{ __('Telefono') }}</label>
            <input type="number" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $center?->telefono) }}" id="telefono" placeholder="Telefono">
            {!! $errors->first('telefono', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label class="form-label">{{ __('Ubicación') }}</label>
            <div id="center-map" style="height: 320px;"></div>
            <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $center?->latitud) }}">
            <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $center?->longitud) }}">
            <small id="coordsHelp" class="text-muted">
                {{ __('Haz click en el mapa para seleccionar la ubicación (lat/lng).') }}
            </small>
            {!! $errors->first('latitud', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
            {!! $errors->first('longitud', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="capacidad_maxima" class="form-label">{{ __('Capacidad Maxima') }}</label>
            <input type="number" name="capacidad_maxima" class="form-control @error('capacidad_maxima') is-invalid @enderror" value="{{ old('capacidad_maxima', $center?->capacidad_maxima) }}" id="capacidad_maxima" placeholder="Capacidad Máxima">
            {!! $errors->first('capacidad_maxima', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_creacion" class="form-label">{{ __('Fecha Creacion') }}</label>
            <input type="date" name="fecha_creacion" class="form-control @error('fecha_creacion') is-invalid @enderror" value="{{ old('fecha_creacion', optional($center?->fecha_creacion)->format('Y-m-d')) }}" id="fecha_creacion">
            {!! $errors->first('fecha_creacion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Direccion') }}</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $center?->direccion) }}" id="direccion" placeholder="Direccion">
            {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

{{-- Leaflet CSS/JS --}}
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

    const map = L.map('center-map');
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