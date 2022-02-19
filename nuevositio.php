<!DOCTYPE html>
<html lang="en">
<?php require("header.php"); ?>

<body style="background-color: #E5E5E5;">
<div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
   <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
   <i class="fas fa-bars"></i>
   </a>
   <nav id="sidebar" class="sidebar-wrapper">
      <?php include("menu.php"); ?> 
   </nav>
   <!-- page-content  -->
   <main class="page-content pt-2">
      <div id="overlay" class="overlay"></div>
      <!-- <div class="container-fluid p-5"> -->
         <div id="container" class="container-fluid" >
            
            <div class="row clearfix">
               <!--<div class="col-sm-2"></div>-->
               <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                    <div class="card">
                        <!-- <div class="header">
                            <h4>Servicios del Día</h4>
                        </div> -->
                        <div class="body">
                            <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                            <canvas id="chartEventos" width="617" height="258"></canvas>
                        </div>
                    </div>
                  
               </div>

               <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <!-- <div class="header">
                        <h4>Servicios del Mes</h4>
                    </div> -->
                    <div class="body">
                        <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                        <canvas id="chartServicios" width="617" height="258" ></canvas>
                    </div>
                    
                </div>
                  
               </div>

            </div> 
            <br>

            <div class="row clearfix">
                
               <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <!-- <div class="header">
                        <h4>Total de servicios: Mes anterior y actual</h4>
                    </div> -->
                    <div class="body">
                        <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                        <canvas id="chartEventosMes" width="617" height="258"></canvas>
                    </div>
                </div>
                  
               </div>
            </div>

         </div>
      <!--</div>-->
   </main>
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
    <style>
        .card 
        {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }
    </style>
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
                                label : "EVENTOS",
                                data : result,
                                backgroundColor: ["#3E95CD", "#9F73B2","#C45850"],
                                borderColor : [
                                    "#CDA776",
                                    "#41B8C3",
                                    "#E1B240"
                                ],
                                borderWidth : [1, 1, 1]
                            }
                        ]
                    };

                    var data2 = {
                        labels : ["Vencidos", "En Tiempo"],
                        datasets : [
                            {
                                label : "SERVICIOS DEL MES",
                                data : resultMonth,
                                backgroundColor: ["#5A71D6","#15AF90"],
                            }
                        ]
                    };

                    var data3 = {
                        labels : ["Mes Pasado", "Mes Actual"],
                        datasets : [
                            {
                                label : "SERVICIOS DEL MES",
                                data : serviceMonth,
                                backgroundColor: ["#B4B4B4","#8174E0"],
                            }
                        ]
                    };

                    var myDoughnutChart = new Chart(eventos, {
                        type: 'doughnut',
                        data: data1 ,
                        options: {
                            responsive: true,
                        title: {
                            display: true,
                            text: 'SERVICIOS DEL DIA'
                        }
                        }
                    });

                    var chartServicios = new Chart(servicios, {
                    type: 'bar',
                    data:  data2,
                    options: {
                        responsive: true,
                        legend: { display: false },
                        title: {
                        display: true,
                        text: 'SERVICIOS DEL MES'
                        }
                    }

                     
                    });

                    var chartServicios = new Chart(serviciosMes, {
                        type: 'horizontalBar',
                        data:  data3,
                        options: {
                            responsive: true,
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'TOTAL DE SERVICIOS | MES ANTERIOR Y ACTUAL'
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