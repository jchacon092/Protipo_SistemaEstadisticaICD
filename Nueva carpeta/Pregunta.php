<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'id';
    protected $fillable =['idindicador','pregunta','ponderacion','condicion_organizacion','nombre','condicion'];
    public function indicador(){
        return $this->belongsTo('App\Indicador');
    }
}
