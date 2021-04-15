@extends('principal')


@section('content')
          
<!-- Libreria de las alertas -->
<script src= "{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css') }}">

<!-- INICIO DEL TABLA REMISIONES PARAISO -->



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
            <th style='text-align: center;' scope="col">Fecha</th>
            <th style='text-align: center;' scope="col">De</th>
            <th style='text-align: center;' scope="col">Para</th>
            <th style='text-align: center;' scope="col">Estado</th>   
            <th style='text-align: center;' scope="col">Tipo de molde</th>   
            <th style='text-align: center;' scope="col">Cantidad</th>            
         </thead>
         <tbody>
        
         @foreach($moldes as $molde)
            <tr> 
                <td>{{$molde->fecha}}</td>
                <td>{{$molde->nombre_planta}}</td>
                <td>{{$molde->nombre_fabrica}}</td>
                <td>{{$molde->estado_moldes}}</td>
                <td>{{$molde->tipo_moldes}}</td>
                <td>{{$molde->cantidad}}</td>
              
            </tr>

            @endforeach 
             
           
          <tbody>
    </table>
<!-- FIN DEL TABLA REMISIONES PARAISO -->




@endsection