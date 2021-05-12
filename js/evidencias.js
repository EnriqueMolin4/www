$(document).ready(function() {
    ResetLeftMenuClass("submenueventos", "ulsubmenueventos", "evidenciaslink")

    $("#btnBuscar").on('click', function() {

        mostrarImagenes( $("#evidencia_odt").val() )
    })

    $("#btnDescargar").on('click', function() {

        downloadImages();
    })
    
       

});

function mostrarImagenes(odt) {
    $("#carruselFotos").html('')
    $("#btnValidarImagen").data('id','0');
    $("#imagenSel").html('');

    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getImagenesODT&odt='+odt,
        cache: false,
        success: function(data){
            var texto = "<table><tr>";
            var info = JSON.parse(data);
            var locacion = window.location;
            if(info['estatus'] == '1') {
                var counter = 0
                $.each(info['imagenes'], function(index, element) {
                    if(counter <= 5 ) {
                        texto = texto + '<td><div class="checkbox"><label><input type="checkbox" value="'+locacion.origin+'/sinttecomdev/'+element.path+'"></label> </div><a href="#" class="showImagen" data="'+element.id+'|'+locacion.origin+'/sinttecomdev/'+element.path+'"><img src="'+locacion.origin+'/sinttecomdev/'+element.path+'" width="60%"></a></div> '
                        counter++;
                    } else {
                        texto += '<td><div class="checkbox"><label><input type="checkbox" value="'+locacion.origin+'/sinttecomdev/'+element.path+'"></label> </div><div class="imagewrap"><a href="#" class="showImagen" data="'+element.id+'|'+locacion.origin+'/sinttecomdev/'+element.path+'"><img src="'+locacion.origin+'/sinttecomdev/'+element.path+'" width="60%"></a></div></td> '
                        text += '</tr>'
                    }
                })

                texto += "</table>";
                $("#carruselFotos").html(texto);
            } else {
            
                $.toaster({
                    message: 'LA ODT NO TIENE IMAGENES REGISTRADAS',
                    title: 'Aviso',
                    priority : 'danger'
                });      
            }
                    
            
        },
        error: function(error){
            var demo = error;
        }
    });
}

function downloadImages() {
    var selected = [];
    $('#checkboxes input:checked').each(function() {
       // selected.push($(this).attr('value'));
       //window.location.href = $(this).attr('value');
       downloadFile( $(this).val() );
    });
    alert(selected);
}

function downloadFile(filePath){
    var link=document.createElement('a');
    link.href = filePath;
    link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
    link.click();
}
      	  





