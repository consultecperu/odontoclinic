<?php
namespace App\Helpers;
// Creacion de mis helpers personalizados
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Globales 
{
    // --- funciones de fechas ---- //
    public static function FormatFecDMY($valor) 
    {
        // recibe el formado YYYY-MM-DD
        $fecha = explode("-", $valor);          
        $formato = empty($valor) ? null : Carbon::create($fecha[2],$fecha[1],$fecha[0]);
        return $formato;
        // retorna formato DD-MM-YYYY
    }

    public static function FormatFecYMD($valor) 
    {
        // recibe el formato DD-MM-YYYY
        $fecha = explode("-", $valor);          
        $formato = empty($valor) ? null : Carbon::create($fecha[2],$fecha[1],$fecha[0]);
        return $formato;
        // retorna formato YYYY-MM-DD
    }    

    public static function FormatFecYMD_hms($valor) 
    {
        // recibe el formato DD-MM-YYYY hh:mm:ss
        $ano = substr($valor,6,4);
        $mes = substr($valor,3,2);
        $dia = substr($valor,0,2);
        $hora = substr($valor,11,2);
        $minuto = substr($valor,14,2);
        $segundo = substr($valor,17,2);     
        $formato = empty($valor) ? null : Carbon::create($ano, $mes, $dia, $hora, $minuto, $segundo);
        return $formato;
        // retorna formato YYYY-MM-DD hh:mm:ss
    }      

    public static function DifFechas($valor1,$valor2)
    {
        $dias = $valor1->diffInDays($valor2, false);    // diferencia en dias
        return $dias;
    }

    public static function DifMinutos($fecha,$hora)    // diferencia de minutos con respecto a la hora actual
    {
        // formato hora YYYY-MM-DD ------ formato hora HH:mm:ss
        $start = new Carbon($fecha.' '.$hora);
        $now = Carbon::now();
        $minutos = $start->diffInMinutes($now);
        return $minutos;
    }

    public static function Edad($value)
    {
        $fecha = explode("-", $value);          
        $edad = Carbon::createFromDate($fecha[2],$fecha[0],$fecha[1])->age;  
        return $edad;       
    }

    public static function HC_Correlativo($sede_id)
    {
        DB::table('historiaclinicas')->where('sede_id',null)->increment('correlativo_general');        
        DB::table('historiaclinicas')->where('sede_id',$sede_id)->increment('correlativo_sede');
        $numcor = DB::table('historiaclinicas')->where('sede_id',$sede_id)->select('correlativo_sede')->first();
        return $numcor->correlativo_sede;
    }

    public static function comprobantesedes_correlativo($sede_id,$tipdoc_id,$pto,$serie)
    {
        DB::table('comprobantesedes')->where(['sede_id' => $sede_id, 'tipodocumento_id' => $tipdoc_id, 'ptoventa' => $pto , 'serie' => $serie])->increment('correlativo');        
        $numcor = DB::table('comprobantesedes')->where(['sede_id' => $sede_id, 'tipodocumento_id' => $tipdoc_id, 'ptoventa' => $pto , 'serie' => $serie])->select('correlativo')->first();
        return $numcor->correlativo;
    }    
    // User::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get(); usuarios creados el dia de hoy
    // Ticket::whereTime('end_date', '>=', '12:00:00')->get();   Todos los tickets cerrados después de las 12:00 horas

    // PARA PAGOS A DOCTORES
    public static function comision_tarjeta($monto, $comision){
        if($monto != 0){
            $_tmp = $comision / 100;
            $_mont = $monto * $_tmp;
            return number_format($_mont, 2);
        }else{
            return 0.00;
        }
    } 
    
    public static function comision_sunat($monto, $comision, $contrato){
        if($contrato == 2){
            $_tmp = $comision / 100;
            $_mont = ($monto / 1.18) * $_tmp;
            $newMonto = $monto - $_mont;
            return number_format($_mont, 2);
        
        }else{
            return 0.00;
        }
    }   
    
    public static function pago_doctor($bruto, $comision, $descuento, $materiales, $devoluvionMat = FALSE){
        $_descuento = 0.00;
        if(is_array($descuento)){
            foreach ($descuento as $value) {
                $_descuento += $value;
            }
        }
        $_sub = (float)$bruto - (float)$_descuento;        
        $_sub = (float)$_sub * ($comision / 100);
        //var_dump($_sub);
        if($devoluvionMat){
          $_sub = (float)$_sub + (float)$materiales;  
        }
        //return number_format($_sub, 2);
        return number_format($_sub, 2, '.', '');
    }   
    
    public static function quitar_servicios_liquidacion($idservicio){
        $servicios = [14, 15, 16, 17, 18, 19, 422, 423, 424];  
        $status = true;  
        for ($i=0; $i < count($servicios); $i++) { 
          if($idservicio == $servicios[$i]){
            $status = false;
            break;
          }
        }        
        return $status;  
    } 
    
    public static function type_cash($efectivo, $tarjeta, $idtarjeta){
        if($efectivo != 0 & $tarjeta == 0){
            return 'EFEC';
        }elseif($efectivo != 0 & $tarjeta != 0){
            return 'MIXT';
        }elseif($efectivo == 0 & $tarjeta != 0){
            if($idtarjeta == '2'){
                return 'MasterC';
            }
            if($idtarjeta == '3'){
                return 'VISA';
            }
            if($idtarjeta == '4'){
                return 'P.VIDA';
            }
            if($idtarjeta == '6'){
                return 'AMEX';
            }
            if($idtarjeta == '5'){
                return 'AB.BN';
            }
            if($idtarjeta == '7'){
                return 'DINNE';
            }
            if($idtarjeta == '8'){
                return 'CMR';
            }
        }
    } 
    
    public static function tipo_pago($efectivo, $tarjeta, $idtarjeta){
        if($efectivo != 0 & $tarjeta == 0){
            return 1;
        }elseif($efectivo != 0 & $tarjeta != 0){
            return 3;
        }elseif($efectivo == 0 & $tarjeta != 0){
            return 2;
        }
    }     
}