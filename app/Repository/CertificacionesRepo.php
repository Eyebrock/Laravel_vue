<?php

namespace App\Repository;

use App\Models\Certificaciones;

class CertificacionesRepo
{
    private $certificaciones;

    public function __construct()
    {
        $this->certificaciones = new Certificaciones();
    }

    public function getCertificaciones(){
        return $this->certificaciones::all();
    }

    public function getCertificacionById(int $id){
        return $this->certificaciones::
            where('id', $id)->
        first();
    }


}
