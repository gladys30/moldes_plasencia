<?php

namespace App\Http\Controllers;

use App\Models\Moldes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use PDF;
use Carbon\Carbon;


class sucursal_gualiqueme extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
       
        $titulo = "INVENTARIO DE MOLDES SUCURSAL GUALIQUEME";
        
        $moldes = \DB::select('call moldes_gualiqueme(:vitola,:nombre_figura)',
        [ 'vitola' => (string)$request->vitolabuscar,
          'nombre_figura' => (string)$request->figurabuscar]);

        $vitolas     = \DB::select('call mostrar_vitolas(?)', [$request->id]);

        $figuras = \DB::select('call mostrar_figura_tipos(?)', [$request->id]);

        $id_planta = [$request->id];


        

        return view('sucursal_gualiqueme')->with('moldes',$moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
        ->with('id_planta', $id_planta)->with('titulo',$titulo);
    

    }


    public function imprimirdatosparaiso( Request $request)
    {
        
        $fecha =Carbon::now();
        $fecha = $fecha->format('d-m-Y');

     

        
        $moldes = \DB::select('call mostrar_datos_moldes(?)', [$request->id]);    
        $vitolas = \DB::select('call mostrar_vitolas(?)', [$request->id]);
        $figuras = \DB::select('call mostrar_figura_tipos(?)', [$request->id]);
        $id_planta = [$request->id];
  
        $vista = view('imprimirtabla_gualiqueme',['fecha' =>$fecha])->with('moldes',$moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
        ->with('id_planta', $id_planta);

        $pdf =  \PDF::loadHTML($vista);
        return $pdf->stream('nombre.pdf');

    }

        // $pdf = PDF::loadView('imprimirtablaparaiso')->with('moldes',$moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)->with('id_planta', $id_planta);
        //  return $pdf->stream();
   
        public function remisiones( Request $request)
        {
        $titulo = "REMISIONES GUALIQUEME";
        $moldes = \DB::select('call moldes_remision(4)'); 
        $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(4)'); 
        
        $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Gualiqueme')"); 
        $bodega = \DB::select('call traer_cantidad(:id_planta)',
        [
            'id_planta' => (int)$request->id_planta
        ]);
    
    
        return view('remisionesgualiqueme')
        ->with('titulo',$titulo)
        ->with('moldes',$moldes)
        ->with('remisionesenviadas',$remisionesenviadas)
        ->with('remisionesrecibidas',$remisionesrecibidas)->with('bodega',$bodega);
    
    }
    
    
        public function insertarremisiones( Request $request)
        {
    
            $fecha =Carbon::now();
            $fecha = $fecha->format('Y-m-d');
            $empresa = "";
    
            
    
            if($request->txt_otra_fabrica != null){
                $empresa = $request->txt_otra_fabrica;
            }else{
                $empresa = $request->txt_sucursales;
            }
    
            $molde = \DB::select('call insertar_remisiones(:fecha,:id_planta,:nombre_fabrica,:estado_moldes,:tipo_molde,:cantidad,:chequear)',
            [ 
            'fecha' => $fecha,
            'id_planta' => (int)$request->id_planta,
            'nombre_fabrica'=> $empresa,
            'estado_moldes' => (string)$request->txt_estado,
            'tipo_molde' => (string)$request->id_tipo,
            'cantidad' => (int)$request->txt_cantidad, 
            'chequear' => (int)$request->chequear
            ]);
    
            $bodega = \DB::select('call traer_cantidad(:id_planta)',
    [
        'id_planta' => (int)$request->id_planta
    ]);

            $titulo = "REMISIONES GUALIQUEME";
            $moldes = \DB::select('call moldes_remision(4)');  
            $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(4)'); 
        
            $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Gualiqueme')"); 
            return view('remisionesgualiqueme')->with('titulo',$titulo)->with('moldes',$moldes)
            ->with('remisionesenviadas',$remisionesenviadas)        
        ->with('remisionesrecibidas',$remisionesrecibidas)->with('bodega',$bodega);
        }



        

    public function actualizarremision(Request $request, $id){ 




        $remision = \DB::select('call actualizar_remision_moldes(:id_remision, :id_planta,:estado,:fivi,
        :cantidad,:id_molde,:planta_recibido,:nombre_otra_planta)',

        [
            'id_remision' => (int)$request->txt_id_remision,
            'id_planta' => (int)$request->txt_id_planta,
            'estado' => (string)$request->txt_estado_moldes,
             'fivi' => (string)$request->txt_tipo_moldes,
            'cantidad' => (int)$request->cantidad,
            'id_molde' => (int)$request->id_molde,
            'planta_recibido' => (string)$request->nombre_recibido,
            'nombre_otra_planta'=> (string)$request->txt_nombre_fabrica
         ]);

$bodega = \DB::select('call traer_cantidad(:id_planta)',
    [
        'id_planta' => (int)$request->id_planta
    ]);

        
         $titulo = "REMISIONES GUALIQUEME";
         $moldes = \DB::select('call moldes_remision(4)'); 
         $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(4)'); 
        
         $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Gualiqueme')"); 
         
     
         return view('remisionesgualiqueme')
        ->with('titulo',$titulo)
        ->with('moldes',$moldes)
        ->with('remisionesenviadas',$remisionesenviadas)
         ->with('remisionesrecibidas',$remisionesrecibidas)->with('bodega',$bodega);


    }

    
    


    public function index_vitola(Request $request)
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    
    }



      

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $molde = \DB::select('call insertar_moldes_planta4(:id_planta,:id_vitola,:id_figura,:bueno,:irregular,:malo,:bodega,:reparacion,:salon,:fivi)',
        [ 'id_planta' => (int)$request->id_plantamo,
        'id_vitola' =>  \DB::select('call traer_id_vitola(?,?)', [$request->id_plantamo,$request->id_vitola])[0]->id_vitola,
        'id_figura' => \DB::select('call traer_id_figura(?,?)', [$request->id_plantamo,$request->id_figura])[0]->id_figura,
        'bueno' => (int)$request->bueno,
        'irregular' => (int)$request->irregulares,
        'malo' => (int)$request->malos,
        'reparacion' => (int)$request->reparacion,
        'bodega' => (int)$request->bodega,
        'salon' => (int)$request->salon,
        'fivi' => (string)$request->fivi
        
        ]);

                   

                    $moldes = \DB::select('call mostrar_datos_moldes(?)', [$request->id]);
                            
                    $vitolas = \DB::select('call mostrar_vitolas(?)', [$request->id]);

                    $figuras = \DB::select('call mostrar_figura_tipos(?)', [$request->id]);


                    return REDIRECT('sucursal_gualiqueme/4')->with('moldes', $moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
                     ->with('id_planta', $request->id);

 

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moldes  $moldes
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moldes  $moldes
     * @return \Illuminate\Http\Response
     */
    public static function edit($id)
    {
        
        $fila_moldes = \DB::select('call mostrar_datos_actualizar(?)',[$id]);

        return response()->json( $fila_moldes);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moldes  $moldes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        
        $molde = \DB::select('call actualizar_moldes(:id_molde, :bueno,:irregular,:malo,:bodega,:reparacion,:salon)',
                    [
                        'id_molde' => (int)$request->id_molde,
                        'bueno' => (int)$request->mo_bueno,
                        'irregular' => (int)$request->mo_irregular,
                        'malo' => (int)$request->mo_malo,
                        'reparacion' => (int)$request->mo_reparacion,
                        'bodega' => (int)$request->mo_bodega
                        ,'salon' => (int)$request->mo_salon
                     ]);

            
                      

                    $moldes = \DB::select('call mostrar_datos_moldes(?)', [$request->id]);
                            
                    $vitolas = \DB::select('call mostrar_vitolas(?)', [$request->id]);

                    $figuras = \DB::select('call mostrar_figura_tipos(?)', [$request->id]);


                    return REDIRECT('sucursal_gualiqueme/4')->with('moldes', $moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
                    ->with('id_planta', $request->id);

 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moldes  $moldes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moldes $moldes)
    {
        //
    }

    public function totales()
    {
       
        $titulo = "SUMATORIA TOTAL DE LOS MOLDES PLASENCIA";

        $distintos = \DB::select('call distintos_moldes()');

        foreach($distintos as $distinto){
            $insertar = \DB::select('call insertar_totales_plantas(?)' , [$distinto->figura_vitola]);
        }

        $totales_moldes = \DB::select('call mostrar_total_todas_plantas()');

        
        

        return view('sucursales_total')->with('totales',$totales_moldes)->with('titulo',$titulo);
    

    }



    
}
