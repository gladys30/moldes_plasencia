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





class UserController extends Controller
{

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {       
        
        $titulo = "USUARIOS Y ADMINISTRADORES";
        $sucursales = \DB::select('call mostrar_sucursal'); 
        $usuarios = \DB::select('call mostrar_usuarios');       

        return view('usuarios')->with('sucursales',$sucursales)->with('titulo',$titulo)->with('usuarios',$usuarios);
    

    }


    public function login(Request $request)
    {

        return response()->json($request);
        $credentials = $request->only('codigo', 'contrasenia');
        $validator = Validator::make($credentials, 
            [

            'codigo' => 'required',
            'contrasenia' =>'required' 

            ]);

            if ($validator->fails()){ 

                try {
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json([
                            'status' => false,
                            'message'=> "Invalid Credential"]);

                    }
                } catch (JWTException $e) {
                    return response()->json([
                        'status' => false,
                        'error' => $e ->getmessage(),
                        'message'=> "Invalid Credential"
                        
                        ]);   
                }

                return response()->json(compact('token'));

             } else{

            return response()->json([
            'errors' => $validator->messages(), 
            'status' => false ]);
                    }


       

        
    }







         // funcion que sirve para verificar si un usuario existe en la base de datos y si su contrasenia
    // es correcta, arrojando diferentes resultados segun sea el caso.
    public function ingresarUsuario(Request $request){

        $codigo = $request->codigologin;
        $contrasenia = $request->contrasenialogin;

        //verifico si el numero de cuenta del usuario existe en la base de datos
        if($usuario = DB::table('users')->where('codigo', $codigo)->first()){

            // si el usuario existe en la base de datos verifico si la contrasenia introducida es 
            // la correcta.
            if (Hash::check($contrasenia, $usuario->contrasenia)) {
    
                //si la contrasenia es la correcta se manda a loguear al usuario
                return $this->login($request);

    
            }else{

                //si la contrasenia no es correcta la correcta, se devuelvo el siguiente
                // mensaje en formato json.
                return  response()->json(["codigoError" => 1, "msg"=> "clave incorrecta"]);
            }
                

        // si el numero de cuenta del usuario no se encuentra en la base de datos entonces se devuelve como
        // resultado null.
        } else{

            return  response()->json(["codigoError"=> 2, "msg"=> "el usuario no existe"]);

        }


    }















    public function register(Request $request)
    {
       


        $user = User::create([
            'codigo' => $request->get('txt_codigo'),
            'nombre_usuario' => $request->get('txt_nombre_completo'),
            'correo' => $request->get('txt_correo_electronico'),
            'id_planta' => $request->get('txt_sucursales'),
            'contrasenia' => bcrypt($request->get('confirmacion_contrasenia')),
        ]);

        


        $titulo = "USUARIOS Y ADMINISTRADORES";
        $sucursales = \DB::select('call mostrar_sucursal'); 
        $usuarios = \DB::select('call mostrar_usuarios');       

        return view('usuarios')->with('sucursales',$sucursales)->with('titulo',$titulo)->with('usuarios',$usuarios);
    }



    public function getAuthenticatedUser()
        {
                try {

                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }

                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                        return response()->json(['token_expired'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());

                }

                return response()->json(compact('user'));
        }





        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        
        $usuario = \DB::select('call actualizar_usuarios(:id_usuario, :codigo,:nombre_usuario,:id_planta,:correo)',
                    [
                        'id_usuario' => (int)$request->id_usuario,
                        'codigo' => (int)$request->txt_codigo,
                        'nombre_usuario' => (string)$request->txt_nombre_completo,
                        'id_planta' => (int)$request->txt_sucursales,
                        'correo' => (string)$request->txt_correo
                     ]);

            
                      

                     $titulo = "USUARIOS Y ADMINISTRADORES";
                     $sucursales = \DB::select('call mostrar_sucursal'); 
                     $usuarios = \DB::select('call mostrar_usuarios');       
             
                     return view('usuarios')->with('sucursales',$sucursales)->with('titulo',$titulo)->with('usuarios',$usuarios);

    }

    public function destroy(Request $request)
    {
        $usuario = \DB::select('call eliminar_usuario(:id_usuario)',
        [
            'id_usuario' => (int)$request->id_usuarioE
         ]);

        $titulo = "USUARIOS Y ADMINISTRADORES";
        $sucursales = \DB::select('call mostrar_sucursal'); 
        $usuarios = \DB::select('call mostrar_usuarios');   
        
        return REDIRECT('usuarios')->with('sucursales',$sucursales)->with('titulo',$titulo)->with('usuarios',$usuarios);
    }




     




}
