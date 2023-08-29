<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Inscripcion;
use App\Models\Carrera;
use Barryvdh\DomPDF\Facade\Pdf;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function create($dni)
    {
        // Envío de email con información importante	
        $turno = Inscripcion::where('dni',$dni)->first();
        $alumno = Alumno::where('dni',$dni)->first();
        
        $nom = $alumno->nombre;
        $diaDado = $turno->fecha;
        $horaDada = $turno->hora;
        ///////HASH PARA CAMBIO DE TURNO/////
        $hash = $turno->$hash;
		///////////////////////////////////

		$de = "isft38@cfg.com.ar";
		$a = $alumno->email;
		$asunto = "Comprobante de turno para inscripción - ISFT N°38";

		$mensajeHTML = '
            <html>
			    <head>
					<title>Comprobante de turno</title>
				</head>
				<body>
					<hr>
					<p>'.$nom.':</p>
					<p>Este documento es v&aacute;lido (impreso o en formato digital) como comprobante de tu preinscripci&oacute;n en el ISFT N&ordm;38 y del turno obtenido para entregar documentaci&oacute;n en Secretar&iacute;a.</p>
					<p>Tu turno en Secretar&iacute;a (presentate en la Biblioteca del ISFT N&ordm;38) es el '.date("d/m/Y", strtotime($diaDado)).' a las '.$horaDada.'.
					<p>En caso de ser necesario, puede cancelar el turno entrando al siguiente enlace: <a href="http://isft38_2.test/inscripciones/cancelar/'.$hash.'">Cancelar turno</a></p>
					<p>Cuando concurr&aacute;s a tu turno, no olvid&eacute;s llevar la siguiente documentaci&oacute;n:</p>
					<p>- Original y fotocopia de Certificado de Estudio Secundario Completo (Certificado Anal&iacute;tico) o de t&iacute;tulo en tr&aacute;mite.</p>
					<p>- Certificado de finalizaci&oacute;n y materias adeudadas, expedido por la Escuela Secundaria de la que egresaste.</p>
					<p>- Original y fotocopia del DNI.</p>
					<p>- Dos fotos tamaño 4 x 4 cm.</p>
					<p>- Fotocopia de Partida de Nacimiento.</p>
					<p>- Colaboraci&oacute;n Asociaci&oacute;n Cooperadora.</p>
					<p>IMPORTANTE!!! Si quer&eacute;s agilizar el tr&aacute;mite de inscripci&oacute;n, pod&eacute;s descargar, imprimir y completar la Solicitud de Inscripción para tu carrera en la página https://www.cfg.com.ar/turnos/descargar.html.</p>
					<p>Nuevamente te damos la bienvenida y te deseamos el mayor de los &eacute;xitos!</p>
					<hr>
				</body>
			</html>
		';

		$cabeceras = "MIME-Version: 1.0" . "\r\n";
		$cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
		$cabeceras .= "From:" . $de;
		$resultado = mail($a,$asunto,$mensajeHTML,$cabeceras);

            
        $pdf = Pdf::loadHTML($mensajeHTML);
        return $pdf->download('comprobante.pdf');

        //   return redirect()->route('convertToPDF', compact('mensajeHTML'));

  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($dni)
    {

        $turno = Inscripcion::where('dni',$dni)->first();
        $alumno = Alumno::where('dni',$dni)->first();
        $carrera = Carrera::where('id', $turno->carrera)->first();
        $nomCarrera = $carrera->descripcion;
        
        $de = "isft38@cfg.com.ar";

        $headers = "";
        $headers .= "From: I.S.F.T N 38 <" . $de . ">\r\n";
        $headers .= "Reply-To: " . $alumno->nombre . " <" . $alumno->email . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $a = $alumno->email;
        $asunto = "Comprobante de turno para inscripcion - ISFT N 38";
        $mensajeHTML = '
            <html>
				<head>
					<title>Comprobante de ingreso a lista de espera</title>
				</head>
				<body>
					<hr>
					<p>'.$alumno->nombre.':</p>
					<p>Has sido agregado a la lista de espera para la inscripci&oacute;n a la carrera '.$nomCarrera.'.</p>
					<p>En el momento de habilitarse un lugar en la misma, ser&aacute;s contactado por un representante del instituto a trav&eacute;s de los medios aportados.</p>
					<hr>
					<p>De ser convocado, deber&aacute;s presentar la siguiente documentaci&oacute;n:
					<p>- Original y fotocopia de Certificado de Estudio Secundario Completo (Certificado Anal&iacute;tico) o de t&iacute;tulo en tr&aacute;mite.</p>
					<p>- Certificado de finalizaci&oacute;n y materias adeudadas, expedido por la Escuela Secundaria de la que egresaste.</p>
					<p>- Original y fotocopia del DNI.</p>
					<p>- Dos fotos tama&ntilde;o 4 x 4 cm.</p>
					<p>- Fotocopia de Partida de Nacimiento.</p>
					<p>- Colaboraci&oacute;n Asociaci&oacute;n Cooperadora.</p>
					<hr>
				</body>
			</html>
			';
 
        $resultado = mail($a, $asunto, $mensajeHTML, $headers);

        $pdf = Pdf::loadHTML($mensajeHTML);
        return $pdf->download('comprobante.pdf');
        
    }

}
