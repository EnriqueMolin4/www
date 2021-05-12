<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>SINTTECOM</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.css"/>
    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/style.css">
   </head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="view/img/logo.png" width="200" height="80">
            </div>

             <?php include("menu.php"); ?>

           
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="sesiones/logout.php"><i class="far fa-user"></i> Salir</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="container" class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                <canvas id="chartEventos" width="200" height="200"></canvas>
                </div>
                <div class="col-sm-4">
                    <canvas id="chartServicios" width="500" height="500"></canvas>
                </div>
            </div>
                
            </div>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="js/jquery-3.3.1.js"></script>
    
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <div id="scriptModule"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            
            var eventos = $("#chartEventos");
            var servicios = $("#chartServicios");

            var myDoughnutChart = new Chart(eventos, {
                type: 'doughnut',
                data: {
                labels: ["Abierto", "En Ruta", "Cerrado"],
                datasets: [{
                    label: "Population (millions)",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#c45850"],
                    data: [2478,5267,734]
                }]
                },
                options: {
                title: {
                    display: true,
                    text: '% de ODTs'
                }
                }
            });
            
            var chartServicios = new Chart(servicios, {
                    type: 'horizontalBar',
                    data: {
                    labels: ["Cambio de SIM", "Instalacion de TPV", "Envio de Insumos", "Retiro de Tpv adicional"],
                    datasets: [
                        {
                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#c45850"],
                        data: [10,45,12,24]
                        }
                    ]
                    },
                    options: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Servicios del Mes'
                        }
                    }
                });
                        
        });

        function cargar_doc(data){
            var seccion = data.getAttribute("data-seccion");
            //alert(seccion);
            switch(seccion) {
                case 'INICIO':
                $("#container").load('index/dashboard-html.php');
                break;
                case 'COMERCIOS':
                $("#container").load('index/comercios-html.php', function() {

                   
                });
                
                break;
                case 'CONSULTAEVENTOS':
                $("#container").load('index/eventos-html.php');
                break;
                case 'NUEVOEVENTO':
                $("#container").load('index/nuevoevento.php');
                break;
                case 'VALIDACIONES':
                $("#container").load('index/validaciones-html.php');
                break;
                case 'ASSIGNACIONRUTA':
                $("#container").load('index/assignacionruta-html.php');
                break;
                case 'CERRAREVENTO':
                $("#container").load('index/eventoscierre-html.php');
                break;
                case 'IMAGENES':
                $("#container").load('index/imagenes-html.php');
                break;
                case 'REGISTROUSUARIOS':
                $("#container").load('index/registrousuarios-html.php');
                break;
                case 'ALMACEN':
                $("#container").load('index/registroalmacen-html.php');
                break;
                case 'REGISTROMODELOS':
                $("#container").load('index/registromodelos-html.php');
                break;
                case 'INVENTARIOSIM':
                $("#container").load('index/inventsim-html.php');
                break;
                case 'INVENTARIOTPV':
                $("#container").load('index/inventtpv-html.php');
                break;
                case 'MAPAS':
                $("#container").load('index/mapas-html.php');
                break;
                case 'INVENTARIOINSUMOS':
                $("#container").load('index/inventinsumos-html.php');
                break;
                case 'VISITAOCULAR':
                $("#container").load('index/nuevavo-html.php');
                break;

                
            }
        }

        function ResetLeftMenuClass(header, subheader, link) {
            $("#menucomercios").removeClass("active");

            $("#eventSubmenu").css('display', 'none');

            $("#"+header+"").addClass("active");
            $("#"+link+"").addClass("active");
            $("#"+subheader+"").css('display', 'block');
            
        }

       
    </script>
    
</body>

</html>