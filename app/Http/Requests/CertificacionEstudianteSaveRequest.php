<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CertificacionEstudianteSaveRequest extends FormRequest
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
                    'id_estudiante' => 'required',
                    'id_certificacion' => 'required',
                ];
        }
    }

    public function attributes()
    {
        return [
            'id_estudiante' => 'id_estudiante',
            'id_certificacion' => 'id_certificacion',
        ];
    }

}
