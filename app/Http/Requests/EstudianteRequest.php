<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EstudianteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->getMethod()) {
            case 'POST':
                return [
                    'nombre' => 'required|string|max:100',
                    'correo' => 'required|email|max:150',
                    'nctrl' => 'required|string|max:8',
                ];
        }
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'correo' => 'Correo',
            'nctrl' => 'Número de control',
        ];
    }

}
