<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DentaCloud | Ficha Paciente </title>
    <style>
        body 
        {
            font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; 
            margin: 10px;       
        }
        table 
        {
            border-collapse: collapse;
            width: 100%;
        }

        @page 
        {
            margin: 0px;
            margin-bottom: 0.1em;
        }
     

    </style>    
</head>
<body>
    <table border="1" style="text-align: center;font-size: 12px;">
            <tr>
                <td width="30%" style="text-align:center;">
                    <br><img src="{{ public_path() . '/img/logo/logo-ficha.png'}}"  width="200" height="60"/>
                </td>
                <td valign="middle" width="45%" style="text-align: center;font-size: 28px;font-weight: bold;">Ficha de Datos</td>
                <td width="25%">
                    <table width="100%" padding="0">
                        <tr>
                            <td colspan="2">Versión&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha <br>&nbsp;&nbsp;&nbsp;02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;27/02/06</td>
                        </tr>
                        <tr style="border-top: 1px solid #000">
                            <td style="border-top: 1px solid #000;border-right: 1px solid #000">Rev:<br>RED</td>
                            <td style="border-top: 1px solid #000;">Aprob:<br>GG</td>
                        </tr>
                    </table>
                </td>
            </tr>
            
    </table>
    <br><br>

    <table>
        <tr>
            <th width="40%" style=""></th>
            <th width="20%" style="text-align: center;"><span style="font-size: 18px">{{ $paciente['historiaclinica'] }}</span><br><span style="font-size: 12px">N° HIST. CLINICA</span></th>
        </tr>
            
    </table>


    <table cellpadding="2">
        <tr style="font-size: 14px">
            <th width="40%" style="border-bottom: 1px solid #000;">Fecha Creación: <strong style="font-size: 16px;letter-spacing: 2px;">{{ $fecha }}</strong></th>
            <th width="10%" style="border-bottom: 1px solid #000"></th>
            <th width="50%" style="border-bottom: 1px solid #000;text-align: right;">DR. TTE.: <strong><?= $paciente['doctor'];?></strong></th>
        </tr>
            
    </table>
    <br><br>
    <table cellpadding="2" border="0">
        <tr style="font-size: 12px">
            <td width="19%" style="text-align: right;">Nombres y Apellidos</td>
            <td width="56%"><strong style="text-transform: uppercase;">{{ $paciente['nombre_completo']}}</strong></td>
            <td width="25%" style="text-align: right;">{{ $paciente['numero_documento']}}</td>
        </tr>
        <tr style="font-size: 12px">
            <td width="19%" style="text-align: right;">Edad</td>
            
            <td width="30%" style="text-align: left;">Fecha Nacimiento {{ $paciente['fecha_nacimiento']}}</td>
        </tr>


        <tr style="font-size: 12px">
            <td width="70%" style="text-align: left;">Dentista que le atendieron anteriormente y tratamientos realizados </td>
            <td width="19%"></td>
        </tr>
        
    </table>

    <br><br>

    <table cellpadding="2">
        <tr>
            <td width="80%" style="font-size: 14px"><u style="text-transform: uppercase;font-weight: bold;font-style: italic;">para casos de emergencia dar los siguientes datos</u></td>
            <td width="20%" style="font-size: 13px;"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="80%">Médico de Confianza</td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="80%">Servicio de Ambulancia</td>
            <td width="20%"></td>
        </tr>

        <tr style="font-size: 12px">
            <td width="75%">En caso de Emergencia Contactar a</td>
            <td width="25%">Telef.</td>
        </tr>
        
    </table>
    <br>
    <h2 style="text-align: center"><u>Anamnesis</u></h2>
    <table cellpadding="2" cellspacing="1">
        <tr style="">
            <td width="80%" style="font-size: 14px"><u style="text-transform: uppercase;font-weight: bold;font-style: italic;">antecedentes médicos</u></td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="80%">Alergico a:</td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="80%">Esta tomando algún tipo de medicamento</td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="75%">Nombre de su Médico</td>
            <td width="25%">Telef.</td>
        </tr>
        <tr style="font-size: 12px">
            <td width="24%">Ha Padecido Hepatitis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
            <td width="5%" style="text-align: right;">NO</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
            <td width="6%" style="text-align: right;">Tipo</td>
        </tr>
        <tr style="font-size: 12px">
            <td width="24%">Sufre de Diabetes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
            <td width="5%" style="text-align: right;">NO</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
            <td width="17%" style="text-align: right;">Está compensado</td>
        </tr>
        <tr style="font-size: 12px">
            <td width="32%">Sufre de presión alta o del corazón&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
            <td width="5%" style="text-align: right;">NO</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="100%">Sufre de alguna enfermedad que ponga en riesgo su vida o sea de vital importancia para nuestro conocimiento</td>
            
        </tr>
        
    </table>
    <br><br>
    <table cellpadding="2">
        <tr>
            <td width="80%" style="font-size: 14px"><u style="text-transform: uppercase;font-weight: bold;font-style: italic;">antecedentes odontologicos</u></td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="80%">Frecuencia con que visita al dentista</td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="80%">Experiencia dental traumatica, describa</td>
            <td width="20%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="75%">Le han extraido muelas</td>
            <td width="25%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="75%">Presento alguna complicación a la anestesia</td>
            <td width="25%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="25%">Le sangran las encias</td>
            <td width="40%">Fecha de la última profilaxia</td>
            <td width="25%">Fecha Ultima Atención</td>
        </tr>
        <tr style="font-size: 12px">
            <td width="75%">Siente chasquidos o ruidos al masticar o abrir la boca</td>
            <td width="25%"></td>
        </tr>
        <tr style="font-size: 12px">
            <td width="35%">Esta satisfecho con su estética dental&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
            <td width="5%" style="text-align: right;">NO</td>
            <td width="3%"><table border="1"><tr><td></td></tr></table></td>
        </tr>
    </table>
    <br><br><br><br>
    <table cellpadding="2">
        <tr style="font-size: 12px">
            <td width="65%"></td>
            <td width="35%" style="border-top: 1px solid #000;text-align: center;">Firma del Paciente - Tutor</td>
        </tr>
    </table>


    
</body>
</html>