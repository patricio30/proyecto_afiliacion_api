<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Titular;
use App\Carga;

class TitularController extends Controller
{
    //devuelve todos los titulares
    public function getTitulares(){
        $titulares=Titular::all();
        return response()->json($titulares,200);
    }

	// devuelve al titular cuyo id es $id_titular
    public function getTitular($id_titular){
        $titular = Titular::find($id_titular);
        if($titular){
           return response()->json($titular, 200);
        }
        return response()->json(["Titular no encontrado"], 404);
    }

	//agrega un titular a la base de datos haciendo las verif correspondientes
    public function addTitular(Request $request){
		$datos = $request->all();

    	$validacion_uno = $this->validar($datos);
    	$validacion_dos = $this->existeTitular($datos);

    	if($validacion_uno[0]){//PASO LA VALIDACION DE DATOS
		    if($validacion_dos[0]){//SI NO EXISTE 
		      $titular=Titular::create($datos);
		      $titular->save();
		      return response()->json(['EL AFILIADO TITULAR SE HA INSERTADO CON EXITOo'], 201);
		    }
		    return $validacion_dos[1];
		}
		return $validacion_uno[1];
	}

	//funcion que valida los datos ingresados. Devuelve un array con todos los msjes de errores
	public function validar($datos){
	  $salida=true;
	  $mensajes = Array();
	    
	  if(!is_numeric($datos['numero_documento']) && !is_null($datos['numero_documento'])){
	    $salida=false;
	    $mensaje1="EL NUMERO DE DOCUMENTO DEBE SER NUMERICO";
	    array_push($mensajes, $mensaje1);
	  }  
	  if(is_null($datos['numero_documento'])){
	    $salida=false;
	    $mensaje2="EL NUMERO DE DOCUMENTO ES OBLIGATORIO";
	    array_push($mensajes, $mensaje2);
      }     
	  return [$salida, $mensajes];
	}

	//funcion que verifica si el afiliado ingresado ya existe como titular o carga
	public function existeTitular($datos){
		$salida=true;
		$mensaje="No existe";
		$numero_documento = $datos['numero_documento'];
		$tipo_documento = $datos['tipo_documento'];
   
		$titular=Titular::where('numero_documento', $numero_documento)->where('tipo_documento', $tipo_documento)->first(); //si existe titular con igual nro y tipo doc
		     
		  if($titular){
		    $salida=false;
		    $mensaje='EL AFILIADO CON TIPO DE DOCUMENTO '.$tipo_documento.' Y NUMERO '.$numero_documento.' YA EXISTE'; 
		  }
		  else{
		      $carga=Carga::where('numero_documento', $numero_documento)->where('tipo_documento', $tipo_documento)->first();
		      if($carga){
		      	$salida=false;
		      	$mensaje='EL AFILIADO CON TIPO DE DOCUMENTO '.$tipo_documento.' Y NUMERO '.$numero_documento.' YA EXISTE COMO CARGA';
			  }
		  }
		  return [$salida, $mensaje];
	}


	//devuelve las cargas de un titular ingresado
	public function getCargas($id_titular){
		$cargas = Carga::where('id_titular', $id_titular)->get();
		return $cargas;
	}
}
