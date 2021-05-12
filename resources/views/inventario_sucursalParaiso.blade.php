@extends('principal')


@section('content')

<!-- Libreria de las alertas -->
<script src= "{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css') }}">

<button type="button" class=" btn-info float-right"   data-toggle="modal" data-target="#modal_agregar_mobiliario"  style="margin-right: 10px; margin-bottom: 10px;">
      <span> + Mobiliario</span>
  </button>

  <button type="button" class=" btn-info float-right"   data-toggle="modal" data-target="#modal_agregar_area"  style="margin-right: 10px; margin-bottom: 10px;">
      <span> + Area</span>
  </button>

<button type="button" class=" btn-info float-right"   data-toggle="modal" data-target="#modal_agregar_depto"  style="margin-right: 10px; margin-bottom: 10px;">
      <span> + Departamento</span>
  </button>

  <form action=  "{{Route('id_plantass',1)}}" method= "POST" class="form-inline">
      @csrf
 <input value="" onKeyDown="copiar('deptobuscar');" name="deptobuscar" id="deptobuscar" class="form-control mr-sm-2"  placeholder="Departamento" style="width:150px;">
 <input value=""  onKeyDown="copiar2('areabuscar');" name="areabuscar"  id="areabuscar" class="form-control mr-sm-2"  placeholder="Area" style="width:150px;">
   <button class="btn-info" type="submit">
    <span>
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
  </svg>
  </span>
    </button>
  </form>


  

<!-- INICIO MODAL DEPARTAMENTO -->
<form action = "{{Route('insertar_depto',1)}}" method="POST" name = "formdepto">
<div class="modal fade" id="modal_agregar_depto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar Departamento</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3 col">            
      <label for="txt_departamento" class="form-label">Departamento</label>
      <input class="form-control" id="departamento" type="text" name="departamento" placeholder="Agregar Departamento" maxLength="30">  
      </div>
      </div>
      <div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
        </button>
        <button  onclick="validar_depto()" class=" btn-info float-right"  style="margin-right: 10px">

            <span>Guardar</span>
        </button>
        @csrf
        <input name = "id_planta"  value ='1' hidden />
      </div>
    </div>
  </div>
</div>
</form>
<!-- FIN MODAL DEPARTAMENTO -->



<!-- INICIO MODAL AREA -->
<form action = "{{Route('insertar_area',1)}}" method="POST" name = "formarea">
<div class="modal fade" id="modal_agregar_area" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar Area</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3 col">            
      <label for="txt_departamento" class="form-label">Area</label>
      <input class="form-control" id="area" type="text" name="area" placeholder="Agregar Area" maxLength="30">  
      </div>
      </div>
      <div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
        </button>
        <button  onclick="validar_area()" class=" btn-info float-right"  style="margin-right: 10px">

            <span>Guardar</span>
        </button>
        @csrf
        <input name = "id_planta"  value ='1' hidden />
      </div>
    </div>
  </div>
</div>
</form>
<!-- FIN MODAL AREA -->




<!-- INICIO DEL MODAL NUEVO MOBILIARIO -->

<form action =  "{{Route('insertar_mobiliario',1)}}" method= "POST" id ="FormMobiliario" name="FormMobiliario">

<div class="modal fade" role="dialog" id="modal_agregar_mobiliario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;width=800px;">
<div class="modal-dialog modal-dialog-centered modal-lg"  style="opacity:.9;background:#212529;width=80%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar Mobiliario</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" ></button>
      </div>
     
      <div class="modal-body">
          <div class="card-body">  
            
        <div class="row">

          <div class="mb-3 col">
                    <label for="txt_depto" class="form-label">Departamento</label>
                      <select class="form-control" id="txt_depto" name="id_depto" placeholder="Ingresa el departamento" required>
                         @foreach($depto as $dep)
                        <option > {{$dep-> nombre_depto}}</option>
                        @endforeach
                        </select> 
                  </div>

                  <div class="mb-3 col">
                    <label for="txt_area" class="form-label">Area</label>
                        <select class="form-control"  type= "text" list="prediccionarea" id="txt_area"  name="id_area" placeholder="Ingresa el área" required>
                            @foreach($area as $areaa)
                              <option >{{$areaa-> nombre_area}}</option>
                            @endforeach 
                            
                        </select>                         
                  </div>

        </div>

              <div class="row">

                  

                  <div class="mb-3 col">
                  <label for="txt_mobi" class="form-label">Mobiliario</label>
                  <input class="form-control" id="txt_mobi"  name="mobi"placeholder="" type="text">        
                  </div>
                  <div class="mb-3 col">            
                  <label for="txt_cant" class="form-label">Cantidad</label>
                  <input class="form-control" id="txt_cant" name="cant" placeholder="Cantidad" type="number">  
                  </div>
                  <div class="mb-3 col">
                  <label for="txt_descrip" class="form-label">Descripción</label>
                  <input class="form-control" id="txt_descrip" name="descrip"placeholder="" type="text">  
                  </div>
                  <input name = "id_planta"  value ='1' hidden />
              </div> 
           
             
        </div>
      </div>
    
      <div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
            @csrf
        </button>
        <button  class=" btn-info " onclick="validar_mobiliario()" >
            <span>Guardar</span>
        </button>

        
      </div>
    </div>
  </div>
