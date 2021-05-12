$(document).ready(function() {
    $('#loading').modal('show')
        
        $.ajax({
            type: 'GET',
            url: '../modelos/eventos_db.php', // call your php file
            data: 'module=getEventobyTecnico',
            success: function(data, textStatus, jqXHR){
                var info = JSON.parse(data)
                var html = "";
                $.each(info, function(index,element) {
                    var check = element.existeFormulario == '1' ? "<span style='color: green;'><i class='far fa-check-circle'></i></span>" : "";
                    html += "<a href='detalleEvento.php?evento="+element.id+"' class='list-group-item list-group-item-action '>";
                    html += "<div class='d-flex w-100 justify-content-between'>";
                    html += "<h5 class='mb-1'>"+element.comercioNombre+"</h5>";
                    html += "<small>Folio "+element.folio+"  ODT "+element.odt+"</small>"+check
                    html += "</div>"
                    html += "<p class='mb-1'>"+element.direccion+" "+element.colonia +"</p>"
                    html += "<small>Ticket: "+element.ticket+"</small>"
                    html += "</a>"

                });

                $("#list-event").html(html);
                $('#loading').modal('hide')
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(data)
           }
         });
        
    

})