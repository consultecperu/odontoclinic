<?php
namespace App\Helpers;
// Creacion de mis helpers personalizados
use Carbon\Carbon;

class Globales 
{
    // --- funciones de fechas ---- //
    public static function FormatFecDMY($valor) {
        $fecha = explode("-", $valor);          
        $formato = empty($valor) ? null : Carbon::create($fecha[2],$fecha[1],$fecha[0]);
        return $formato;
    }

    public static function DifFechas($valor1,$valor2){
        $dias = $valor1->diffInDays($valor2, false);    // diferencia en dias
        return $dias;
    }

    public static function Edad($value){
        $fecha = explode("-", $value);          
        $edad = Carbon::createFromDate($fecha[2],$fecha[0],$fecha[1])->age;  
        return $edad;       
    }

    // User::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get(); usuarios creados el dia de hoy
    // Ticket::whereTime('end_date', '>=', '12:00:00')->get();   Todos los tickets cerrados después de las 12:00 horas
}

