<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispositionRequest extends FormRequest
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
            'tipo' => 'required|string|in:traslado,adopcion,liberacion',
            'center_id' => 'nullable|integer',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180', // eliminado (se completa desde el mapa)
        ];
    }
}
