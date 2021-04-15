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


class MoldesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
       
        $titulo = "INVENTARIO DE MOLDES SUCURSAL EL PARAÍSO";
        $vitolaB = $request->vitolabuscar;
        $figuraB = $request->figurabuscar;
        
        $moldes = \DB::select('call moldes_paraiso(:vitola,:nombre_figura)',
        [ 'vitola' => (string)$request->vitolabuscar,
          'nombre_figura' => (string)$request->figurabuscar]);

        $vitolas = \DB::select('call mostrar_vitolas(?)', [$request->id]);

        $figuras = \DB::select('call mostrar_figura_tipos(?)', [$request->id]);

        $id_planta = [$request->id];

        return view('sucursal_elparaiso')->with('moldes',$moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
        ->with('id_planta', $id_planta)->with('titulo',$titulo)->with('vitolaB',$vitolaB)->with('figuraB',$figuraB);
    }

    

    public function remisiones( Request $request)
    {

       
    $titulo = "REMISIONES EL PARAÍSO";
    $moldes = \DB::select('call moldes_remision(1)'); 
    $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(1)'); 
    
    $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Paraíso Cigar')");
    
    $bodega = \DB::select('call traer_cantidad(:id_planta)',
    [
        'id_planta' => (int)$request->id_planta
    ]);

  

    return view('remisionesparaiso')->with('titulo',$titulo)->with('moldes',$moldes)
    ->with('remisionesenviadas',$remisionesenviadas)->with('remisionesrecibidas',$remisionesrecibidas)->with('bodega',$bodega);

}

public function buscar_remision( Request $request)
{
$titulo = "REMISIONES EL PARAÍSO";
$moldes = \DB::select('call moldes_remision(1)'); 
$remisionesenviadas = \DB::select('call buscar_remision(:fecha_inicio,:fecha_fin,:id_planta_remision)',
[ 'fecha_inicio' => $request->fecha_inicio,
  'fecha_fin' => $request->fecha_fin,
  'id_planta_remision' => $request->id_planta_remision]);

$remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Paraíso Cigar')");


return view('remisionesparaiso')
->with('titulo',$titulo)
->with('moldes',$moldes)
->with('remisionesenviadas',$remisionesenviadas)
->with('remisionesrecibidas',$remisionesrecibidas);

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



        $bodega = \DB::select('call traer_cantidad(:id_planta)',
        [
            'id_planta' => (int)$request->id_planta
        ]);

    
       

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

        $titulo = "REMISIONES EL PARAÍSO";
        $moldes = \DB::select('call moldes_remision(1)');  
         $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(1)');   

        $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Paraíso Cigar')");
        
      return view('remisionesparaiso')->with('titulo',$titulo)->with('moldes',$moldes)
      ->with('remisionesenviadas',$remisionesenviadas)      ->with('remisionesrecibidas',$remisionesrecibidas) ->with('bodega',$bodega);
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
     
        
         $titulo = "REMISIONES EL PARAISO";
         $moldes = \DB::select('call moldes_remision(1)'); 
         $remisionesenviadas = \DB::select('call mostrar_remisiones_enviadas(1)'); 
        
         $remisionesrecibidas = \DB::select("call mostrar_remisiones_recibidas('Paraíso Cigar')"); 
         
     
         return view('remisionesparaiso')
        ->with('titulo',$titulo)
        ->with('moldes',$moldes)
        ->with('remisionesenviadas',$remisionesenviadas)
         ->with('remisionesrecibidas',$remisionesrecibidas)->with('bodega',$bodega);


    }

    




    public function imprimirdatosparaiso( Request $request)
    {
        
        $fecha =Carbon::now();
        $fecha = $fecha->format('d-m-Y');

     

        
        $moldes = \DB::select('call moldes_paraiso(:vitola,:nombre_figura)',
        [ 'vitola' => (string)$request->vitolaimprimir,
          'nombre_figura' => (string)$request->figuraimprimir]);
            
        $vitolas = \DB::select('call mostrar_vitolas(?)', [$request->id]);
        $figuras = \DB::select('call mostrar_figura_tipos(?)', [$request->id]);
        $id_planta = [$request->id];
  
        $vista = view('imprimirtablaparaiso',['fecha' =>$fecha])->with('moldes',$moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
        ->with('id_planta', $id_planta);

        $pdf =  \PDF::loadHTML($vista);
        return $pdf->stream('nombre.pdf');



        // $pdf = PDF::loadView('imprimirtablaparaiso')->with('moldes',$moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)->with('id_planta', $id_planta);
        //  return $pdf->stream();
   
    

        

    

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
        $molde = \DB::select('call insertar_moldes(:id_planta,:id_vitola,:id_figura,:bueno,:irregular,:malo,:bodega,:reparacion,:salon,:fivi)',
                    [ 'id_planta' => (int)$request->id_planta,
                    'id_vitola' =>  \DB::select('call traer_id_vitola(?,?)', [$request->id_planta,$request->id_vitola])[0]->id_vitola,
                    'id_figura' => \DB::select('call traer_id_figura(?,?)', [$request->id_planta,$request->id_figura])[0]->id_figura,
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


                    return REDIRECT('sucursal_elparaiso/1')->with('moldes', $moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
                    ->with('id_planta', $request->id);

 

    }




     /* 
        $v_buenos = $request->bueno;
        $v_irregulares = $request->irregulares;
        $v_malos = $request->malos;
        $v_bodega = $request->bodega;
        $v_reparacion = $request->reparacion;
        $v_salon =$request->salon;
        $v_total =$request->total;
       
       if($v_buenos==""){ $v_buenos = "0";}
       if($v_irregulares==""){ $v_irregulares = "0";}
       if($v_malos==""){ $v_malos = "0";}
       if($v_bodega==""){ $v_bodega = "0";}
       if($v_reparacion==""){ $v_reparacion = "0";}
       if($v_salon==""){ $v_salon = "0";}
       */


     // validaciones para guardar
       /*
       if($v_total == "" || (int)($v_total) > 999999 ||  (int)($v_total) < 1   ){          

             toastr()->error('El total de ser mayor o igual a 1, o menor que 1000000' , 'ERROR');

        }else if( (int)($v_total) === ((int)($v_buenos)+(int)($v_irregulares)+(int)($v_malos))&&            
                  (int)($v_total) === ((int)($v_bodega)+(int)($v_reparacion)+(int)($v_salon))){              

                 
                   



        }else if((int)($v_total) != ((int)($v_buenos)+(int)($v_irregulares)+(int)($v_malos))&& 
                 (int)($v_total) === ((int)($v_bodega)+(int)($v_reparacion)+(int)($v_salon)) ){

                    toastr()->error( 'Tus datos de estado coinciden con el total','ERROR' );

        }else if((int)($v_total) === ((int)($v_buenos)+(int)($v_irregulares)+(int)($v_malos))&& 
                 (int)($v_total) != ((int)($v_bodega)+(int)($v_reparacion)+(int)($v_salon)) ){

                 toastr()->error( 'Tus datos de ubicación coinciden con el total','ERROR' );

        }else {        
                  toastr()->error( 'Tus datos no coinciden con el total','ERROR' ,[
                    'timeOut' => 2000,
                    'positionClass' => "toast-top-full-width",
                    'progressBar' => TRUE,
                    'showDuration'=> 300,
                    ]); 

        }
            */
     







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


                    return REDIRECT('sucursal_elparaiso/1')->with('moldes', $moldes)->with('vitolas', $vitolas)->with( 'figuras',$figuras)
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
