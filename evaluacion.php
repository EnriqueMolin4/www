<?php require("header.php"); ?>
<div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
   <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
   <i class="fas fa-bars"></i>
   </a>
   <nav id="sidebar" class="sidebar-wrapper">
      <?php include("menu.php") ?>
   </nav>
   <!-- page-content  -->
   <main class="page-content pt-2">
      <body onload="timer();">
         <div id="overlay" class="overlay"></div>
         <div class="page-title">
            <h2>EVALUACIONES TECNICAS</h2>
         </div>
         <div id="timer">
            <div class="container">
               <div id="hour">00</div>
               <div class="divider">:</div>
               <div id="minute">00</div>
               <div class="divider">:</div>
               <div id="second">00</div>
            </div>
            <!--<button class="btn btn-primary" id="btnTimer">Comenzar</button>-->
         </div>
         <div class="container-fluid p-3 panel-white">
            <hr>
            <form id="my_radio_box" action="modelos/evaluacion_db.php">
               <div class="evaluacion">
               </div>
               <div class="mb-3">
                  <input type="hidden" id="user" name="user" value="<?php echo $_SESSION["userid"]; ?>">
                  <button type="button" class="btn btn-success" id="btnSave"> GUARDAR</button>
                  <button type="submit" id="btn_submit" hidden>Hdn</button>
                  <!--    
                     <button value="Guardar" name="btnGuardarRespuestas" id="btnGuardarRespuestas" class="btn btn-primary"> GUARDAR </button>    
                     -->
                  <input type="hidden" id="module" name="module" value="guardar_evaluacion">
               </div>
            </form>
         </div>
      </body>
   </main>
   <!-- page-content" -->
</div>
<!-- page-wrapper -->
<link href="css/style_timer.css" rel="stylesheet" />
<!-- using online scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
   crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
   crossorigin="anonymous"></script>
