@extends('principal')


@section('content')
          
<!-- Libreria de las alertas -->
<script src= "{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css') }}">

<!-- INICIO DEL TABLA REMISIONES PARAISO -->


  <nav class="navbar navbar-expand-lg navbar-light bg2" >
  <div class="container-fluid">   
    <div class="collapse navbar-collapse" id="navbarNav">

                


                    <ul class="navbar-nav nav ">
                    <li class="nav-item active">
                    <a style="background:#b38d1d;" class="nav-link  mr-sm-2 download"  onclick="enviadas()" id="a_enviadas"  >Enviadas</a>
                    </li>
                    <li class="nav-item">
                    <a style="background:#b39f64;" class="nav-link mr-sm-2  download" onclick="recibidas()" id="a_recibidas" >Recibidas</a>
                    </li>  
                    <li class="nav-item">
                    <a style="background:#b39f64;" class="nav-link download" data-toggle="modal" data-target="#modal_enviarmoldes_paraiso"  >Enviar Moldes</a>
                  </li>   
                    </ul>
    
    </div>
  </div>
</nav>

<script type="text/javascript">    

      function enviadas(){  
      var tablaenviadas = document.getElementById("tablaenviadas"); 
      var tablarecibidas = document.getElementById("tablarecibidas"); 
      var a_enviadas = document.getElementById("a_enviadas"); 
      var a_recibidas = document.getElementById("a_recibidas"); 
     
      tablaenviadas.style.display = 'inline-table'; 
      tablarecibidas.style.display = 'none'; 
      a_enviadas.style.background = '#b38d1d'; 
      a_recibidas.style.background = '#b39f64';       
      }


      function recibidas(){  
      var tablaenviadas = document.getElementById("tablaenviadas"); 
      var tablarecibidas = document.getElementById("tablarecibidas"); 
      var a_enviadas = document.getElementById("a_enviadas"); 
      var a_recibidas = document.getElementById("a_recibidas");        
      tablaenviadas.style.display = 'none'; 
      tablarecibidas.style.display = 'inline-table';  
      a_enviadas.style.background = '#b39f64'; 
      a_recibidas.style.background = '#b38d1d';        
      }    
 </script>

<table class="table table-striped table-secondary table-bordered border-primary " id="tablaenviadas">
        <thead class= "table-dark">
        <tr>
            <<th style='text-align: center;' scope="col">Fecha</th>
            <th style='text-align: center;' scope="col">Para</th>
            <th style='text-align: center;' scope="col">Estado</th>   
            <th style='text-align: center;' scope="col">Tipo de molde</th>   
            <th style='text-align: center;' scope="col">Cantidad</th>            
                   
         </thead>
         <tbody>
        
         @foreach($remisionesenviadas as $remision)
            <tr> 
                <td>{{$remision->fecha}}</td>
                <td>{{$remision->nombre_fabrica}}</td>
                <td>{{$remision->estado_moldes}}</td>
                <td>{{$remision->tipo_moldes}}</td>
                <td>{{$remision->cantidad}}</td>
              
            </tr>

            @endforeach 
             
           
          <tbody>
    </table>
<!-- FIN DEL TABLA REMISIONES PARAISO -->




<table class="table table-striped table-secondary table-bordered border-primary " id="tablarecibidas" style="display:none;">
        <thead class= "table-dark">
        <tr>
        <th style='text-align: center;'  scope="col" >Fecha</th>
            <th style='text-align: center;'  scope="col">De</th>
            <th style='text-align: center;' scope="col">Estado</th>   
            <th style='text-align: center;' scope="col">Tipo de molde</th>   
            <th style='text-align: center;' scope="col">Cantidad</th>    
            <th style='text-align: center;' scope="col">Confirmar</th>            
        </tr>        
         </thead>
         <tbody>
        
         @foreach($remisionesrecibidas as $remision)
         <?php if ($remision->chequear == 0): ?>
         
         <tr > 
  
         <tr>  
                <td>{{$remision->fecha}}</td>
                <td>{{$remision->nombre_planta}}</td>
                <td>{{$remision->estado_moldes}}</td>
                <td>{{$remision->tipo_moldes}}</td>
                <td>{{$remision->cantidad}}</td>
                <td class="table-warning" style="padding:0px; text-align:center;    vertical-align: inherit;" >
                <a data-toggle="modal" data-target="#modal_confirmar_remision" onclick ="datos_remisiones({{ $id_remision_basico = $remision->id_remision }})">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" class="bi bi-check-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                </svg>
                  </a>
                </td>
              
            </tr>
            <?php else:; ?>

            <tr > 
                <td>{{$remision->fecha}}</td>
                <td>{{$remision->nombre_planta}}</td>
                <th scope="col">Estado</th>   
                <th scope="col">Tipo de molde</th>  
                <td>{{$remision->cantidad}}</td>   
                <td style="text-align:center;" class="table-success">  Chequeado</td>
              
            </tr>

            <?php endif; ?>
            @endforeach 

             
           
          <tbody>
    </table>
