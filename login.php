<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sinttecom_SAS</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <style>
        @import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
        body { 
            background: ; 
            background: -webkit-linear-gradient(to bottom, #FFB88C,#FFFFFF );  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to bottom, #FFB88C,#FFFFFF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        .login-block{
        background: #2B3A42;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to bottom, #2B3A42,#FFB88C );  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to bottom,  #2B3A42,#FFB88C); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        float:left;
        width:100%;
        padding : 50px 0;
        }
        .banner-sec{background:url(images/logoImagen.png)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
        .container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
        .carousel-inner{border-radius:0 10px 10px 0;}
        .carousel-caption{text-align:left; left:5%;}
        .login-sec{padding: 50px 30px; position:relative;}
        .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
        .login-sec .copy-text i{color:#FEB58A;}
        .login-sec .copy-text a{color:#E36262;}
        .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #DE6262;}
        .login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
        .btn-login{background: #DE6262; color:#fff; font-weight:600;}
        .banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
        .banner-text h2{color:#fff; font-weight:600;}
        .banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
        .banner-text p{color:#fff;}
        </style>
        
    </head>
    <body>
        <section class="login-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 login-sec">
                        <img src="images/LogoSAESTexto.png"> 
                        <h6 class="text-center">Sistema de Administración</h6>
                        <h6 class="text-center">de Eventos y servicios</h6>
                        <form class="login-form" method="POST" action="sesiones/validacion.php">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-uppercase">Usuario</label>
                                <input type="text" class="form-control" placeholder="" id="user" name="user">
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="text-uppercase">Contraseña</label>
                                <input type="password" class="form-control" placeholder="" id="pass" name="pass">
                            </div>
                            <div class="form-check">
                            
                                <button type="submit" class="btn btn-login float-right">Entrar</button>
                            </div>
                            
                        </form>

                    </div>
                    <div class="col-md-8 banner-sec">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                
                                </div>
                                
                            </div>	   
                        
                        </div>
                    </div>
                </div>
        </section>
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
