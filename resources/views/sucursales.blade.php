@extends('principal')


@section('content')




<div class="col">

        <div class="row">           

                <div class="col"> 
                <div class="card border-dark mb-3"style="width: 100%;">
                <img src="sucursalParaiso.png" class="card-img-top" alt="Sucursal El Paraíso"  style=" height:10rem; -webkit-filter: brightness(50%);filter: brightness(50%);">
                <div class="card-body">
                <form action=  "{{Route('id_planta_inventario',1)}}" method= "POST">
                @csrf
                <button type="submit"  class="btn-info" style="width:100%;" >Sucursal <br>  El Paraíso</button> 
                </form>  
                </div>
                </div>
                </div>

                <div class="col"> 
                <div class="card border-dark mb-3" style="width: 100%;">
                <img src="sucursalMoroceli.png" class="card-img-top" alt="Sucursal Morocelí" style=" height:10rem; -webkit-filter: brightness(50%);filter: brightness(50%);">
                <div class="card-body">
                <form action=  "{{Route('id_planta_moroceli',2)}}" method= "POST">
                @csrf
                <button type="submit"  class="btn-info" style="width:100%;" >Sucursal <br> Morocelí</button> 
                </form>   
                </div>
                </div>  
                </div>
 
                </div>               

      </div>


      <div class="col">


        <div class="row">



        <div class="col">
                 <div class="card border-dark mb-3" style="width: 100%;">
                <img src="sucursalSanMarcos.png" class="card-img-top" alt="Sucursal San Marcos" style=" height:10rem; -webkit-filter: brightness(50%);filter: brightness(50%);">
                <div class="card-body">
                <form action=  "{{Route('id_planta_sanMarcos',3)}}" method= "POST">
                @csrf
                <button type="submit"  class="btn-info" style="width:100%;" >Sucursal <br>  San Marcos</button> 
                </form> 
                </div>
                </div> 
                </div> 

                    




                <div class="col"> 
                <div class="card border-dark mb-3" style="width: 100%;">
                <img src="sucursalGualiqueme.png" class="card-img-top" alt="Sucursal Gualiqueme" style=" height:10rem; -webkit-filter: brightness(50%);filter: brightness(50%);">
                <div class="card-body">
                <form action=  "{{Route('id_planta_gualiqueme',4)}}" method= "POST">
                @csrf
                <button type="submit"  class="btn-info" style="width:100%;" >Sucursal <br>  Gualiqueme</button> 
                </form> 
                </div>
                </div>                
                </div>


          

    </div>

    </div>





@endsection