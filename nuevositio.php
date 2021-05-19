<!DOCTYPE html>
<html lang="en">
<?php require("header.php"); ?>

<body>
    <div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                  </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <?php include("menu.php"); ?> 
        </nav>
        <!-- page-content  -->
        <main class="page-content">
            <div id="overlay" class="overlay"></div>
            <div class="page-title">
                        <h3>ESTADÍSTICAS</h3>
                </div>
             <div id="container" class="container-fluid p-2">
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">EVENTOS</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div>
                                            <canvas id="chartEventos" height="398" width="797" style="width: 797px; height: 398px;" ></canvas>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">SERVICIOS DEL MES</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div>
                                            <canvas id="chartServicios" height="398" width="797" style="width: 797px; height: 398px;" ></canvas>
                                        </div>
                                    </div>      
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">TOTAL DE SERVICIOS. MES ANTERIOR Y ACTUAL</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div>
                                            <canvas id="chartEventosMes" height="398" width="797" style="width: 797px; height: 398px;" ></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
             
            </div>




        </main>
        <!-- page-content" -->
    </div>
    <!-- page-wrapper -->

    <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="//malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript" src="js/jquery.toaster.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script> 
    <script src="js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            
            var eventos = $("#chartEventos");
            var servicios = $("#chartServicios");
            var serviciosMes = $("#chartEventosMes");

            $.ajax({
                type: 'GET',
                url: 'modelos/dashboard_db.php', // call your php file
                data: 'module=getTotalEventosbyStatus',
                cache: false,
                success: function(data){
                   var info = JSON.parse(data);
                   console.log(info);  
                
                   var result = [];
                   var resultMonth = [];
                   var serviceMonth = []

                   for (var i = 0; i < info.eventosStatus.length; i++) {
                        
                        result.push(info.eventosStatus[i].total);
                        
                   }

                   for (var i = 0; i < info.eventosMonth.length; i++) {
                        
                        resultMonth.push(info.eventosMonth[i].total);
                        
                   }

                   for (var i = 0; i < info.serviciosMes.length; i++) {
                        
                        serviceMonth.push(info.serviciosMes[i].total);
                        
                   }
                   
                   
                    var data1 = {
                        labels : ["Abierto", "En Ruta", "Cerrado"],
                        datasets : [
                            {
                                label : "Eventos",
                                data : result,
                                backgroundColor: ["#5CB85C", "#517D9C","#A5D5F1"],
                                borderColor : [
                                    "#CDA776",
                                    "#989898",
                                    "#FFFFFF"
                                ],
                                borderWidth : [1, 1, 1]
                            }
                        ]
                    };

                    var data2 = {
                        labels : ["Vencidos", "En Tiempo"],
                        datasets : [
                            {
                                label : "Servicios del Mes",
                                data : resultMonth,
                                backgroundColor: ["#517D9C","#FDD052"],
                            }
                        ]
                    };

                    var data3 = {
                        labels : ["Mes Pasado", "Mes Actual"],
                        datasets : [
                            {
                                label : "Servicios del Mes",
                                data : serviceMonth,
                                backgroundColor: ["#517D9C","#FDD052"],
                            }
                        ]
                    };

                    var myDoughnutChart = new Chart(eventos, {
                        type: 'doughnut',
                        data: data1 ,
                        options: {
                        title: {
                            display: true,
                            text: 'Servicios del Dia'
                        }
                        }
                    });

                    var chartServicios = new Chart(servicios, {
                        type: 'horizontalBar',
                        data:  data2,
                        options: {
                             legend: { display: false },
                             title: {
                                 display: false,
                                 text: 'Servicios del Mes'
                            }
                        }

                     
                    });

                    var chartServicios = new Chart(serviciosMes, {
                        type: 'horizontalBar',
                        data:  data3,
                        options: {
                            legend: { display: false },
                            title: {
                                display: false,
                                text: 'Total de servicios  Mes Anterior y Actual'
                                }
                        }                   
                    });
                    
                },
                error: function(error){
                    var demo = error;
                }
            });

                        
        });
    </script>
</body>

</html>