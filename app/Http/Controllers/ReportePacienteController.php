<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;
use Validator;
use Image;
use Carbon\Carbon;
use App\Paciente;
use PDF;
use Globales;   // helpers

class ReportePacienteController extends Controller
{
    //
    function imprimir_ficha($id)
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('d-m-Y');
        $paciente = Paciente::with('tipodocumento','pacienteplanes','pacienteplanes.plan','pacienteplanes.empresapaciente','pacienteplanes.poliza','empleado','ubigeo','motivocaptacion')->where(['activo'=> true,'id' => $id])->first();
        $pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadView('reportes.pacientes.ficha',compact('paciente','fecha'));
        //return $pdf->download('prueba_paciente.pdf'); // para descargar
        return $pdf->stream('ficha.pdf');     // para verlo en pantalla
    }
    
}
