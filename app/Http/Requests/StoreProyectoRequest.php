<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProyectoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by Policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo'      => ['required', 'string', 'max:255'],
            'stack'       => ['required', 'string', 'max:255'],
            'estado'      => ['required', 'string', Rule::in(self::estadosPermitidos())],
            'resumen'     => ['required', 'string', 'max:2000'],
            'etiquetas'   => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'titulo'    => 'título',
            'resumen'   => 'resumen del proyecto',
            'etiquetas' => 'etiquetas',
        ];
    }

    /**
     * Allowed project states.
     *
     * @return list<string>
     */
    public static function estadosPermitidos(): array
    {
        return ['En progreso', 'Completado', 'Pausado', 'Planeado'];
    }
}
