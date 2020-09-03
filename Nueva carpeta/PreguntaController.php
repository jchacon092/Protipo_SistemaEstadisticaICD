<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pregunta;

class PreguntaController extends Controller
{
    public function index(Request $request)
    {
    if (!$request->ajax()) return redirect('/');

    $buscar = $request->buscar;
    $criterio = $request->criterio;
    
    if ($buscar==''){
        $preguntas = Pregunta::join('indicadores','preguntas.idindicador','=','indicadores.id')
        ->select('preguntas.id','preguntas.idindicador','preguntas.pregunta','preguntas.ponderacion','indicadores.nombre as nombre_indicador','preguntas.condicion_organizacion','preguntas.nombre','preguntas.condicion')
        ->orderBy('preguntas.id', 'desc')->paginate(3);
    }
    else{
        $preguntas = Pregunta::join('indicadores','preguntas.idindicador','=','indicadores.id')
        ->select('preguntas.id','preguntas.idindicador','preguntas.pregunta','preguntas.ponderacion','indicadores.nombre as nombre_indicador','preguntas.condicion_organizacion','preguntas.nombre','preguntas.condicion')
        ->where('preguntas.'.$criterio, 'like', '%'. $buscar . '%')
        ->orderBy('preguntas.id', 'desc')->paginate(3);
    }
    

    return [
        'pagination' => [
            'total'        => $preguntas->total(),
            'current_page' => $preguntas->currentPage(),
            'per_page'     => $preguntas->perPage(),
            'last_page'    => $preguntas->lastPage(),
            'from'         => $preguntas->firstItem(),
            'to'           => $preguntas->lastItem(),
        ],
        'preguntas' => $preguntas
    ];
    }

public function store(Request $request)
{
    if (!$request->ajax()) return redirect('/');
    $pregunta = new Pregunta();
    $pregunta->idindicador = $request->idindicador;
    $pregunta->pregunta = $request->pregunta;
    $pregunta->ponderacion = $request->ponderacion;
    $pregunta->condicion_organizacion = $request->condicion_organizacion;
    $pregunta->nombre = $request->nombre;
    $pregunta->condicion = '1';
    $pregunta->save();
}
public function update(Request $request)
{
    if (!$request->ajax()) return redirect('/');
    $pregunta = Pregunta::findOrFail($request->id);
    $pregunta->idindicador = $request->idindicador;
    $pregunta->pregunta = $request->pregunta;
    $pregunta->ponderacion = '0';
    $pregunta->condicion_organizacion = $request->condicion_organizacion;
    $pregunta->nombre = $request->nombre;
    $pregunta->condicion = '1';
    $pregunta->save();
}

public function desactivar(Request $request)
{
    if (!$request->ajax()) return redirect('/');
    $pregunta = Pregunta::findOrFail($request->id);
    $pregunta->condicion = '0';
    $pregunta->save();
}

public function activar(Request $request)
{
    if (!$request->ajax()) return redirect('/');
    $pregunta = Pregunta::findOrFail($request->id);
    $pregunta->condicion = '1';
    $pregunta->save();
}
}
