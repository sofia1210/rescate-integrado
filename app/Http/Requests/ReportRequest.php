<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reporte_id' => 'sometimes|nullable',
            'reportador_id' => 'required|integer',
            'cantidad_animales' => 'required|integer',
            // longitud: sin validación (se rellena desde el mapa)
            // 'longitud' => 'numeric|between:-180,180',
            'latitud' => 'required|numeric|between:-90,90',
            'direccion' => 'required|string',
            'centro_id' => 'required|integer',
            'aprobado_id' => 'nullable|string',
            'detalle_aprobado' => 'nullable|string',
            'fecha_creacion' => 'nullable|date',
            'fecha_actualizacion' => 'nullable|date',
        ];
    }

    protected function prepareForValidation(): void
    {
        $lat = $this->parseCoordinate($this->input('latitud'), true);
        $lon = $this->parseCoordinate($this->input('longitud'), false);

        $this->merge([
            'latitud' => $lat,
            'longitud' => $lon,
        ]);
    }

    protected function parseCoordinate($value, bool $isLatitude)
    {
        if ($value === null) return null;
        $s = trim((string) $value);
        if ($s === '') return null;
        $s = str_replace(',', '.', $s);
        if (is_numeric($s)) return (float) $s;

        if (preg_match('/^\s*([+-]?\d+)\s+(\d+)\s+(\d+)\s*([NnSsEeWw])?\s*$/', $s, $m)
            || preg_match('/^\s*([+-]?\d+)[^\d]+(\d+)[^\d]+(\d+)\s*([NnSsEeWw])?\s*$/', $s, $m)) {
            $deg = (int) $m[1]; $min = (int) $m[2]; $sec = (int) $m[3]; $hem = $m[4] ?? null;
            $val = abs($deg) + ($min / 60) + ($sec / 3600);
            $sign = ($deg < 0) ? -1 : 1;
            if ($hem) {
                $hem = strtoupper($hem);
                if ($hem === 'S' || $hem === 'W') $sign = -1;
                else $sign = 1;
            }
            return $sign * $val;
        }
        return null;
    }
}
