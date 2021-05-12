      $(document).ready(function() {
        /* $("#formVO").validate({
          rules: {
            comentarios: "required",
            referencia1Nombre: "required",
            referencia1Tiempo: "required",
            referencia1TiempoResidencia: "required",
            referencia1Empresa: "required"

          },
          messages: {
            comentarios: "Favor de llenar comentarios",
            referencia1Nombre: "Favor de llenar",
            referencia1Tiempo: "Favor de llenar",
            referencia1TiempoResidencia: "Favor de llenar",
            referencia1Empresa: "Favor de llenar"
          },
          submitHandler: function(form) {
            saveEvento()
          },
          errorPlacement: function(error,element){ 
            //error.insertAfter(element); 
            //use error.html() as content in your popup div or simply
             
            $.toaster({
              message: error.html(),
              title: 'Aviso',
              priority : 'warning'
            });             
         }
      
        }) */
        
        $.ajax({
            type: 'GET',
            url: '../modelos/eventos_db.php', // call your php file
            data: 'module=getDetalleEvento&eventoId='+$("#eventoId").val(),
            success: function(data, textStatus, jqXHR){
                var info = JSON.parse(data)
                var html = "";
                getLocation();
                $.each(info, function(index,element) {
                  var formulario = JSON.parse(element.formulario)
                   $("#folio").html(element.folio);
                   $("#odt").val(element.odt);
                   $("#nombre").val(element.comercioNombre);
                   $("#calle").val(element.direccion);
                   $("#colonia").val(element.colonia);
                   $("#municipio").val(element.municipioNombre);
                   $("#estado").val(element.estadoNombre);
                  $("#formularioId").val(element.formularioId);
                  //Registro de Visita
                  $("#tipozona").val(formulario.tipozona);
                  $("#tipodomicilio").val(formulario.tipodomicilio);
                  $("#personacontactada").val(formulario.personacontactada);
                  $("#personaContacto").val(formulario.personaContacto);
                  $("#relacionCliente").val(formulario.relacionCliente);
                  $("#identificacion").val(formulario.identificacion);
                  $("#noIdentificacion").val(formulario.noIdentificacion);
                  $("#sincontacto").val(formulario.sincontacto);
                  //Referencia 1
                  $("#referencia1Nombre").val(formulario.referencia1Nombre);
                  $("#referencia1Tiempo").val(formulario.referencia1Tiempo);
                  $("#referencia1EstadoCivil").val(formulario.referencia1EstadoCivil);
                  $("#referencia1Empresa").val(formulario.referencia1Empresa);
                  $("#referencia1PagarCredito").val(formulario.referencia1PagarCredito);
                  $("#referencia1Recomendacion").val(formulario.referencia1Recomendacion);
                  //Referencia 2
                  $("#referencia2Nombre").val(formulario.referencia2Nombre);
                  $("#referencia2Tiempo").val(formulario.referencia2Tiempo);
                  $("#referencia2EstadoCivil").val(formulario.referencia2EstadoCivil);
                  $("#referencia2Empresa").val(formulario.referencia2Empresa);
                  $("#referencia2PagarCredito").val(formulario.referencia2PagarCredito);
                  $("#referencia2Recomendacion").val(formulario.referencia2Recomendacion);
                  // Datos de Empleo
                  $("#datosempleoNombre").val(formulario.datosempleoNombre);
                  $("#datosempleoPuesto").val(formulario.datosempleoPuesto);
                  $("#datosempleoTiempoLaborar").val(formulario.datosempleoTiempoLaborar);
                  //Comentarios
                  $("#comentario").val(formulario.comentario);

                });

                $("#list-event").html(html);
                getImages();
                getDocs();
               
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
           }
         });

        $("#btnFinEvento").on("click",function(event) {
          event.preventDefault()
            saveEvento();
        })
        


})

