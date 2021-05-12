<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <div class="container">
            <br />
            <form method="POST" action="sesiones/validacion.php">
           <div class="row">
               <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-12 bckcolor">
                           <img src="images/logoTexto.png">

                       </div>
                       <div class="col-md-12 bckcolor">
                           <br />
                        <div class="form-group">
                                <label for="exampleInputEmail1">Usuario</label>
                                <input type="text" class="form-control" name="user" id="user" aria-describedby="emailHelp" placeholder="Usuario">
                               
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Contraseña</label>
                                <input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña">
                            </div>
                            <button type="btn btn-info" class="btn btn-primary mb-2">Accesar</button>
                       </div>
                   </div>

               </div>
               <div class="col-md-6">
                   <img src="images/bannerLogin.png">
                </div>
           </div>   
</form> 
        </div>
        
        <script src="js/jquery-3.3.1"></script>
        <script src="js/boostrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {

            })
        </script>
    </body>
</html>
