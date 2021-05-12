$(document).ready(function() {

    mostrarImagenes( $("#odt").val() );

})

function mostrarImagenes(odt) {
    $("#carruselFotos").html('')
    $("#btnValidarImagen").data('id','0');
    
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: 'module=getImagenesODT&odt='+odt ,
        cache: false,
        success: function(data){
            var texto = '<div class="row">';
            var info = JSON.parse(data);
            var locacion = window.location;
            if(info['estatus'] == '1') {
                $.each(info['imagenes'], function(index, element) {
                    
                    texto = texto + '<div class="col-4"><img src="'+locacion.origin+'/'+element.path+'" width="90%" class="zoomImgs"><button class="btn btn-primary button1 btnDelImage" data= "'+element.id+'">Borrar</button></div>'

                })

                texto = texto + "</div>";
                $("#carruselFotos").html(texto);
                zoomifyc.init($('#carruselFotos img'));
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

$(document).on('click','.btnDelImage', function() {
    var idImg = $(this).attr('data');
    $.ajax({
        type: 'GET',
        url: 'modelos/eventos_db.php', // call your php file
        data: { module: 'imgDelete',idImg: idImg },
        cache: false,
        success: function(data){
            if(data == "1") {
                $.toaster({
                    message: 'Se borro con exito la imagen ',
                    title: 'Aviso',
                    priority : 'success'
                });  
                mostrarImagenes($("#odt").val())
            }
        }
    });
})