function getImages() {
    $.ajax({
        type: 'GET',
        url: '../modelos/eventos_db.php', // call your php file
        data: 'module=getImagesbyEvento&odt='+$("#odt").val()+"&tipo=1",
        success: function(data, textStatus, jqXHR){
            var info = JSON.parse(data)
            var html = "";
           
            $.each(info, function(index,element) {
               html += "<img src='../img/"+$("#odt").val()+"/"+element.dir_img+"' height='150px' width='150px'>";
    

            });

            $("#listImages").html(html);
           
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(data)
       }
     });
}

function getDocs() {
    $.ajax({
        type: 'GET',
        url: '../modelos/eventos_db.php', // call your php file
        data: 'module=getImagesbyEvento&odt='+$("#odt").val()+"&tipo=2",
        success: function(data, textStatus, jqXHR){
            var info = JSON.parse(data)
            var html = "<small class='form-text text-muted'>Documentos Precargados</small><div class='row'>";
           
            $.each(info, function(index,element) {
               html += "<div class='col-sm'><a href='../docs/"+$("#odt").val()+"/"+element.dir_img+"' download><small>"+element.dir_img+" </small><img src='../images/pdf-icon.png' height='30' width='20'></a></div>";
    

            });
              html += "</div></div>";
            $("#listDocs").html(html);
           
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(data)
       }
     });
}

function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }
  
  function showPosition(position) {
    $("#latitude").val(position.coords.latitude); 
    $("#longitude").val(position.coords.longitude);
  }

  function saveEvento() {
    var form = document.getElementById('formVO');
    var dataForm = new FormData( form ) 
    $.ajax({
        processData: false, 
        contentType: false,
        type: 'POST',
        url: '../modelos/eventos_db.php', // call your php file
        data: dataForm,
        success: function(data, textStatus, jqXHR){
          $.toaster({
            message: "Se grabo con exito",
            title: 'Aviso',
            priority : 'success'
          });   

          window.location.replace("https://sinttecom.net/sinttecom/mobile/index.html");
          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(data)
      }
    });
  }
  function fileSelected() {

    var count = document.getElementById('fileToUpload').files.length;
 
          document.getElementById('details').innerHTML = "";
 
          for (var index = 0; index < count; index ++)
 
          {
 
                 var file = document.getElementById('fileToUpload').files[index];
 
                 var fileSize = 0;
 
                 if (file.size > 1024 * 1024)
 
                        fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
 
                 else
 
                        fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
 
                 document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
 
                 document.getElementById('details').innerHTML += '<p>';
 
          }
 
  }
 
  function uploadFile() {
 
    var fd = new FormData();
    var odt = document.getElementById('odt').value;
 
          var count = document.getElementById('fileToUpload').files.length;
 
          for (var index = 0; index < count; index ++)
 
          {
 
                 var file = document.getElementById('fileToUpload').files[index];
 
                 fd.append('file', file);
                 fd.append('name',odt);
                 fd.append('module','saveImage');
 
          }
 
    var xhr = new XMLHttpRequest();
 
    xhr.upload.addEventListener("progress", uploadProgress, false);
 
    xhr.addEventListener("load", uploadComplete, false);
 
    xhr.addEventListener("error", uploadFailed, false);
 
    xhr.addEventListener("abort", uploadCanceled, false);
 
    xhr.open("POST", "../modelos/eventos_db.php");
 
    xhr.send(fd);
 
  }
 
  function uploadProgress(evt) {
 
    if (evt.lengthComputable) {
 
      var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 
      document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
 
    }
 
    else {
 
      document.getElementById('progress').innerHTML = 'unable to compute';
 
    }
 
  }
 
  function uploadComplete(evt) {
 
    /* This event is raised when the server send back a response */
 
    alert(evt.target.responseText);
 
  }
 
  function uploadFailed(evt) {
 
    alert("There was an error attempting to upload the file.");
 
  }
 
  function uploadCanceled(evt) {
 
    alert("The upload has been canceled by the user or the browser dropped the connection.");
 
  }