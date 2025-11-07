<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        @if(!empty($report?->id))
        <div class="form-group mb-2 mb20">
            <label for="aprobado" class="form-label">{{ __('Aprobado') }}</label>
            <select name="aprobado" id="aprobado" class="form-control @error('aprobado') is-invalid @enderror">
                @php($ap = old('aprobado', $report?->aprobado))
                <option value="0" {{ (string)$ap === '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ (string)$ap === '1' ? 'selected' : '' }}>Sí</option>
            </select>
            {!! $errors->first('aprobado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Dirección') }}</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $report?->direccion) }}" id="direccion" placeholder="Dirección">
            {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        @endif

        <div class="form-group mb-2 mb20">
            <label for="imagen" class="form-label">{{ __('Imagen') }}</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" accept="image/*" name="imagen" class="custom-file-input @error('imagen') is-invalid @enderror" id="imagen">
                    <label class="custom-file-label" for="imagen">{{ __('Elegir imagen') }}</label>
                </div>
            </div>
            {!! $errors->first('imagen', '<div class="invalid-feedback d-block" role="alert"><strong>:message</strong></div>') !!}
            @if(!empty($report?->imagen_url))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $report->imagen_url) }}" alt="Imagen del reporte" style="max-height: 120px;"/>
                </div>
            @endif
        </div>

        <div class="form-group mb-2 mb20">
            <label for="observaciones" class="form-label">{{ __('Observaciones') }}</label>
            <input type="text" name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" value="{{ old('observaciones', $report?->observaciones) }}" id="observaciones" placeholder="Observaciones">
            {!! $errors->first('observaciones', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="cantidad_animales" class="form-label">{{ __('Cantidad de Animales') }}</label>
            <input type="number" min="1" name="cantidad_animales" class="form-control @error('cantidad_animales') is-invalid @enderror" value="{{ old('cantidad_animales', $report?->cantidad_animales ?? 1) }}" id="cantidad_animales" placeholder="1">
            {!! $errors->first('cantidad_animales', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        @if(empty($report?->id))
        <div class="form-group mb-2 mb20">
            <label class="form-label">{{ __('Ubicación (clic en el mapa)') }}</label>
            <div id="mapid" style="height: 300px; border-radius: 4px;"></div>
            <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
            <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">
            <input type="hidden" name="direccion" id="direccion" value="{{ old('direccion') }}">
            <small class="text-muted" id="direccion_text"></small>
        </div>
        @endif

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('imagen');
    input?.addEventListener('change', function(){
        const file = this.files && this.files[0] ? this.files[0] : null;
        const fileName = file ? file.name : '{{ __('Elegir imagen') }}';
        const label = this.nextElementSibling;
        if (label) label.textContent = fileName;
        // Preview
        let preview = document.getElementById('imagen_preview');
        if (!preview) {
            const container = this.closest('.form-group');
            preview = document.createElement('img');
            preview.id = 'imagen_preview';
            preview.style.maxHeight = '120px';
            preview.style.display = 'none';
            preview.className = 'mt-2';
            container.appendChild(preview);
        }
        if (file && file.type.startsWith('image/')) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else if (preview) {
            preview.style.display = 'none';
        }
    });
});
</script>

@if(empty($report?->id))
@include('partials.leaflet')
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.initMapWithGeolocation({
        mapId: 'mapid',
        latInputId: 'latitud',
        lonInputId: 'longitud',
        dirInputId: 'direccion',
        start: { lat: -17.7833, lon: -63.1821, zoom: 13 },
        enableReverseGeocode: true,
    });
});
</script>
@endif