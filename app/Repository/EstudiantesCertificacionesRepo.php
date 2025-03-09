<?php

namespace App\Repository;

use App\models\Estudiantes;
use App\Models\EstudiantesCertificaciones;

class EstudiantesCertificacionesRepo
{
    private $estudiantes_certificaciones;

    public function __construct()
    {
        $this->estudiantes_certificaciones = new EstudiantesCertificaciones();
    }

    public function getEstudiantesCertificaciones(){
        return $this->estudiantes_certificaciones::all();
    }

    public function getEstudianteCertificacionesbyId(int $id_estudiante){
        return $this->estudiantes_certificaciones::
            where('id_estudiante', $id_estudiante)
            ->with(['estudiante', 'certificacion'])->
        get();
    }

    public function getEstudianteCertificacionbyId(int $id_estudiante_cert){
        return $this->estudiantes_certificaciones::
        where('id_estudiante_cert', $id_estudiante_cert)
            ->with(['estudiante', 'certificacion'])->
            first();
    }

    public function getEstudianteCertificacionesbyIds(int $id_estudiante, int $id_certificacion){
        return $this->estudiantes_certificaciones::
        where('id_estudiante', $id_estudiante)
            ->where('id_certificacion', $id_certificacion)
            ->with(['estudiante', 'certificacion'])->
            first();
    }


}
