<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sinttecom_SAS</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="css/loginStyle.css">
        
    </head>
    <body>
        
        <div class="register-photo">
            <div class="form-container">
                <div class="image-holder"></div>
                <form class="login-form" method="post" action="sesiones/validacion.php">
                    <center><img src="images/LOGOSS_2.png" width="200px">    <br><br>
                    <!-- <h2 class="text-center"><strong>SAES</strong></h2> -->
                    <h2>SISTEMA DE ADMINISTRACIÓN DE EQUIPOS Y SERVICIOS</h2></center><br><hr>
                    <h6>Entrar al sistema</h6><br>
                    <div class="form-group"><input class="form-control" id="user" type="user" name="user" placeholder="USUARIO"></div><br>
                    <div class="form-group"><input class="form-control" id="pass" type="password" name="pass" placeholder="CONTRASEÑA"></div><br>
                    <div class="form-check">
                        <button type="submit" class="btn btn-login float-right">Entrar</button>
                    </div>
                    <!-- 
                        <div class="form-group"><input class="form-control" type="password" name="password-repeat" placeholder="Password (repeat)"></div>
                        <div class="form-group">
                        <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">I agree to the license terms.</label></div>
                        </div>
                        <div class="form-group"><button class="btn btn-success btn-block" type="submit">Sign Up</button></div><a class="already" href="#">You already have an account? Login here.</a>
                     -->
                </form>
            </div>
        </div>
        
        <!-- <section class="login-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 login-sec">
                       
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                
                                </div>
                                
                            </div>     
                        
                        </div>

                    </div>
                    <div class="col-md-8 banner-sec">
                        <img src="images/logoTexto.png"> 
                        <h6 class="text-center">Sistema de Administración de Eventos</h6>
                        <h6 class="text-center">Gestión-Control de Inventarios</h6>
                        <form class="login-form" method="POST" action="sesiones/validacion.php">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-uppercase">Usuario</label>
                                <input type="text" class="form-control" placeholder="" id="user" name="user">
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="text-uppercase">Contraseña</label>
                                <input type="password" class="form-control" placeholder="" id="pass" name="pass">
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
        </section> -->
		 <?php 
           if(isset($_GET['msg']) && $_GET['msg'] == '1')
           {
                echo '<script>alert("USUARIO O CONTRASEÑA NO VALIDOS");</script>';   	
           } else if (isset($_GET['msg']) && $_GET['msg'] == '2')
		   {
			    echo '<script>alert("LLENA AMBOS CAMPOS");</script>'; 
		   }
        ?>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </body>
</html>
