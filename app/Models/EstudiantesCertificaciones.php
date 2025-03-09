<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudiantesCertificaciones extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'estudiantes_cert';
    protected $primaryKey = 'id_estudiante_cert';
    public $timestamps = false;

    public function estudiante()
    {
        return $this->belongsTo(Estudiantes::class, 'id_estudiante', 'id');
    }

    public function certificacion()
    {
        return $this->belongsTo(Certificaciones::class, 'id_certificacion', 'id');
    }

    public function resultado()
    {
        return $this->belongsTo(Resultados::class, 'id_resultado', 'id_resultado');
    }

}
