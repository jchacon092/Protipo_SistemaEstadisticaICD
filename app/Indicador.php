<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $table = 'indicadores';
    protected $primaryKey = 'id';
    protected $fillable =['idpilar','nombre','escala_menor','escala_mayor','condicion'];
   
    public function pilar(){
        return $this->belongsTo('App\Pilar');
    }

    public function preguntas()
    {
        return $this->hasMany('App\Pregunta');
    }

    public function puntajeindicadores()
    {
        return $this->hasMany('App\Puntajeindicador');
    }
}
