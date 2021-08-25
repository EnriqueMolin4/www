function ResetLeftMenuClass(header, subheader, link) {


	//Headers
    $("#menuindex").removeClass("active");
    $("#menucomercios").removeClass("active");
    $("#menualmacen").removeClass("active");
    $("#menuassignacionruta").removeClass("active");
    $("#menuinventarios").removeClass("active");
    $("#menuimagenes").removeClass("active");
    $("#menumapas").removeClass("active");
    $("#menureportes").removeClass("active");
    $("#menucatalogos").removeClass("active");

    //SubHeaders
    $("#comercioSubmenu").css('display','none');
	$("#eventSubmenu").css('display', 'none');
	$("#inventarioSubmenu").css('display', 'none');
	$("#reportSubmenu").css('display', 'none');
	$("#catalogSubmenu").css('display', 'none');
    
    //Links -- Admin
	$("#consultalink").removeClass("active");
	$("#nuevoeventolink").removeClass("active");
	$("#validacionlink").removeClass("active");
	$("#cierreeventolink").removeClass("active");
	$("#tvplink").removeClass("active");
	$("#simlink").removeClass("active");
    $("#insumoslink").removeClass("active");
    $("#repeventoslink").removeClass("active");
    $("#repalmacenlink").removeClass("active");
    $("#reptecnicoslink").removeClass("active");
    $("#catusuarioslink").removeClass("active");
    $("#cattecnicoslink").removeClass("active");
    $("#catcpsegoblink").removeClass("active");
    $("#catcuentabanlink").removeClass("active");
    $("#cataltacplink").removeClass("active");
    $("#catinsumoslink").removeClass("active");
    $("#catcarrierlink").removeClass("active");
    $("#nuevaevaluacionlink").removeClass("active");

    $("#"+header+"").addClass("active");
	$("#"+link+"").addClass("active");
	$("#"+subheader+"").css('display', 'block');

}