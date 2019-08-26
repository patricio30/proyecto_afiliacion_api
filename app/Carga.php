<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Titular;

class Carga extends Model
{
    protected $table = 'cargas';
    
    protected $fillable = ['id_carga', 'tipo_documento', 'numero_documento', 'apellido', 'nombre', 'fecha_nacimiento', 'numero_carga', 'id_titular'];

    protected $primaryKey = 'id_carga';

    public $timestamps = false;
}
