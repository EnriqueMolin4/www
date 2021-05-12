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
                        <?php if($tipouser == 'VO') { ?>
                            <li class="sidebar-dropdown" id="submenueventos">
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="menu-text">Eventos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenueventos">
                                    <ul>
                                        <li id="eventoslink">
                                            <a href="eventos.php">Consulta</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php } elseif($tipouser == 'supVO') { ?>
                        <li class="sidebar-dropdown" id="submenueventos">
                            <a href="#">
                                <i class="far fa-calendar-alt"></i>
                                <span class="menu-text">Eventos</span>
                            </a>
                            <div class="sidebar-submenu" id="ulsubmenueventos">
                                <ul>
                                    <li id="eventoslink">
                                        <a href="eventos.php">Consulta</a>
                                    </li>
                                    <li id="asignacionrutalink">
                                            <a href="asignacionruta.php">Asignacion Ruta</a>
                                    </li>
                                    <li id="eventoscierrelink">
                                        <a href="eventoscierre.php">Cierre Eventos</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php } else if ($tipouser == 'tecnico') {  ?>
                            <li id="imageneslink">
                                <a href="imagenes.php">
                                    <i class="fa fa-images"></i>
                                    <span class="menu-text">Imagenes</span>
                                </a>
                            </li>
                        <?php } else if ($tipouser == 'supOp') {  ?>
                            <li class="sidebar-dropdown" id="submenueventos">
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="menu-text">Eventos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenueventos">
                                    <ul>
                                        <li id="eventoslink">
                                            <a href="eventos.php">Consulta</a>
                                        </li>
                                        <li id="nuevoeventolink">
                                            <a href="nuevoevento.php">Nuevo Evento</a>
                                        </li>
                                        <li id="asignacioneventoslink">
                                            <a href="asignacioneventos.php">Asignacion Eventos</a>
                                        </li>
                                        <li id="eventoscierrelink">
                                            <a href="eventoscierre.php">Cierre Eventos</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            

                        <?php } else if ($tipouser == 'almacen') {  ?>
                        <li id="registroalmacenlink">
                            <a href="registroalmacen.php">
                                <i class="fa fa-warehouse"></i>
                                <span class="menu-text">Almacen</span>
                            </a>
                        </li>
                        <?php } else if ($tipouser == 'callcenter') {  ?>
                            <li class="sidebar-dropdown" id="submenueventos">
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="menu-text">Eventos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenueventos">
                                    <ul>
                                        <li id="eventoscierrelink">
                                            <a href="eventoscierre.php">Cierre Eventos</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li id="assignareventoslink">
                                <a href="assignareventos.php">
                                    <i class="fa fa-warehouse"></i>
                                    <span class="menu-text">Asignar Eventos</span>
                                </a>
                            </li>
                            <li id="registroalmacenlink">
                                <a href="registroalmacen.php">
                                    <i class="fa fa-warehouse"></i>
                                    <span class="menu-text">Almacen</span>
                                </a>
                            </li>
                            <?php } else if ($tipouser == 'RH'  ) {  ?>
                            <li class="sidebar-dropdown" id="submenurecursos">
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="menu-text">Recursos Humanos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenurecursos">
                                    <ul>
                                        <li id="expedienteslink">
                                            <a href="expedientes.php">Expedientes</a>
                                        </li>      
                                    </ul>
                                </div>
                            </li>
 
                        <?php } else { ?>
                            <li id="comercioslink">
                                <a href="comercios.php">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-text">Comercios</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown" id="submenueventos">
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="menu-text">Eventos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenueventos">
                                    <ul>
                                        <li id="eventoslink">
                                            <a href="eventos.php">Consulta</a>
                                        </li>
                                        <li id="nuevoeventolink">
                                            <a href="nuevoevento.php">Nuevo Evento</a>
                                        </li>
                                        <li id="asignacionrutalink">
                                            <a href="asignacionruta.php">Asignacion Ruta</a>
                                        </li>
                                        <li id="asignacioneventoslink">
                                            <a href="asignacioneventos.php">Asignacion Eventos</a>
                                        </li>
                                        <li id="eventoscierrelink">
                                            <a href="eventoscierre.php">Cierre Eventos</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
							<li class="sidebar-dropdown" id="submenurecursos">
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <span class="menu-text">Recursos Humanos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenurecursos">
                                    <ul>
                                        <li id="expedienteslink">
                                            <a href="expedientes.php">Expedientes</a>
                                        </li>      
                                    </ul>
                                </div>
                            </li>
                            <li class="sidebar-dropdown" id="submenualmacen">
                                <a href="#">
                                    <i class="fa fa-warehouse"></i>
                                    <span class="menu-text">Almacen</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenualmacen">
                                    <ul>
                                        <li id="almacenlink">
                                            <a href="registroalmacen.php">General</a>
                                        </li>
                                        <li id="cargastecnicolink">
                                            <a href="inventariotecnico.php">Tecnicos</a>
                                        </li>   
                                        <li id="traspasoslink">
                                            <a href="traspasos.php">Envios</a>
                                        </li>                                      
                                    </ul>
                                </div>
                            </li>
                            <li id="imageneslink">
                                <a href="imagenes.php">
                                    <i class="fa fa-images"></i>
                                    <span class="menu-text">Imagenes</span>
                                </a>
                            </li>
                            <li id="mapaslink">
                                <a href="mapas.php">
                                    <i class="fa fa-map"></i>
                                    <span class="menu-text">Mapas</span>
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="fa fa-calendar-alt"></i>
                                    <span class="menu-text">Reportes</span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="reporte_eventos.php">Eventos</a>
                                        </li>
                                        <li>
                                            <a href="reporte_imagenestecnico.php">Imagenes por Tecnico</a>
                                        </li>
                                        <li>
                                            <a href="reporte_inventariocampo.php">Inventario en Campo</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="sidebar-dropdown" id="submenucatalogos">
                                <a href="#">
                                    <i class="fa fa-calendar-alt"></i>
                                    <span class="menu-text">Catalogos</span>
                                </a>
                                <div class="sidebar-submenu" id="ulsubmenucatalogos">
                                    <ul>
                                        <li id="registrousuarioslink">
                                            <a href="registrousuarios.php">Usuarios</a>
                                        </li>
                                        <li id="tecnicosxsupervisorlink">
                                            <a href="tecnicosxsupervisor.php">Tecnicos x Supervisor</a>
                                        </li> 
										<li id="parametroslink">
                                            <a href="parametros.php">Parametros</a>
                                        </li> 
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
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
