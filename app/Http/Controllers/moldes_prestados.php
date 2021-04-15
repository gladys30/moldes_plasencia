<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class moldes_prestados extends Controller
{
    public function remisiones( Request $request)
    {
    $titulo = "REMISIONES A OTRAS EMPRESAS";
    $moldes = \DB::select('call mostrar_remisiones_otras_empresas'); 
    $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(1)'); 
    
    $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Paraíso Cigar')");


   return view('otras_empresas')->with('titulo',$titulo) ->with('moldes',$moldes);
}
}