<!-- FIN DEL TABLA REMISIONES PARAISO -->



<script type="text/javascript">

function datos_remisiones(id){ 
var datas = '<?php echo json_encode($remisionesrecibidas);?>';
console.info(datas);
var data = JSON.parse(datas);

 


var datas_re = '<?php echo json_encode($remisionesrecibidas);?>';
console.info(datas_re);
var data_remi = JSON.parse(datas_re);



for (var i = 0; i < data_remi.length; i++) {  
  if(data_remi[i].id_remision === id){ 
    document.formulario_mostrar.nombre_recibido.value = data_remi[i].nombre_planta;

  }

}

var datas_id = '<?php echo json_encode($moldes);?>';
console.info(datas_id);
var data_i = JSON.parse(datas_id);


for (var i = 0; i < data_i.length; i++) {  
  if(data_i[i].fivi === document.getElementById('id_tipo').value){ 
    document.formulario_mostrar.id_molde.value = data_i[i].id_molde;

  }

}
for (var i = 0; i < data.length; i++) {  
  if(data[i].id_remision === id){  
     document.formulario_mostrar.txt_id_remision.value = data[i].id_remision;
     document.formulario_mostrar.txt_id_planta.value = data[i].id_planta;
     document.formulario_mostrar.txt_nombre_fabrica.value = data[i].nombre_fabrica;
     document.formulario_mostrar.txt_estado_moldes.value = data[i].estado_moldes;  
     document.formulario_mostrar.txt_tipo_moldes.value = data[i].tipo_moldes;  
     document.formulario_mostrar.cantidad.value = data[i].cantidad;  
     document.formulario_mostrar.txt_chequear.value = data[i].chequear;        
    }

}



    }   
  
</script>



<!-- INICIO MODAL CHEQUEAR REMISION -->
<form id = "formulario_mostrar" name = "formulario_mostrar"
 action = "{{Route('actualizarremision_sanMarcos',3)}}"  
 method="POST">

@csrf
<?php use App\Http\Controllers\sucursal_sanMarcos; ?>
<div hidden>{{$id_remision_basico=0}}</div>
  
<input name = "id_usuarioE" id="id_usuarioE" value ="" hidden />

<div class="modal fade" id="modal_confirmar_remision" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmación de Remisión</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<input name = "txt_id_remision" id="txt_id_remision" value ="" hidden />
<input name = "txt_id_planta" id="txt_id_planta" value ="" hidden />
<input name = "txt_nombre_fabrica" id="txt_nombre_fabrica" value ="" hidden />
<input name = "txt_estado_moldes" id="txt_estado_moldes" value ="" hidden />
<input name = "txt_tipo_moldes" id="txt_tipo_moldes" value ="" hidden />
<input name = "cantidad" id="cantidad" value ="" hidden />
<input name = "txt_chequear" id="txt_chequear" value ="" hidden />
<input name = "id_molde" id="id_molde" value ="" hidden />
<input name = "nombre_recibido" id="nombre_recibido" value ="" hidden />
      ¿Estás seguro que la transacción coincide con la remisión?
      </div>
      <div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
        </button>
        <button type="submit" class=" btn-info "   >
            <span>Confirmar</span>
        </button>
      </div>
    </div>
  </div>
</div>
</form>


<!-- FIN MODAL CHEQUEAR REMISION -->






