<?php require("header.php"); ?>

<div class="page-wrapper ice-theme sidebar-bg bg1 toggled">
	<a id="show-sidebar" class="btn btn-sm btn-dark" href="#" >
		<i class="fas fa-bars"></i>
	</a>
	<nav id="sidebar" class="sidebar-wrapper">

                <?php include("menu.php") ?>

    </nav>
    <!-- page-content  -->
    <main class="page-content pt-2">
    	<body>

    		<div id="overlay" class="overlay"></div>

    		<div class="container fluid p-5">
    			<h5>EVALUACIÓN PENDIENTE:</h5>

    			<div id="evaluacionList" class="border border-secondary">
    				
    			</div>
    		</div>


    	</body>
    	
    </main>
</div>

<!-- page-wrapper -->
    <link href="css/style_timer.css" rel="stylesheet" />
        <!-- using online scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.2/b-html5-1.5.2/datatables.min.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
    	
    		getValidEv();

    		function getValidEv()
    		{
    		    $.ajax({
    		        type: 'GET',
    		        url: 'modelos/evaluacion_db.php',
    		        data: 'module=validar_evaluacion',
    		        cache: false,
    		        success: function(data)
    		        {
    		        
    		            var info = JSON.parse(data)
    		            if (info.id == '0') 
    		            {
    		                //alert("NO TIENES EVALUACION ASIGNADA");
    		                Swal.fire(
    		                	'NO TIENES EVALUACION ASIGNADA',
    		                	'',
    		                	'warning'
    		                	);

    		            }
    		            else
    		            {
    		                //alert("TIENES EVALUACIÓN ASIGNADA");
    		                 Swal.fire(
    		                	'TIENES UNA EVALUACION ASIGNADA',
    		                	'',
    		                	'info'
    		                	);
    		                strToElem();
    		                var parent = document.getElementById('evaluacionList');
    		                var elem = strToElem("EMPEZAR EVALUACIÓN", "evaluacion.php");
    		                parent.appendChild(elem);

    		            }
    		        },
    		        error: function()
    		        {

    		        }
    		    })
    		}

    		function strToElem(text, link)
    		{
    		  var temp = '<p class="text-md-start"> Da click en la siguiente liga: <a style="font-size: 16px" href="'+ link + '">'+text+'</a></p>';
    		  var a = document.createElement("p");
    		  a.innerHTML = temp;
    		  return a.childNodes[0];
    		}

    		
    	
     </script>
