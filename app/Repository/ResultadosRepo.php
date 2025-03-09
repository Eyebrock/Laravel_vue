<?php

namespace App\Repository;

use App\models\Resultados;

class ResultadosRepo
{
    private $resultados;

    public function __construct()
    {
        $this->resultados = new Resultados();
    }


    public function getResultadosById(int $id_resultado){
        return $this->resultados::
            where('id_resultado', $id_resultado)->
        first();
    }


}
