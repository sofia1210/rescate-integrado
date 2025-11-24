<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'persona_id' => 'required|exists:people,id',
			'centro_id' => 'required|exists:centers,id',
			'observaciones' => 'nullable|string',
            'primer_traslado' => 'required|boolean',
            'animal_id' => 'nullable|exists:animals,id|required_if:primer_traslado,0',
            'latitud' => 'nullable|numeric|required_if:primer_traslado,1',
            'longitud' => 'nullable|numeric|required_if:primer_traslado,1',
        ];
    }
}
