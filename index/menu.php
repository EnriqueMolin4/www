<ul class="list-unstyled components">
<?php if($_SESSION['tipo_user'] == 'VO') { ?>
	<li>
		<a href="#eventSubmenu" id="menueventos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-calendar-alt"></i> EVENTOS</a>
		<ul class="collapse list-unstyled" id="eventSubmenu">
			<li>
				<a href="#" id="consultalink" onclick="cargar_doc(this);" data-seccion="CONSULTAEVENTOS"><i class="fas fa-clipboard"></i> CONSULTA</a>
			</li>
			<li>
				<a href="#" id="nuevoeventolink" onclick="cargar_doc(this);" data-seccion="NUEVOEVENTO"><i class="fas fa-clipboard"></i> NUEVO EVENTO</a>
			</li>
			<li>
				<a href="#" id="menuassignacionruta" onclick="cargar_doc(this);" data-seccion="ASSIGNACIONRUTA"><i class="fas fa-map-marked-alt"></i> ASIGNACION RUTA</a>
			</li>
			<li>
				<a href="#" id="validacionlink" onclick="cargar_doc(this);" data-seccion="VALIDACIONES"><i class="fas fa-clipboard-check"></i> VALIDACION</a>
			</li>
			<li>
				<a href="#" id="cierreeventolink" onclick="cargar_doc(this);" data-seccion="CERRAREVENTO"><i class="fas fa-window-close"></i> CIERRE EVENTOS</a>
			</li>
      <li>
				<a href="#" id="visitaocularlink" onclick="cargar_doc(this);" data-seccion="VISITAOCULAR"><i class="fas fa-eye"></i> VISITA OCULAR</a>
			</li>
		</ul>
	</li>
	
<?php } else { ?>
	<li>
		<a href="#" id="menuindex" onclick="cargar_doc(this);" data-seccion="INICIO"><i class="fas fa-home"></i> INICIO</a>
	</li>
	<li>
		<a href="#" id="menucomercios" onclick="cargar_doc(this);" data-seccion="COMERCIOS" class=""><i class="fas fa-building"></i> COMERCIOS</a>
	</li>
	<li>
		<a href="#eventSubmenu" id="menueventos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-calendar-alt"></i> EVENTOS</a>
		<ul class="collapse list-unstyled" id="eventSubmenu">
			<li>
				<a href="#" id="consultalink" onclick="cargar_doc(this);" data-seccion="CONSULTAEVENTOS"><i class="fas fa-clipboard"></i> CONSULTA</a>
			</li>
			<li>
				<a href="#" id="nuevoeventolink" onclick="cargar_doc(this);" data-seccion="NUEVOEVENTO"><i class="fas fa-clipboard"></i> NUEVO EVENTO</a>
			</li>
			<li>
				<a href="#" id="menuassignacionruta" onclick="cargar_doc(this);" data-seccion="ASSIGNACIONRUTA"><i class="fas fa-map-marked-alt"></i> ASIGNACION RUTA</a>
			</li>
			<li>
				<a href="#" id="validacionlink" onclick="cargar_doc(this);" data-seccion="VALIDACIONES"><i class="fas fa-clipboard-check"></i> VALIDACION</a>
			</li>
			<li>
				<a href="#" id="cierreeventolink" onclick="cargar_doc(this);" data-seccion="CERRAREVENTO"><i class="fas fa-window-close"></i> CIERRE EVENTOS</a>
			</li>
      <li>
				<a href="#" id="visitaocularlink" onclick="cargar_doc(this);" data-seccion="VISITAOCULAR"><i class="fas fa-eye"></i> VISITA OCULAR</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="#" id="menualmacen" onclick="cargar_doc(this);" data-seccion="ALMACEN"><i class="fas fa-warehouse"></i> ALMACEN</a>
	</li>

	<li>
		<a href="#inventarioSubmenu" id="menuinventarios" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-align-justify"></i> INVENTARIOS</a>
		<ul class="collapse list-unstyled" id="inventarioSubmenu">
			<li>
				<a href="#" id="tvplink" onclick="cargar_doc(this);" data-seccion="INVENTARIOTPV"><i class="fas fa-database"></i> TPV</a>
			</li>
			<li>
				<a href="#" id="simlink" onclick="cargar_doc(this);" data-seccion="INVENTARIOSIM"><i class="fas fa-database"></i> SIM</a>
			</li>
			<li>
				<a href="#" id="insumoslink" onclick="cargar_doc(this);" data-seccion="INVENTARIOINSUMOS"><i class="fas fa-database"></i> INSUMOS</a>
			</li>

		</ul>
	</li>
	<li>
		<a href="#" id="menuimagenes" onclick="cargar_doc(this);" data-seccion="IMAGENES"><i class="fas fa-images"></i> IMAGENES</a>
	</li>
	<li>
		<a href="#" id="menumapas"  onclick="cargar_doc(this);" data-seccion="MAPAS"><i class="fas fa-map"></i> MAPAS</a>
	</li>
	<li>
		<a href="#reportSubmenu" id="menureportes" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-calendar-alt"></i> REPORTES</a>
		<ul class="collapse list-unstyled" id="reportSubmenu">
			<li>
				<a href="#" id="repeventoslink" onclick="cargar_doc(this);" data-seccion="EXCELEVENTOS"><i class="fas fa-file-excel"></i> EVENTOS</a>
			</li>
			<li>
				<a href="#" id="repalmacenlink" onclick="cargar_doc(this);" data-seccion="EXCELALMACEN"><i class="fas fa-file-excel"></i> ALMACEN</a>
			</li>
			<li>
				<a href="#" id="reptecnicoslink" onclick="cargar_doc(this);" data-seccion="EXCELTECNICOS"><i class="fas fa-file-excel"></i> TECNICOS</a>
			</li>

		</ul>
	</li>
	<li>
		<a href="#catalogSubmenu" id="menucatalogos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-layer-group"></i> CATALOGOS</a>
		<ul class="collapse list-unstyled" id="catalogSubmenu">
			<li>
				<a href="#"  id="catusuarioslink" onclick="cargar_doc(this);" data-seccion="REGISTROUSUARIOS"><i class="fas fa-clipboard"></i> REGISTRO USUARIO</a>
			</li>
			<li>
				<a href="#"  id="catmodeloslink" onclick="cargar_doc(this);" data-seccion="REGISTROMODELOS"><i class="fas fa-calculator"></i> REGISTRO MODELO</a>
			</li>
			<li>
				<a href="#" id="cattecnicoslink" onclick="cargar_doc(this);" data-seccion="REGISTROTECNICOS"><i class="fas fa-clipboard"></i> REGISTRO TECNICOS</a>
			</li>
			<li>
				<a href="#" id="catcpsegoblink" onclick="cargar_doc(this);" data-seccion="ALTACPSEGOB"><i class="fas fa-clipboard"></i> REGISTRO CP SEGOB</a>
			</li>
			<li>
				<a href="#" id="catcuentabanlink" onclick="cargar_doc(this);" data-seccion="ALTACUENTABANCARIA"><i class="fas fa-clipboard"></i> ALTA CUENTA BANCARIA</a>
			</li>
			<li>
				<a href="#" id="cataltacplink" onclick="cargar_doc(this);" data-seccion="ALTACP"><i class="fas fa-clipboard"></i> ALTA CODIGO POSTAL</a>
			</li>
			<li>
				<a href="#" id="catinsumoslink" onclick="cargar_doc(this);" data-seccion="ALTAINSUMO"><i class="fas fa-clipboard"></i> ALTA INSUMO</a>
			</li>
			<li>
				<a href="#" id="catcarrierlink" onclick="cargar_doc(this);" data-seccion="ALTACARRIER"><i class="fas fa-clipboard"></i> ALTA CARRIER</a>
			</li>
		</ul>
	</li>
<?php } ?>
</ul>