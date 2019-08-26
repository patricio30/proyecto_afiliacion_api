<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Carga;

class Titular extends Model
{
    
    protected $table = 'titulares';

    protected $fillable = ['id_titular', 'tipo_documento', 'numero_documento', 'apellido', 'nombre', 'fecha_nacimiento'];

    protected $primaryKey = 'id_titular';

    public $timestamps = false;
}
