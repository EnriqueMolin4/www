<div class="sidebar-content" >
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand" style=";">
                    <a href="index.php  "><img src="images/LOGOSAE2.png" width="98px" height="40px" style=""></a>
                    <div id="close-sidebar">
                         <i class="fas fa-bars"></i>
                      </div>
                </div>
                <center><div class="sidebar-item sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="images/LOGOSS_2.png" alt="User picture" width="auto">
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?php echo $_SESSION['nombre']; ?>
                            <strong><?php echo $_SESSION['apellidos']; ?></strong>
                        </span>
                        <span class="user-role"><?php echo $tipouser; ?></span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                    </div>
                </div></center>
                <!-- sidebar-menu  -->
                <div class="sidebar-item sidebar-menu">
               
                    <ul>
                        <li class="header-menu" >
                            <span style="color: white">General</span>
                        </li>
                        <li>
                            <a href="index.php">
                                <i class="fa fa-home"></<i>
                                </i>
                                <span class="menu-text">Inicio </span> 
                            </a>
                        </li>
                    <?php
                        if ( searchMenu($_SESSION['Modules'],'url','comercios') ) 
                        {
                    ?>    
                        <li id="comercioslink">
                            <a href="comercios.php">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="menu-text">Comercios</span>
                            </a>
                        </li>
                    <?php 
                        } 
                        if ( searchMenu($_SESSION['Modules'],'group','Eventos') )   
                        {  
                    ?>
                        <li class="sidebar-dropdown" id="submenueventos">
                            <a href="#">
                                <i class="far fa-calendar-alt"></i>
                                <span class="menu-text">Eventos</span>
                            </a>
                            <div class="sidebar-submenu" id="ulsubmenueventos">
                                <ul>
                                <?php
								
                                    if ( searchMenu($_SESSION['Modules'],'url','eventos')) {
                                ?>  
                                    <li id="eventoslink">
                                        <a href="eventos.php">Consulta</a>
                                    </li>
                                <?php 
                                    } 

                                    if ( searchMenu($_SESSION['Modules'],'url','nuevoevento')) 
                                    {
                                ?>
                                    <li id="nuevoeventolink">
                                        <a href="nuevoevento.php">Nuevo Evento</a>
                                    </li>
                                <?php 
                                    } 

                                    if ( searchMenu($_SESSION['Modules'],'url','asignacioneventos')) {
                                ?>
                                    <li id="asignacioneventoslink">
                                        <a href="asignacioneventos.php">Asignacion Eventos</a>
                                    </li>
                                <?php 
                                    } 

                                    if ( searchMenu($_SESSION['Modules'],'url','eventoscierre')) {
                                ?>
                                    <li id="eventoscierrelink">
                                        <a href="eventoscierre.php">Cierre Eventos</a>
                                    </li>
                                <?php 
                                } 
                                ?>
                                </ul>
                            </div>
                        </li>
                        <?php 
                        } 
                            
                          if ( searchMenu($_SESSION['Modules'],'group','RecursosHumanos') )   { 
                        ?>
                        <li class="sidebar-dropdown" id="submenurecursos">
                            <a href="#">
                                <i class="fas fa-users-cog"></i>
                                <span class="menu-text">Recursos Humanos</span>
                            </a>
                            <div class="sidebar-submenu" id="ulsubmenurecursos">
                                <ul>
                        <?php  if ( searchMenu($_SESSION['Modules'],'url','expedientes')) {  ?>
                        
                                    <li id="expedienteslink">
                                        <a href="expedientes.php">Expedientes</a>
                                    </li>  
                        <?php 
                                } 
                        ?>    
                                </ul>
                            </div>
                        </li>
                        <?php 
                        
                        }

                        if ( searchMenu($_SESSION['Modules'],'group','Almacen') )   { 
                        ?>
                        <li class="sidebar-dropdown" id="submenualmacen">
                            <a href="#">
                                <i class="fa fa-warehouse"></i>
                                <span class="menu-text">Almacen</span>
                            </a>
                            <div class="sidebar-submenu" id="ulsubmenualmacen">
                                <ul>
                            <?php  
                                if ( searchMenu($_SESSION['Modules'],'url','registroalmacen')) { 
                            ?>
                                    <li id="almacenlink">
                                        <a href="registroalmacen.php">TPV | SIMS </a>
                                    </li>
                            <?php 
                            }
							if (searchMenu($_SESSION['Modules'],'url','insumoaccesorios')) {
							?>
									<li id="insumoslink">
										<a href="insumos_accesoriosNEW.php">Insumos | Accesorios </a>
									</li>
							<?php
							}
                             if ( searchMenu($_SESSION['Modules'],'url','inventariotecnico')) { 
                            ?>
                                    <li id="cargastecnicolink">
                                        <a href="inventariotecnico.php">Técnicos</a>
                                    </li>   
                             <?php 
                             }
                            if ( searchMenu($_SESSION['Modules'],'url','traspasos')) { 
                            ?>
                                    <li id="traspasoslink">
                                        <a href="traspasos.php">Envíos</a>
                                    </li>  
							<?php
							}
                             if ( searchMenu($_SESSION['Modules'],'url','inventarioelavon')) { 
                            ?>  
                                    <li id="inventarioelavonlink">
                                        <a href="inventarioelavon.php">Elavon Universo</a>
                                    </li> 
                            <?php
                             }
							   if ( searchMenu($_SESSION['Modules'],'url', 'peticionesenvio')){
								   
                             ?> 
									<li id="peticioneslink">
                                        <a href="peticiones.php">Peticiones</a>
                                    </li>
							<?php
							   }

                                if ( searchMenu($_SESSION['Modules'],'url', 'tarjetastecnico')){

							 ?>
                                    <li id="tarjetaslink">
                                        <a href="tarjetastecnico.php">Tarj. Tecnico</a>
                                    </li>

                            <?php
                                }
                            ?>
                                </ul>
                            </div>
                        </li>
                        <?php 
                             
                        }

                        if ( searchMenu($_SESSION['Modules'],'url','imágenes') )   { 
                        ?>
                        <li id="imageneslink">
                            <a href="imagenes.php">
                                <i class="fa fa-images"></i>
                                <span class="menu-text">Imágenes</span>
                            </a>
                        </li>
                        <?php 
                        
                        }

                        if ( searchMenu($_SESSION['Modules'],'url','mapas') )   { 
                        ?>
                        <li id="mapaslink">
                            <a href="mapas.php">
                                <i class="fa fa-map"></i>
                                <span class="menu-text">Mapas</span>
                            </a>
                        </li>
                        <?php
                         }

                        if ( searchMenu($_SESSION['Modules'],'group','Reportes') )   { 
                        ?>
                        <li class="sidebar-dropdown" id="submenureportes">
                            <a href="#">
                                <i class="fa fa-calendar-alt"></i>
                                <span class="menu-text">Reportes</span>
                            </a>
                            <div class="sidebar-submenu" id="ulsubmenureportes">
                                <ul>
								<?php
								if ( searchMenu($_SESSION['Modules'],'url','reporte_eventos') )   { 
								?>
                                    <li>
                                        <a href="reporteDetEv.php">Eventos</a>
                                    </li>
								<?php 
								}
								if ( searchMenu($_SESSION['Modules'],'url','reporte_imagenestecnico') )   { 
								?>
                                    <li>
                                        <a href="reporte_imagenestecnico.php">Imagenes por Tecnico</a>
                                    </li>
								<?php 
								}
								if ( searchMenu($_SESSION['Modules'],'url','reporte_inventariocampo') )   { 
								?>
                                    <li>
                                        <a href="reporte_inventariocampo.php">Inventario en Campo</a>
                                    </li>
								<?php 
                                }
                                if ( searchMenu($_SESSION['Modules'],'url','reporte_almacen') )   { 
                                    ?>
                                    <li>
                                        <a href="reporte_almacen.php">Reporte Almacen</a>
                                    </li>
                                <?php 
                                }
								if ( searchMenu($_SESSION['Modules'],'url','bitacoraODT') )   { 
                                    ?>
                                    <li id="bitacoraodtlink">
                                        <a href="bitacoraODT.php">Bitacora ODT</a>
                                    </li>
                                <?php 
                                }
								if ( searchMenu($_SESSION['Modules'],'url','buscarSerie') )   { 
                                    ?>
                                    <li id="buscarserielink">
                                        <a href="rpt_series.php">Buscar Serie</a>
                                    </li>
                                <?php 
                                }
								
								if( searchMenu($_SESSION['Modules'], 'url', 'reporter'))  {
								?>
									<li id="reportedeteventolink">
										<a href="reporte_detalle_evento.php">Reporte Detalle Evento</a>
									</li>
								
								<?php
								}
								?>
                                </ul>
                            </div>
                        </li>
                        <?php 
                        }

                        if ( searchMenu($_SESSION['Modules'],'group','Catalogos') )   
                        { 
                        ?>
                            <li class="sidebar-dropdown" id="submenucatalogos">
                                <a href="#">
                                    <i class="fa fa-calendar"></i>
                                    <span class="menu-text">Catálogos</span>
                                </a>
                            <div class="sidebar-submenu" id="ulsubmenucatalogos">
                                <ul>
								    <?php  if ( searchMenu($_SESSION['Modules'], 'url', 'bancos'))    {   ?>
                                        <li id="bancoslink">
                                            <a href="bancos.php">Bancos</a>
                                        </li>
                                    <?php }

                                    if ( searchMenu($_SESSION['Modules'],'url','registrousuarios') )   {  ?>
                                        <li id="registrousuarioslink">
                                         <a href="registrousuarios.php">Usuarios</a>
                                        </li>
								    <?php } 
									
                                        if ( searchMenu($_SESSION['Modules'],'url','tecnicosxsupervisor') )  { 
                                        
								    ?>
                                        <li id="tecnicosxsupervisorlink">
                                        <a href="tecnicosxsupervisor.php">Tecnicos x Supervisor</a>
                                        </li> 
                                    <?php  }
                                    
                                        if ( searchMenu($_SESSION['Modules'],'url','parametros') )   { 
                                         
                                    ?>
                                    <li id="parametroslink">
                                        <a href="parametros.php">Parámetros</a>
                                    </li> 
                                    <?php }


                                     
                                        if (searchMenu($_SESSION['Modules'],'url','tipos_catalogos') ) {
                                        
                                    ?>
                                        <li id="vac_catalogolink">
                                            <a href="tipos_catalogos.php">Versión, Aplicativo y Conectividad</a>
                                        </li>
                                    <?php }

                                        if (searchMenu($_SESSION['Modules'], 'url', 'modelos') ) {
                                        

                                    ?>
                                        <li id="catalogoxmodeloslink">
                                            <a href="catalogosxmodelos.php">Modelos</a>
                                        </li>
                                    <?php }

                                        if(searchMenu($_SESSION['Modules'], 'url', 'permisos')) {

                                    ?>

                                        <li id="permisoslink">
                                        <a href="permisos.php">Permisos</a>
                                        </li>
                                    <?php }

                                    	if (searchMenu($_SESSION['Modules'], 'url', 'catalogo_territorios')) {
                                    		# code...
                                    ?>
                                    	<li id = "territorioslink">
                                    		<a href="territorios.php">Territorios</a>
                                    	</li>
                                    <?php }
                                    if (searchMenu($_SESSION['Modules'], 'url', 'catalogo_plazas')) {
                                    		# code...
                                    ?>
                                    	<li id = "plazaslink">
                                    		<a href="plazas.php">Plazas</a>
                                    	</li>
                                    <?php }

									if (searchMenu($_SESSION['Modules'], 'url', 'cancelacionyrechazos')) {
                                    		# code...
                                    ?>
                                    	<li id = "cancelyrechazoslink">
                                    		<a href="cancelacion_rechazo.php">Cancelación y Rechazo</a>
                                    	</li>

                                    <?php }
                                     if (searchMenu($_SESSION['Modules'], 'url', 'tarjetastecnico')) {
                                         # code...
                                     ?>
                                        <li id = "tarjetastecnicolink">
                                            <a href="tarjetastecnico.php">Tarjetas Técnico</a>
                                        </li>
                                    <?php }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <?php } 
						
						if ( searchMenu($_SESSION['Modules'],'group','Evaluacion') )
						{
						?> 
							<li class="sidebar-dropdown" id="submenuevaluacion">
								<a href="#">
									<i class="fa fa-file-alt"></i>
									<span class="menu-text" >Evaluacion</span>
								</a>
								<div class="sidebar-submenu" id="ulsubmenuevaluacion">
									<ul>
										<?php if ( searchMenu( $_SESSION['Modules'],'url','evaluacion' ) ) {?>
										
										<li id="evaluacionlink">
											<a href="evaluacion.php">Test</a>
										</li>
										<?php }
                                        if ( searchMenu( $_SESSION['Modules'], 'url', 'nuevaevaluacion' ) ) {
                                        ?>
                                        <li id="nuevaevaluacionlink">
                                            <a href="nuevaevaluacion.php">Nueva Evaluación</a>
                                        </li>
										<?php }
                                        if ( searchMenu( $_SESSION['Modules'], 'url', 'evaluacion_tecnica') ) {
                                        ?>
                                        <li id="evaluacionteclink" >
                                            <a href="validar_evaluacion.php">Ver Evaluacion</a>
                                        </li>
                                    <?php }
                                    ?>
										
									</ul>
								</div>
							</li>
						<?php } 
                        if ( searchMenu($_SESSION['Modules'], 'group','ResultadosEv') )
                        {
                        ?>
                            <li class="sidebar-dropdown" id="submenuresultados" >
                                <a href="#">
                                    <i class="fa fa-file-alt"></i>
                                    <span class="menu-text">Resultados Evaluación</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenuresultados">
                                    <ul>
                                        <?php if (searchMenu($_SESSION['Modules'], 'url', 'resultados_evaluacion') ){
                                        ?>
                                    <li id="resultadoslink">
                                        <a href="resultados_evaluacion.php">Ver Resultados</a>
                                    </li>
                                <?php } ?>
                                </ul>
                                </div>
                            </li>
                        <?php }
                        ?>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
</div>
<!-- sidebar-footer  -->
<div class="sidebar-footer">
    
    <div>
        <a href="sesiones/logout.php">
            <i class="fa fa-power-off"> Salir</i>
        </a>
    </div>
    <div class="pinned-footer">
        <a href="#">
            <i class="fas fa-ellipsis-h"></i>
        </a>
    </div>
</div>
<style>
    .menu-text
    {
        color: white;
    }
    .fa-bars:before {
    content: "\f0c9";
    color: white;
    }
    .sidebar-bg.bg1 .sidebar-wrapper {
    background-image: url(../img/bg1.jpg);
    width: 13%;
    }
    .sidebar-wrapper .sidebar-menu ul li a .menu-text {
    color: white;
    display: inline-block;
    font-size: 15px;
    margin-bottom: 10px;
    }
    .menu-text {
    
    }

</style>