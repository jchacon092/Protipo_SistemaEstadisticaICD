<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Indicador;

class IndicadorController extends Controller
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
            $indicadores = Indicador::join('pilares','indicadores.idpilar','=','pilares.id')
            ->select('indicadores.id','indicadores.idpilar','indicadores.nombre','pilares.nombre as nombre_pilar','indicadores.escala_menor','indicadores.escala_mayor','indicadores.condicion')
            ->orderBy('indicadores.id', 'desc')->paginate(6);
        }
        else{
            $indicadores = Indicador::join('pilares','indicadores.idpilar','=','pilares.id')
            ->select('indicadores.id','indicadores.idpilar','indicadores.nombre','pilares.nombre as nombre_pilar','indicadores.escala_menor','indicadores.escala_mayor','indicadores.condicion')
            ->where('indicadores.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('indicadores.id', 'desc')->paginate(6);
        }
        

        return [
            'pagination' => [
                'total'        => $indicadores->total(),
                'current_page' => $indicadores->currentPage(),
                'per_page'     => $indicadores->perPage(),
                'last_page'    => $indicadores->lastPage(),
                'from'         => $indicadores->firstItem(),
                'to'           => $indicadores->lastItem(),
            ],
            'indicadores' => $indicadores
        ];
    }

    public function selectIndicador(Request $request){
        if (!$request->ajax()) return redirect('/');
        $indicadores = Indicador::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['indicadores' => $indicadores];
    }

    public function listarIndicador(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $indicadores = Indicador::join('pilares','indicadores.idpilar','=','pilares.id')
            ->select('indicadores.id','indicadores.idpilar','indicadores.nombre','pilares.nombre as nombre_pilar','indicadores.escala_menor','indicadores.escala_mayor','indicadores.condicion')
            ->orderBy('indicadores.id', 'desc')->paginate(10);
        }
        else{
            $indicadores = Indicador::join('pilares','indicadores.idpilar','=','pilares.id')
            ->select('indicadores.id','indicadores.idpilar','indicadores.nombre','pilares.nombre as nombre_pilar','indicadores.escala_menor','indicadores.escala_mayor','indicadores.condicion')
            ->where('indicadores.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('indicadores.id', 'desc')->paginate(10);
        }
        

        return ['indicadores' => $indicadores];
    }

    public function listarPdf(){
        $indicadores = Indicador::join('pilares','indicadores.idpilar','=','pilares.id')
            ->select('indicadores.id','indicadores.idpilar','indicadores.nombre',
            'pilares.nombre as nombre_pilar','indicadores.escala_menor','indicadores.escala_mayor',
            'indicadores.condicion')
            ->orderBy('pilares.nombre', 'desc')->get();

        $cont=Indicador::count();

        $pdf = \PDF::loadView('pdf.indicadorespdf',['indicadores'=>$indicadores,'cont'=>$cont]);
        return $pdf->download('indicadores.pdf');
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
        $indicador = new Indicador();
        $indicador->idpilar = $request->idpilar;
        $indicador->nombre = $request->nombre;
        $indicador->escala_menor = $request->escala_menor;
        $indicador->escala_mayor = $request->escala_mayor;
        $indicador->condicion = '1';
        $indicador->save();
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
        $indicador = Indicador::findOrFail($request->id);
        $indicador->idpilar = $request->idpilar;
        $indicador->nombre = $request->nombre;
        $indicador->escala_menor = $request->escala_menor;
        $indicador->escala_mayor = $request->escala_mayor;
        $indicador->condicion = '1';
        $indicador->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $indicador = Indicador::findOrFail($request->id);
        $indicador->condicion = '0';
        $indicador->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $indicador = Indicador::findOrFail($request->id);
        $indicador->condicion = '1';
        $indicador->save();
    }

    
}