</div>

</form>
 <!--FIN DEL MODAL NUEVO MOBILIARIO -->







<!-- INICIO DEL MODAL EDITAR MOBILIARIO -->


<form action =  "{{Route('actualizar_mobiliario',1)}}" method= "POST" name = "formulario_actualizar">
 <?php use App\Http\Controllers\MoldesController; ?>

   <div hidden>{{$id_mobiliario_basico=0}}</div>
     



<div class="modal fade" id="modal_editar_mobiliario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;width=800px;">
  <div class="modal-dialog modal-dialog-centered modal-xl"  style="opacity:.9;background:#212529;width=100%">
    <div class="modal-content">
      <div class="modal-header"   >
    
      <h5  class="form-label" id="titulo_depto"  name= "titulo_depto"></h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" ></button>
      </div>


     
      <div class="modal-body">
          <div class="card-body">            
   
           




              <div class="row">

              <div class="mb-3 col">
              <label for="txt_buenos" class="form-label">Mobiliario</label>
                  <input class="form-control" id="mo_mobil"  name="mo_mobil"  placeholder="" type="text" value = "" >        
                  </div>

                  <div class="mb-3 col">
                  <label for="txt_buenos" class="form-label">Cantidad</label>
                  <input class="form-control" id="mo_cant"  name="mo_cant"  placeholder="Cantidad" type="number" value = "" >        
                  </div>
                  <div class="mb-3 col">            
                  <label for="txt_irregulares" class="form-label">Descripción</label>
                  <input class="form-control" id="mo_descrip" name="mo_descrip" placeholder="" type="text">  
                  <input name = "id_mobiliario" id =  "id_mobiliario" value =" " hidden />
                  </div>
                  
              </div>
              
        </div>
      </div>
    
      <div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
            @csrf
        </button>
        <button  class=" btn-info " onclick="validar_actualizar_mobiliario()" >
            <span>Guardar</span>
        </button>

        
      </div>
    </div>
  </div>
</div>

</form>
<!-- FIN DEL MODAL EDITAR MOBILIARIO -->





<script type="text/javascript">

function datos_modal_mobiliario(id){



var datas = '<?php echo json_encode($mobiliario);?>';

var data = JSON.parse(datas);


for (var i = 0; i < data.length; i++) {

if(data[i].id_mobiliario === id){ 

//alert(data[i].id_mobiliario);

 document.formulario_actualizar.mo_mobil.value = data[i].nombre_mobiliario;
 document.formulario_actualizar.mo_cant.value = data[i].cant_mobiliario;
 document.formulario_actualizar.mo_descrip.value = data[i].descripcion_mobiliario;
 document.formulario_actualizar.id_mobiliario.value = id;
 document.getElementById("titulo_depto").innerHTML = "        ".concat("Departamento: ",  data[i].nombre_depto,"<br>", "Area:", " ",  data[i].nombre_area);
 //document.getElementById("titulo_area").innerHTML =  "<br> ".concat("Area:", " ", (string) data[i].nombre_area );
 
}
}


}


</script>


<!-- INICIO DEL TABLA MOBILIARIO -->
<table class="table table-striped table-secondary table-bordered border-primary ">
        <thead class= "table-dark">
        <tr>
            
            <th scope="col">Departamento</th>
            <th scope="col">Area</th>
            <th scope="col">Mobiliario</th>
            <th scope="col">Cantidad</th>     
            <th scope="col">Descripción</th>   
            <th scope="col">Editar</th>         
         </thead>
         <tbody>
        
         @foreach($mobiliario as $mobiliarios)
            <tr>  
                  <td>{{$mobiliarios->nombre_depto}}</td>
                  <td>{{$mobiliarios->nombre_area}}</td>
                  <td>{{$mobiliarios->nombre_mobiliario}}</td>
                  <td>{{$mobiliarios->cant_mobiliario}}</td>
                  <td>{{$mobiliarios->descripcion_mobiliario}}</td>
                 

           <td style="padding:0px; text-align:center;    vertical-align: inherit;" >
           
           <a data-toggle="modal" data-target="#modal_editar_mobiliario" onclick ="datos_modal_mobiliario({{  $mobiliarios->id_mobiliario }})"  >
           <svg xmlns="http://www.w3.org/2000/svg" width=25 height="25" fill="black" class="bi bi-pencil-square" viewBox="0 0 16 16">
             <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
             <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
           </svg>

           </a>
        
        <!--
           <a href= "/inventario_sucursalParaiso/in/qr-code">
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-upc-scan" viewBox="0 0 16 16">
           <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5zM3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z"/>
           </svg>
          </a>
         -->         

            
             </tr>
             
            @endforeach
           
          <tbody>
    </table>

  
<!-- FIN DEL TABLA MOBILIARIO -->





<!-- VALIDACION VENTANA DEPTO -->


<script type="text/javascript">

