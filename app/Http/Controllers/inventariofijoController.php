<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use DB;
use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Support\Facades\Auth;
use Mail;


class inventariofijoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index( Request $request)
    {       
      $titulo = "INVENTARIO FIJO DE LA SUCURSAL EL PARAÍSO";
      
        $mobil = \DB::select('call mostrar_mobiliario(?)', [$request->id]); 
        $depto = \DB::select('call mostrar_depto(?)', [$request->id]);

        $area = \DB::select('call mostrar_area(?)', [$request->id]);

        $id_planta = [$request->id];

        return view('inventario_sucursalParaiso')->with('titulo',$titulo)->with('mobiliario',$mobil)->with('depto',$depto)->with('area',$area);
    

    }
    

    public static function edit($id)
    {
        
        $fila_moldes = \DB::select('call mostrar_datos_actualizar(?)',[$id]);

        return response()->json( $fila_moldes);


    }


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
    
}
