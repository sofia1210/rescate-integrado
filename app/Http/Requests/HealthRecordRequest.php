<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo' => 'required|string|in:evaluacion,tratamiento,cuidado',
            'descripcion' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'fecha_revision' => 'nullable|date',
        ];
    }

    protected function prepareForValidation(): void
    {
        $fecha = $this->input('fecha_revision');
        if (is_string($fecha) && preg_match('/^\d{1,2}\/\d{1,2}\/\d{2,4}$/', $fecha)) {
            [$d, $m, $y] = explode('/', $fecha);
            if (strlen($y) === 2) {
                $y = (int)$y < 70 ? '20' . $y : '19' . $y;
            }
            $this->merge([
                'fecha_revision' => sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d),
            ]);
        }
    }
}
