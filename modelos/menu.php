<div class="sidebar-content">
                <!-- sidebar-brand  -->
                <div class="sidebar-item sidebar-brand">
                    <a href="index.php  "><img src="images/LOGOSAE.fw.png" width="88px" height="40px"></a>
                    <div id="close-sidebar">
                         <i class="fas fa-bars"></i>
                      </div>
                </div>
                <div class="sidebar-item sidebar-header d-flex flex-nowrap">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="images/user.jpg" alt="User picture">
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
                </div>
                <!-- sidebar-menu  -->
                <div class="sidebar-item sidebar-menu">
               
                    <ul>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <li>
                            <a href="index.php">
                                <i class="fa fa-home"></i>
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

                                    if ( searchMenu($_SESSION['Modules'],'url','eventoscierres')) {
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
                                <i class="far fa-calendar-alt"></i>
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
                                        <a href="registroalmacen.php">General</a>
                                    </li>
                            <?php 
                            }
                             if ( searchMenu($_SESSION['Modules'],'url','inventariotecnico')) { 
                            ?>
                                    <li id="cargastecnicolink">
                                        <a href="inventariotecnico.php">Tecnicos</a>
                                    </li>   
                             <?php 
                             }
                            if ( searchMenu($_SESSION['Modules'],'url','traspasos')) { 
                            ?>
                                    <li id="traspasoslink">
                                        <a href="traspasos.php">Envios</a>
                                    </li>  
							<?php
							}
                             if ( searchMenu($_SESSION['Modules'],'url','inventarioelavon')) { 
                            ?>  
                                    <li id="inventarioelavonlink">
                                        <a href="inventarioelavon.php">Inventario TPV</a>
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
                                <span class="menu-text">Imagenes</span>
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
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-calendar-alt"></i>
                                <span class="menu-text">Reportes</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
								<?php
								if ( searchMenu($_SESSION['Modules'],'url','reporte_eventos') )   { 
								?>
                                    <li>
                                        <a href="reporte_eventos.php">Eventos</a>
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
                                    <li>
                                        <a href="bitacoraODT.php">Bitacora ODT</a>
                                    </li>
                                <?php 
                                }
								if ( searchMenu($_SESSION['Modules'],'url','buscarSerie') )   { 
                                    ?>
                                    <li>
                                        <a href="rpt_series.php">Buscar Serie</a>
                                    </li>
                                <?php 
                                }
								?>
                                </ul>
                            </div>
                        </li>
                        <?php 
                        }

                        if ( searchMenu($_SESSION['Modules'],'group','Catalogos') )   { 
                        ?>
                        <li class="sidebar-dropdown" id="submenucatalogos">
                            <a href="#">
                                <i class="fa fa-calendar-alt"></i>
                                <span class="menu-text">Catalogos</span>
                            </a>
                            <div class="sidebar-submenu" id="ulsubmenucatalogos">
                                <ul>
								<?php  if ( searchMenu($_SESSION['Modules'],'url','registrousuarios') )   {  ?>
                                    <li id="registrousuarioslink">
                                        <a href="registrousuarios.php">Usuarios</a>
                                    </li>
								<?php } 
									
									if ( searchMenu($_SESSION['Modules'],'url','tecnicosxsupervisor') )   { 
								?>
                                    <li id="tecnicosxsupervisorlink">
                                        <a href="tecnicosxsupervisor.php">Tecnicos x Supervisor</a>
                                    </li> 
								<?php  }
									if ( searchMenu($_SESSION['Modules'],'url','parametros') )   {  ?>
                                    <li id="parametroslink">
                                        <a href="parametros.php">Parametros</a>
                                    </li> 
                                <?php } 
                                    if ( searchMenu($_SESSION['Modules'],'url','tipos_catalogos') )   {  ?>
                                        <li id="tiposcatalogoslink">
                                            <a href="tipos_catalogos.php">Version, Aplicativo y Conectividad</a>
                                        </li> 
                                    <?php 
                                    } 
                                    
                                    if ( searchMenu($_SESSION['Modules'],'url','modelos') )   {  ?>
                                            <li id="tiposcatalogoslink">
                                                <a href="catalogosxmodelos.php">Modelos</a>
                                            </li> 
                                    <?php 
                                    } 
                                      if ( searchMenu($_SESSION['Modules'],'url','permisos') )   {  ?>
                                            <li id="tiposcatalogoslink">
                                                <a href="permisos.php">Permisos</a> 
                                            </li>  
                                    <?php
                                    }
                                        if ( searchMenu($_SESSION['Modules'],'url','plazas') )   {  ?>
                                            <li id="plazaslink">
                                                <a href="plazas.php">CP x Plazas</a>
                                            </li> 
                                    <?php 
                                     }
                                     if ( searchMenu($_SESSION['Modules'],'url','territorial') )   {  ?>
                                         <li id="territorioslink">
                                             <a href="territorial.php">CP x Territorio</a>
                                         </li> 
                                    <?php 
                                    } 
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <?php 
                        } 
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