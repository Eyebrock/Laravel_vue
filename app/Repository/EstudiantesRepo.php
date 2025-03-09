<?php

namespace App\Repository;

use App\models\Estudiantes;

class EstudiantesRepo
{
    private $estudiantes;

    public function __construct()
    {
        $this->estudiantes = new Estudiantes();
    }

    public function getEstudiantes(){
        return $this->estudiantes::all();
    }

    public function getEstudianteById(int $id){
        return $this->estudiantes::
            where('id', $id)->
        first();
    }


}
