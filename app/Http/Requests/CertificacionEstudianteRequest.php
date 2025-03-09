<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CertificacionEstudianteRequest extends FormRequest
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
                    'id_estudiante_cert' => 'required',
                    'id_estudiante' => 'required',
                    'id_certificacion' => 'required',
                    'puntaje' => 'numeric',
                    'estado_cert' => 'required',
                ];
        }
    }

    public function attributes()
    {
        return [
            'id_estudiante_cert' => 'id_estudiante_cert',
            'id_estudiante' => 'id_estudiante',
            'id_certificacion' => 'id_certificacion',
            'puntaje' => 'puntaje',
            'estado_cert' => 'estado_cert',
        ];
    }

}
