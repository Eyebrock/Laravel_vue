<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CertificacionRequest extends FormRequest
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
                    'puntaje_total' => 'required|numeric',
                ];
        }
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'puntaje_total' => 'Puntaje total',
        ];
    }

}
