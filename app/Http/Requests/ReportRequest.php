<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
			'reporte_id' => 'required',
			'reportador_id' => 'required',
			'cantidad_animales' => 'required',
			'longitud' => 'required',
			'latitud' => 'required',
			'direccion' => 'required|string',
			'centro_id' => 'required',
			'aprobado_id' => 'string',
			'detalle_aprobado' => 'string',
        ];
    }
}
