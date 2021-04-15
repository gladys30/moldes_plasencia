
<title>Placensia inventario móvil</title>
<link rel="shortcat icon" href="favicon.ico"> 
   
<html lang="es">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<script src="/jquery.js"></script>
<script src="/build/jquery.datetimepicker.full.min.js"></script>
</head>

<div id="content" style="background: url('fondoperron.png') center center no-repeat;
    background-size:100% 100%;">  


<!-- Card de Login -->
<div class="card text-white bg-dark divayudauno " style="width: 30%;height:100%; opacity:.9;position:fixed;right:0px; " >
  <div class="card-body" style= "padding-bottom: 0px">
  
<div class="imagenprincipalpadre3">
<div class="imagenprincipalhijo">
<!-- Imagen LogioPlasencia Dorado
        align= centraliza -->
<div style="text-align:center;" >
<img src="plasenciadorado2.png"style="width: 150px;height:112px;">
</div>

<b> <i> 
<div class="card-header" style= "color:#ead187;text-align:center;">Inventario Movil Plasencia</div> 
</b> </i>
  
  <!-- Ingreso de Usuario-->
    
    </p>
  <div class="mb-3">

  <!-- Icono de Usuario-->
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"  style= "color:#d0b15e";>
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
  </svg>

  <form id = "formulario_login" name = "formulario_login"
 action = "{{Route('autenticacion_usuario',1)}}"  
 method="POST">
 @csrf
    <label for="codigologin" class="form-label"  style= "color:#d0b15e"; > Código Empleado</label>
    <input type="text" class="form-control" id="codigologin" name="codigologin" aria-describedby="emailHelp"placeholder="Ingresa código" required>
   
  </div>
  <div class="mb-3">
  
   <!-- Icono de Contraseña-->
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16"  style= "color:#d0b15e";>
  <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
  <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z"/>
  </svg>




  

    <label for="contrasenialogin" class="form-label" style= "color:#d0b15e";>Contraseña</label>
    <div class="row"style="margin-left:0px;    margin-right: 0px;">



    <div class="input-group ">
     <input type="password" class="form-control" id="contrasenialogin" name="contrasenialogin" placeholder="Ingresa contraseña" required>
   
    <a type="button" class="input-group-text"onclick="mostrarContrasena()" >
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" id="iconovisible" style="position:absolute;">
    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" id="icononovisible"> 
    <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.027 7.027 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.088z"/>
    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6l-12-12 .708-.708 12 12-.708.707z"/>
    </svg>
    </a>
</div>











  </div>

    
  </div>
  <div class="mb-3 form-check">
  
  </div>
  

<!-- Boton de ingreso-->
  <div style="text-align:center;" >
  <button  type= "submit" class="btn-login">Ingresar </button>  
  </div>

  </form>

</p>

  <div style= "text-align:center; position:initial;bottom:0; " >
  <a  class="nav-link" style ="font-size: small" data-toggle="modal" data-target="#modal_recuperarcontraseña">
  ¿Olvidaste tu Contraseña?
 </a>  

 
 </div>
  </div>
  </div>

</div>



    
</div>



















<script>
  function mostrarContrasena(){
      var tipo = document.getElementById("contrasenialogin");
      var iconovisible = document.getElementById("iconovisible");
      var icononovisible = document.getElementById("icononovisible");
      if(tipo.type == "password"){
          tipo.type = "text";      
          icononovisible.style.visibility= "hidden";
      iconovisible.style.visibility= "inherit";
      }else{
          tipo.type = "password";
          icononovisible.style.visibility= "inherit ";
        iconovisible.style.visibility= "hidden";
      }
      
  }
</script>


<!-- Modal RECUPERAR CONTRASENIA -->
<div class="modal fade" id="modal_recuperarcontraseña" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="opacity:.9;background:#212529;">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
      
 <h5 class="modal-title" id="staticBackdropLabel" style="text-align:center;width:100%;">Recuperacion de Contraseña</h5>

<img src="favicon.ico" width="40" height="40" style= "position: absolute" />
  
       
  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form class="form-floating">

        <h7>Al ingresar tu usuario se enviara un correo de recuperación de contraseña de manera automática.   </h7>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
</svg>
      </p>

    
  <input type="email" class="form-control" id="floatingInputValue" placeholder="Ingresa tu Usuario">
  </form>

      </div>
      <div class="modal-footer" >
        <button style=" background: #b39f64; color: #ecedf1;" type="button" class=" btn-info-claro " data-dismiss="modal" >
            <span>Cancelar</span>
        </button>
        <button type="button" class=" btn-info ">
            <span>Enviar</span>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- FIN Modal RECUPERAR CONTRASENIA -->






 <!-- jQuery CDN - Slim version (=without AJAX) -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