function validar_depto(){
  var v_dep = document.getElementById('departamento').value;
  
  var deptos = '<?php echo json_encode($depto);?>';

  var depto = JSON.parse(deptos);
   var nombre = 0;


  for (var i = 0; i < depto.length; i++) {
  
    
      console.info(depto[i]);

      if(depto[i].nombre_depto === v_dep){ 
         nombre++;
      }
      
    
    
  }

  if(v_dep ===""){
    toastr.error( 'Ingrese el nombre del Departamento','ERROR',{"progressBar": true,"closeButton": false,"preventDuplicates": true
    , "preventOpenDuplicates": true} );
    event.preventDefault();

  }else if(nombre> 0){
    toastr.error( 'Este Departamento ya existe, favor ingrese uno nuevo','ERROR',{"progressBar": true,"closeButton": false,"preventDuplicates": true
    , "preventOpenDuplicates": true} );
    event.preventDefault();

  }else

  toastr.success( 'Tus datos se guardaron correctamente','BIEN',{"progressBar": true,"closeButton": false} );
  theForm.addEventListener('submit', function (event) {
    });

}

</script>

<!-- FINAL DE LA VALIDACION VENTANA DEPTO -->




<!-- VALIDACION VENTANA AREA -->

<script type="text/javascript">

function validar_area(){
  var v_are = document.getElementById('area').value;
  
  var areas = '<?php echo json_encode($area);?>';

  var area = JSON.parse(areas);

  
   var nombre_a = 0;

   
              

  for (var i = 0; i < area.length; i++) {
  
    
    if(area[i].nombre_area.toLowerCase() === v_are.toLowerCase()){ 
         nombre_a++;
      }
  }


  if(v_are ===""){
    toastr.error( 'Ingrese el nombre del Area','ERROR',{"progressBar": true,"closeButton": false,"preventDuplicates": true
    , "preventOpenDuplicates": true} );
    event.preventDefault();

  }else if(nombre_a> 0){
    toastr.error( 'Esta Area ya existe, favor ingrese una nueva','ERROR',{"progressBar": true,"closeButton": false,"preventDuplicates": true
    , "preventOpenDuplicates": true} );
    event.preventDefault();

  
  }else

  toastr.success( 'Tus datos se guardaron correctamente','BIEN',{"progressBar": true,"closeButton": false} );
  theForm.addEventListener('submit', function (event) {
    });

}

</script>


<!-- FINAL DE LA VALIDACION VENTANA AREA -->




 <!-- INICIO VALIDACION  DE MODAL INGRESAR MOBILIARIO -->
 <script type="text/javascript">
    function validar_mobiliario(){ 

        var v_nombre = document.getElementById('txt_mobi').value;
        var v_cant = document.getElementById('txt_cant').value;
        var v_descrip = document.getElementById('txt_descrip').value;
        var v_depto = document.getElementById('txt_depto').value;
        var v_area = document.getElementById('txt_area').value;
        

          var cadenas_json = '<?php echo json_encode($mobiliario);?>';
          var cadenas = JSON.parse(cadenas_json);
          var nombre = 0;

          
        for (var i = 0; i < cadenas.length; i++) {
          
          console.info(cadenas[i]);

          if(cadenas[i].nombre_depto+ "  "+ cadenas[i].nombre_area === v_depto+"  "+v_area){ 
            nombre++;
          }
          
          }
         var theForm = document.forms['FormMobiliario'];
       

         if(v_area === ""){ 
            toastr.error( 'Favor complete el campo del area','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();

          }else if(v_depto === ""){ 
            toastr.error( 'Favor complete el campo del departamento','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();

           }else if(v_nombre === ""){ 
            toastr.error( 'Favor complete el campo del nombre del mobiliario','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();

           }else if(v_cant === ""){ 
            toastr.error( 'Favor complete el campo de la cantidad','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();

           }else if(v_descrip === ""){ 
            toastr.error( 'Favor complete el campo de descripcion','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();
           }

        
  }
 </script>
    <!-- FIN VALIDACION  DE MODAL INGRESAR MOBILIARIO --> 



 <!--  VALIDACION  DE MODAL EDITAR MOBILIARIO -->  

 <script type="text/javascript">

function validar_actualizar_mobiliario(){ 

        var v_nombre = document.getElementById('mo_mobil').value;
        var v_cant = document.getElementById('mo_cant').value;
        var v_descrip = document.getElementById('mo_descrip').value;
       // var v_depto = document.getElementById('txt_depto').value;
        //var v_area = document.getElementById('txt_area').value; 

    var theForm = document.forms['formulario_actualizar'];
   
   

          if(v_nombre === ""){ 
            toastr.error( 'Favor complete el campo del nombre del mobiliario','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();

           }else if(v_cant === ""){ 
            toastr.error( 'Favor complete el campo de la cantidad','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();

           }else if(v_descrip === ""){ 
            toastr.error( 'Favor complete el campo de descripcion','ERROR',{"progressBar": true,"closeButton": false, "preventDuplicates": true
            , "preventOpenDuplicates": true });
            event.preventDefault();
           }

}
</script>


<!-- FINAL DE LA VALIDACION  DE MODAL EDITAR MOBILIARIO --> 



@endsection

