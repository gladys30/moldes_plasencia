
@extends('principal')


@section('content')



<table class="table table-striped table-secondary table-bordered border-primary ">
        <thead class= "table-dark">
        <tr>
            
            <th scope="col">Figura y tipo</th>
            <th scope="col">Buenos</th>
            <th scope="col">Irregulares</th>
            <th scope="col">Malos</th>
            <th scope="col">Bodega</th>
            <th scope="col">Reparación</th>
            <th scope="col">Salón</th>
            <th scope="col">Total</th>
            
         </tr>
            
         </thead>
         <tbody>

       


         @foreach($totales as $total)
        
            <tr> 
           
                  <td> {{$total->figura_vitola}}</td> 
                  <td>{{$total->total_bueno}}</td>
                  <td>{{$total->total_irregulares}}</td>
                  <td>{{$total->total_malo}}</td>
                  <td>{{$total->total_bodega}}</td>
                  <td>{{$total->total_repacion}}</td>
                  <td>{{$total->total_salon}}</td>
                  <td>{{$total->total_bueno+$total->total_irregulares+ $total->total_malo}}</td>
          
             </tr>
             @endforeach
             <tr>
            <td ><strong>Sumatoria total moldes plasencia</strong></td>          
             <td>
            
                <?php
                $suma_b=0;
                foreach ($totales as $total)
                 {
                  $suma_b+=$total->total_bueno;
                }
                
                ?>   {{$suma_b}}    </td>
            <td>
              <?php
               $suma_i=0;
               foreach ($totales as $total)
                 {
                  $suma_i+=$total->total_irregulares;
                }
                ?>   {{$suma_i}}</td>
            <td>
            <?php
             $suma_m=0;
             foreach ($totales as $total)
                 {
                  $suma_m+=$total->total_malo;
                }
                ?>   {{$suma_m}}
            </td>
            <td>
            <?php
            $suma_bo=0;
            foreach ($totales as $total)
                 {
                  $suma_bo+=$total->total_bodega;
                }
                ?>   {{$suma_bo}}
            </td>
            <td>
            <?php
            $suma_r=0;
            foreach ($totales as $total)
                 {
                  $suma_r+=$total->total_repacion;
                }
                ?>   {{$suma_r}}
            </td>
            <td>
            <?php
            $suma_s=0;
            foreach ($totales as $total)
             {
                  $suma_s+=$total->total_salon;
                }
                ?>   {{$suma_s}}
            </td>
            <td>
            <?php
            $suma_total=0;
            foreach ($totales as $total)
                 {
                  $suma_total = $suma_b+$suma_m+$suma_i ;
                 }
                ?>   {{$suma_total}}
            </td>
            </tr>
          <tbody>
    </table>



@endsection