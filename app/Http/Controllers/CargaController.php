<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Carga;
use App\Titular;

class CargaController extends Controller
{
    //Devuelve todas las cargas
    public function getCargas(){
        $cargas=Carga::all();
        return response()->json($cargas,200);
    }

    //Devuelve la carga con id_carga igual a $id_carga
    public function getCarga($id_carga){
        $carga = Carga::find($id_carga);
        if($carga){
           return response()->json($carga, 200);
        }
        return response()->json(["Carga no encontrada"], 404);
    }

    //Funcion para agregar una carga
    public function addCarga(Request $request){
		$datos = $request->all();
    	$validacion_uno = $this->validar($datos);
    	$validacion_dos = $this->existeCarga($datos);

    	if($validacion_uno[0]){//PASO LA VALIDACION
		    if($validacion_dos[0]){//SI NO EXISTE 
		      $carga=Carga::create($datos);
		      $carga->save();
		      return response()->json(['EL AFILIADO CARGA SE HA INSERTADO CON EXITO'], 201);
		    }
		    return $validacion_dos[1];
		}
        return $validacion_uno[1];
	}

	//funcion que valida los datos ingresados. Devuelve un array con todos los msjes
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

	public function existeCarga($datos){
		$salida=true;
		$mensaje="";
		$numero_documento = $datos['numero_documento'];
        $tipo_documento = $datos['tipo_documento'];
   
		$carga=Carga::where('numero_documento', $numero_documento)->where('tipo_documento', $tipo_documento)->first();
		  if($carga){
		    $salida=false;
		    $mensaje='EL AFILIADO CON TIPO DE DOCUMENTO '.$tipo_documento.' Y NUMERO '.$numero_documento.' YA EXISTE'; 
		  }
		  else{
		      $titular=Titular::where('numero_documento', $numero_documento)->where('tipo_documento', $tipo_documento)->first();
		      if($titular){
		      	$salida=false;
		      	$mensaje='EL AFILIADO CON TIPO DE DOCUMENTO '.$tipo_documento.' Y NUMERO '.$numero_documento.' YA EXISTE COMO TITULAR';
			  }
		  }
		  return [$salida, $mensaje];
    }
    

    //devuelve el titular de una carga ingresada
    public function getTitular($id_carga){
        $carga = Carga::find($id_carga);
        $titular = Titular::where('id_titular', $carga->id_titular)->get();
        return $titular;
    }
}