var infoAjax = 0;
$(document).ready(function() {
        
        $(document).on("click","#btnImagenes", function() {
            var odt = $("#odt").val().toUpperCase();
            
            if(odt.length > 0 ) {

                $.ajax({
                    type: 'GET',
                    url: 'modelos/eventos_db.php', // call your php file
                    data: 'module=getConsultaODT&odt='+odt,
                    cache: false,
                    success: function(data){
                        var info = JSON.parse(data);
                
                        if( !jQuery.isEmptyObject(info)  ) {
                            $("#showImagenes").modal({show: true, backdrop: false, keyboard: false});
                            $.ajax({
                                type: 'GET',
                                url: 'modelos/eventos_db.php', // call your php file
                                data: 'module=getImagenesODT&odt='+$("#odt").val(),
                                cache: false,
                                success: function(data){
                                   
                                    var info = JSON.parse(data);
                                    showImagesModal(info);
                                         
                                },
                                error: function(error){
                                    var demo = error;
                                }
                            });
                
                        } else {
                            $.toaster({
                                message: 'No existe la ODT capturada',
                                title: 'Aviso',
                                priority : 'warning'
                            });  
                        }
                    },
                    error: function(error){
                        var demo = error;
                    }
                });

            
            } else {
                $.toaster({
                    message: 'Favor de Capturar una ODT',
                    title: 'Aviso',
                    priority : 'warning'
                });  
            }
        })

        $("#btnSaveImagenes").on("click", function() {
            console.log($("#fileToUpload")[0].files[0])
           $.each($("#fileToUpload")[0].files,function(index, element){
		   
				var odt = $("#odt").val();
				var file_data = $("#fileToUpload")[0].files[index];
				var form_data = new FormData();
				form_data.append('file', file_data);
				form_data.append('name',odt);
				form_data.append('module','saveImage');

				$.ajax({
					type: 'POST',
					url: 'modelos/eventos_db.php', // call your php file
					data: form_data,
					processData: false,
					contentType: false,
					success: function(data, textStatus, jqXHR){
						//$("#avisos").html(data);
						$.toaster({
							message: data,
							title: 'Aviso',
							priority : 'warning'
						});  
						
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(data)
				   }
				 });
			})
			
			$("#fileToUpload").val("");
            
        })

        $('#showImagenes').on('show.bs.modal', function (e) {

        })

        $(document).on('click','.showImagen', function() {
            var info = $(this).attr('data');
            var path = $(this).attr('data').split('|');
            
            var img = '<img src="'+path[0]+'" width="100%"><button class="btn btn-danger" id="btnDelImg" name="brnDelImg" data="'+info+'">Borrar</button>';
            $("#imagenSel").html(img);
        })

        $(document).on('click','#btnDelImg', function() {
              var odt = $(this).attr('data').split('|');
              $.ajax({
                  type: 'POST',
                  url: 'modelos/eventos_db.php', // call your php file
                  data: {module:'borrarImagen',odt:odt[1],imagen:odt[0] },
                  cache: false,
                  success: function(data, textStatus, jqXHR){
                      //$("#avisos").html(data);
                      $.toaster({
                          message: data,
                          title: 'Aviso',
                          priority : 'warning'
                      });  
                      $("#carruselFotos").html("");
                      $("#imagenSel").html("");
                      showImagesModal(info);
                      
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert(data)
                 }
               });

              
            })

        $('#showImagenes').on('hide.bs.modal', function (e) {
            $("#imagenSel").html("");
            $("#carruselFotos").html("")
        });
        
    } );

    
      function initMap() {
         
      }


function showImagesModal(info) {
  var texto = "";
  if(info['estatus'] == '1') {
      $.each(info['imagenes'], function(index, element) {
       
          texto = texto + '<div class="imagewrap"><a href="#" class="showImagen" data="'+element.path+'|'+element.odt+'"><img src="'+element.path+'" width="100%"></a></div> '

      })

      $("#carruselFotos").html(texto);
  } else {
    
      $.toaster({
        message: 'LA ODT NO TIENE IMAGENES REGISTRADAS',
        title: 'Aviso',
        priority : 'warning'
    });  
  }
}
function cleartext() {
    $("#cvebancaria").val("")
    $("#comercio").val("")
    $("#propietario").val("")
    $("#estado").val("");
    $("#responsable").val("")
    $("#tipo_comercio").val("");
    $("#ciudad").val("")
    $("#colonia").val("")
    $("#afiliacion").val("")
    $("#telefono").val("")
    $("#direccion").val("");
    $("#rfc").val("")
    $("#email").val("")
    $("#email_ejecutivo").val("")
    $("#territorial_banco").val("")
    $("#territorial_sinttecom").val("")
    $("#hora_general").val("")
    $("#hora_comida").val("")
    $("#razon_social").val("")
    $("#cp").val("")

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

          var count = document.getElementById('fileToUpload').files.length;

          for (var index = 0; index < count; index ++)

          {

                 var file = document.getElementById('fileToUpload').files[index];

                 fd.append(file.name, file);

          }

    var xhr = new XMLHttpRequest();

    xhr.upload.addEventListener("progress", uploadProgress, false);

    xhr.addEventListener("load", uploadComplete, false);

    xhr.addEventListener("error", uploadFailed, false);

    xhr.addEventListener("abort", uploadCanceled, false);

    xhr.open("POST", "savetofile.aspx");

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

