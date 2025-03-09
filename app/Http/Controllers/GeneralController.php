<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificacionEstudianteRequest;
use App\Http\Requests\CertificacionEstudianteSaveRequest;
use App\Http\Requests\CertificacionRequest;
use App\Http\Requests\EstudianteRequest;
use App\Models\Certificaciones;
use App\Models\Estudiantes;
use App\Models\EstudiantesCertificaciones;
use App\Repository\CertificacionesRepo;
use App\Repository\EstudiantesCertificacionesRepo;
use App\Repository\EstudiantesRepo;
use App\Repository\ResultadosRepo;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class GeneralController extends Controller
{

    private $EstudianteRepo;
    private $CertificacionesRepo;
    private $EstudiantesCertificacionesRepo;
    private $ResultadsRepo;


    public function __construct()
    {

        $this->EstudianteRepo = new EstudiantesRepo();
        $this->CertificacionesRepo = new CertificacionesRepo();
        $this->EstudiantesCertificacionesRepo = new EstudiantesCertificacionesRepo();
        $this->ResultadsRepo = new ResultadosRepo();
    }


    ////// METODOS PARA ESTUDIANTES/////
    public function Estudiantesindex()
    {
        $estudiantes = $this->EstudianteRepo->getEstudiantes();
        if (!isset($estudiantes)) {
            $estudiantes = [];
        }
        return Inertia::render('Estudiantes/Estudiantes', compact('estudiantes'));
    }

    public function EstudiantesStore(EstudianteRequest $request)
    {
        try {

            $estudiante = new Estudiantes();

            $estudiante->nombre = $request->nombre;
            $estudiante->correo = $request->correo;
            $estudiante->nctrl = $request->nctrl;
            $estudiante->saveOrFail();

            return response()->json(['message' => 'Éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function EstudiantesUpdate(EstudianteRequest $request, $id)
    {
        try {

            $estudiante = $this->EstudianteRepo->getEstudianteById($id);

            $estudiante->nombre = $request->nombre;
            if ($estudiante->correo != $request->correo) {
                $estudiante->correo = $request->correo;
            }
            if ($estudiante->nctrl != $request->nctrl) {
                $estudiante->nctrl = $request->nctrl;
            }
            $estudiante->saveOrFail();

            return response()->json(['message' => 'Éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function DeleteEstudiante($id)
    {
        try {
            $estudiante = $this->EstudianteRepo->getEstudianteById($id);
            $estudiante->delete();
            return response()->json(['message' => 'Éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

/// METODOS PARA CERTIFICACIONES/////


    public function Cursosindex()
    {
        $certificaciones = $this->CertificacionesRepo->getCertificaciones();
        if (!isset($certificaciones)) {
            $certificaciones = [];
        }
        return Inertia::render('Certificaciones/Certificaciones', compact('certificaciones'));
    }

    public function CursosStore(CertificacionRequest $request)
    {
        try {

            $certificacion = new Certificaciones();

            $certificacion->nombre = $request->nombre;
            $certificacion->puntaje_total = $request->puntaje_total;
            $certificacion->saveOrFail();

            return response()->json(['message' => 'Éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function CursosUpdate(CertificacionRequest $request, $id)
    {
        try {

            $certificacion = $this->CertificacionesRepo->getCertificacionById($id);

            $certificacion->nombre = $request->nombre;
            $certificacion->puntaje_total = $request->puntaje_total;
            $certificacion->saveOrFail();

            return response()->json(['message' => 'Éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function DeleteCurso($id)
    {
        try {
            $certificacion = $this->CertificacionesRepo->getCertificacionById($id);
            $certificacion->delete();
            return response()->json(['message' => 'Éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function Certificacionesindex($id)
    {
        $estudiante = $this->EstudianteRepo->getEstudianteById($id);
        $certificaciones_estudiante = $this->EstudiantesCertificacionesRepo->getEstudianteCertificacionesbyId($id);
        $certificaciones = $this->CertificacionesRepo->getCertificaciones();

        if (!isset($certificaciones_estudiante)) {
            $certificaciones_estudiante = [];
        }

        return Inertia::render('Estudiantes/Estudiantes_Certificaciones', compact('certificaciones_estudiante', 'estudiante', 'certificaciones'));

    }

    public function CertificacionesStore(CertificacionEstudianteSaveRequest $request)
    {
        try {
            $estudiante = $this->EstudianteRepo->getEstudianteById($request->id_estudiante);
            $certificacion = $this->CertificacionesRepo->getCertificacionById($request->id_certificacion);
            $validation = $this->EstudiantesCertificacionesRepo->getEstudianteCertificacionesbyIds($request->id_estudiante, $request->id_certificacion);

            if(isset($validation)){
                return response()->json(['message' => 'Esta Certificacion ya esta asignada'], 400);
            }

            if (isset($estudiante) && isset($certificacion)) {
                $id_estudiante = $estudiante->id;

                $estudiante_certificacion = new EstudiantesCertificaciones();

                $estudiante_certificacion->id_estudiante = $id_estudiante;
                $estudiante_certificacion->id_certificacion = $certificacion->id;
                $estudiante_certificacion->saveOrFail();

                return response()->json(['message' => 'Éxito'], 200);
            } else {
                return response()->json(['message' => 'Error'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function CertificacionesUpdate($id_estudiante_cert, $id)
    {
        $estudiante_certificacion = $this->EstudiantesCertificacionesRepo->getEstudianteCertificacionById($id_estudiante_cert);
        $estudiante = $this->EstudianteRepo->getEstudianteById($id);

        return Inertia::render('Estudiantes/Estudiante_Certificacion_form', compact( 'estudiante', 'estudiante_certificacion'));
    }

    public function CertificacionesUpdateStore(CertificacionEstudianteRequest $request)
    {
        $estado = (int) $request->estado_cert;
        try {
            $estudiante_certificacion = $this->EstudiantesCertificacionesRepo->getEstudianteCertificacionById($request->id_estudiante_cert);

            if (isset($estudiante_certificacion)) {
                $estudiante_certificacion->puntaje = $request->puntaje;
                $estudiante_certificacion->estado_cert = $estado;
                $estudiante_certificacion->fecha_eval = date('Y-m-d');
                $estudiante_certificacion->saveOrFail();

                return response()->json(['message' => 'Éxito'], 200);
            } else {
                return response()->json(['message' => 'Error'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }


}
