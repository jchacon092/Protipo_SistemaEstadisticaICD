<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablapib extends Model
{
    protected $table = 'Tablapibs';
    //protected $primaryKey = 'id';
    protected $fillable = ['etapa','pib_menor','pib_mayor'];
}
