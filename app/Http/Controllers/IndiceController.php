<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Indice;

class IndiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $indices = Indice::join('departamentos','indices.iddep','=','departamentos.id')
            ->select('indices.id','indices.iddep','indices.poblacion','departamentos.nombre as departamento','indices.anio','indices.pib','indices.puntaje')
            ->orderBy('indices.id', 'desc')->paginate(6);
        }
        else{
            $indices = Indice::join('departamentos','indices.iddep','=','departamentos.id')
            ->select('indices.id','indices.iddep','indices.poblacion','departamentos.nombre as departamento','indices.anio','indices.pib','indices.puntaje')
            ->where('indices.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('indices.id', 'desc')->paginate(6);
        }
        

        return [
            'pagination' => [
                'total'        => $indices->total(),
                'current_page' => $indices->currentPage(),
                'per_page'     => $indices->perPage(),
                'last_page'    => $indices->lastPage(),
                'from'         => $indices->firstItem(),
                'to'           => $indices->lastItem(),
            ],
            'indices' => $indices
        ];
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $indice = new Indice();
        $indice->iddep = $request->iddep;
        $indice->poblacion = $request->poblacion;
        $indice->anio = $request->anio;
        $indice->pib = $request->pib;
        $indice->condicion = '1';
        $indice->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $indice = Indice::findOrFail($request->id);
        $indice->iddep = $request->iddep;
        $indice->poblacion = $request->poblacion;
        $indice->anio = $request->anio;
        $indice->pib = $request->pib;
        $indice->condicion = '1';
        $indice->save();
    }

   
}