<script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/moment-with-locales.js"></script>
<script src="js/Chart.bundle.min.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="js/jquery.toaster.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script> 
<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
   $(document).ready(function() {
       
       timer();
       function submitBtn()
       {
           setTimeout(function()
           {
               $('#btn_submit')[0].click(function(){});
           },1000);
   
           $.ajax({
               type: 'POST',
               url: 'modelos/evaluacion_db.php',
               data: {module: 'fin_evaluacion'},
               cache: false,
               success: function(data, textStatus, jqXHR)
               {
   
               },
               error: function(jqXHR, textStatus, errorThrown) 
               {
   
               }
           });
           
       }
   
           $(function(){
               $.ajax({
                   type: 'GET',
                   url: 'modelos/evaluacion_db.php',
                   data: 'module=getPreguntasEv',
                   dataType:'json'
   
                   })
   
               .done(function(data){
   
                   data.forEach(e => {
   
                           var c = ' <div> <br>'
                                   +'<h5>'+e.id+'. <label for="preguntas">'+e.pregunta+'</label></h5>'+'<input hidden type="text" id="preguntas" name="preguntas[]" value="'+e.id+'" />';
                                   c+='<input name="evid[]" id="evaluacionid" type="text"  value="'+e.id_evaluacion+'" hidden>'
                                   c+='<ul>'
                                   e.opciones.forEach(o =>{
                                       c+='<input class="form-check-input" id="radio" type="radio" name="radio['+o.id_pregunta+']" value="'+o.id+'">'
                                       c+='<li class="form-check-label">'+o.respuesta+'</li>'
                                       console.log(e.id, o.id_pregunta);
                                       });
                                   c+='</ul>'
                                   c+='<br>'
                                   
                                   +'</div>';
                               $('.evaluacion').append(c);
                               })
   
                           })
                   })
   
   
           $("#btnSave").on('click', function(){
               
               var radios = [];
               $('input[type="radio"]').each(function()
                       {
                          radios[$(this).attr('name')] = true; 
                       }); 
   
               for(radio in radios)
               {
                   var radio_buttons = $("input[name='" + radio + "']");
   
                    if($('input[name = "'+radio+'" ]:checked').length === 0)
                    {
                       swal.fire({
                           title: 'Haz dejado respuestas en blanco',
                           text: "¿Continuar?",
                           type: 'warning',
                           showCancelButton: true,
                           confirmButtonText: 'Continuar',
                           confirmButtonColor: '#2da645',
                           cancelButtonText: 'Volver',
                           cancelButtonColor: '#D93737',
                           reverseButtons: true
                       }).then((result)=>{
                           if (result.value) 
                           {
                               swal.fire({
                                   position: 'center',
                                   type: 'success',
                                   title: 'Se guardó la evaluación con éxito',
                                   showConfirmButton: true,
                                   timer: 3000
                               });
   
                               //funcion submit
                               submitBtn();
   
                              
                           }
                       })
                    }
   
                    else
                    {
                      swal.fire({
                       title: '¡Gracias por contestar la evaluación!',
                       text: "Se guardarán tus respuestas ¿deseas continuar?",
                       type: 'warning',
                       showCancelButton: true,
                       confirmButtonText: 'Continuar',
                       confirmButtonColor: '#2da645',
                       cancelButtonText: 'Volver',
                       cancelButtonColor: '#D93737',
                       reverseButtons: true
                      }).then((result)=>{
                           if (result.value) 
                           {
                               swal.fire({
                                   position:'center',
                                   type: 'succes',
                                   title: 'Se guardaron tus respuestas',
                                   showConfirmButton: true,
                                   timer: 3000
                               });
                               submitBtn();
   
                           }
                      }) 
                      
                    }
               }
           })
   
   /*
           $("#btnGuardarRespuestas").on('click', function(){
   
                   var respuestas = [];
                   
                  $('input[type="radio"]').each(function()
                   {
                       respuestas[$(this).attr('name')] = true; 
                   }); 
   
                  for (respuesta in respuestas) 
                  {
                       var Opciones = $("input[name='"+ respuesta +"']");
   
                       if ($('input[name = "'+respuesta+'"]:checked').length===0) 
                       {
                           
                       }
                  }
           })
    
       var evaluacion_id = $("#evaluacion").val();
       if (tiempo.hora >= 1) 
                   {
                       
                       //alert('Se terminó el tiempo');
                       Swal.fire(
                         'Se acabó el tiempo',
                         'Se guardará la evaluación',
                         'info'
                       );
                       submitBtn();
                       //clearInterval(tiempo_corriendo);
                       //document.getElementById("radio").disabled = true; 
                   }
   
       $("#btnTimer").click(function(){})
   */ 
   
   
   
   
   
   function timer()
   {
       var tiempo = {
           hora: 0,
           minuto: 0,
           segundo: 0
           };
       var tiempo_corriendo = null;
   
       tiempo_corriendo = setInterval(function(){
   
           //Segundos
           tiempo.segundo++;
           if (tiempo.segundo >= 60) 
           {
               tiempo.segundo = 0;
               tiempo.minuto++;
           }
           
           //Minutos
           if (tiempo.minuto == 30)
           {
               Swal.fire(
                   '¡Tienes 30 minutos para terminar la evaluación!',
                   '',
                   'info'
               )
           }
   
           if (tiempo.minuto >= 60) 
           {
               tiempo.minuto = 0;
               tiempo.hora = 1;
               clearInterval(tiempo_corriendo);
           }
   
           if (tiempo.hora >= 1) 
           {
               clearInterval(tiempo_corriendo);
               Swal.fire(
                 '¡Se ha terminado el tiempo para contestar la evaluación!',
                 'Tus respuestas serán guardadas',
                 'success'
               );
               submitBtn();
           }
   
           $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
           $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);    
           $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
       }, 1000);
   
       save_inicio();
   
   }
   
   function save_inicio()
   {
       $.ajax({
           type: 'POST',
           url: 'modelos/evaluacion_db.php',
           data: {module: 'inicio_evaluacion'},
           cache: false,
           success: function(data, textStatus, jqXHRj)
           {
                   console.log("DONE")
           },
           error: function(jqXHR, textStatus, errorThrown)
           {
               alert("Error");
                       }
           })
   }
   
   
   })
   
   
</script> 
</body>
</html>