<!-- INICIO DEL MODAL ENVIAR MOLDES -->
<form action=  "{{Route('insertarremisiones_sanMarcos',3)}}" method= "POST" id ="FormRemisiones" name="FormRemisiones">
@csrf
<div class="modal fade" role="dialog" id="modal_enviarmoldes_paraiso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;width=800px;">
  <div class="modal-dialog modal-dialog-centered modal-xl"  style="opacity:.9;background:#212529;width=80%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Enviar moldes</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" ></button>
      </div>
     
      <div class="modal-body">
          <div class="card-body">  
            

    

                            <div class="row">
                                
                       
                                <div class="mb-3 col">
                                
                                <input name="id_planta"  id="id_planta" value="3" style="display:none">
                                <input name="chequear"  id="chequear" value="0" style="display:none">
                                <label for="txt_sucursales" class="form-label">Para</label>
                                <select class="form-control"   id="txt_sucursales"  name="txt_sucursales" onchange="showDiv('hidden_div', this)" placeholder="Selecciona la sucursal" required >
                            
                             
                                <option value =  "Paraíso Cigar" >El Paraíso</option>
                                <option value =  "Morocelí" >Moroceli</option>
                                <option value =  "Gualiqueme" >Gualiqueme</option>
                                <option value =  "5" >Otra Fabrica</option>                      
                                </select> 
                                </div>
                               
                             

                                <div style="display:none;" class="mb-3 col" id="hidden_div">
                                <label for="txt_otra_fabrica" class="form-label">Otra empresa</label>
                                <input   class="form-control" type= "text" id="txt_otra_fabrica" name="txt_otra_fabrica" placeholder="Ingresa el nombre" minLength="1"  >
                                </div>

                                <div class="mb-3 col">
                                <label for="txt_estado" class="form-label">Estado</label>
                                <select class="form-control"   id="txt_estado"  name="txt_estado" placeholder="Selecciona la sucursal"  required>
                                <option value =  "Buenos" >Buenos</option>
                                <option value =  "Irregulares" >Irregulares</option>                   
                                </select> 
                                </div>

                                <div class="mb-3 col">
                                <label for="id_tipo" class="form-label">Tipo moldes</label>
                                <select class="form-control"   id="id_tipo"  name="id_tipo" placeholder="Selecciona la sucursal"  required>
                                @foreach($moldes as $molde)
                                <option value =  "{{$molde-> fivi}}" >{{$molde-> fivi}}</option>
                                @endforeach                     
                                </select> 
                                </div>


                         

                                <div class="mb-3 col">
                                <label for="txt_cantidad" class="form-label">Cantidad</label>
                                <input class="form-control" type= "number" id="txt_cantidad" name="txt_cantidad" placeholder="Ingresa la cantidad" minLength="1" maxLength="10" required>
                                </div>


                            </div>

</div>
</div>

<div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
        </button>
        <button  class=" btn-info " onclick="agregarremision()" >
            <span>Guardar</span>
        </button>

        
      </div>
    </div>
  </div>
</div>

</form>


<script>
  function showDiv(divId, element){
   document.getElementById(divId).style.display = element.value == 5 ? 'block'  : 'none' ;   
   document.getElementById(divId).value = element.value == 5 ? '1' : '2' ;
}
</script>


<script>

function agregarremision(){  
  var empresa = document.getElementById('txt_otra_fabrica').value ;
  var select = document.getElementById('txt_sucursales').value ;

  var cantidad_input = document.getElementById('txt_cantidad').value ;
  
  var theForm = document.forms['FormRemisiones'];



  

  var bodegas = '<?php echo json_encode($bodega);?>';
  var bodega = JSON.parse(bodegas);
  var cantidad = 0;


  for (var i = 0; i < bodega.length; i++) {

    if(bodega[i].fivi === document.getElementById('id_tipo').value){ 
      cantidad = bodega[i].bodega;
      
      
    }
}


if(cantidad_input > cantidad){
            toastr.error( 'Esta cantidad supera a la de su inventario','ERROR',{"progressBar": true,"closeButton": false,"preventDuplicates": true
            , "preventOpenDuplicates": true} );
            event.preventDefault();

  }else if( empresa =="" && select == "5"){
            toastr.error( 'Ingresa el nombre de la empresa','ERROR',{"progressBar": true,"closeButton": false,"preventDuplicates": true
            , "preventOpenDuplicates": true} );
            event.preventDefault();
  }else  
  theForm.addEventListener('submit', function (event) { });


   }

</script>



<!-- FIN DEL MODAL AGREGAR MOLDE-->

@endsection