<?php
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem

date_default_timezone_set('America/Monterrey');

require __DIR__.'/../modelos/procesos_db.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;



$fechaProceso = date ( 'Y-m-d H:m:s' );
echo "############## $fechaProceso ###########";

        //$eventoMasivo = new CargasMasivas();
        $archivo =  '/var/www/html/cron/MODIFICARFECHAS.xlsx';

        $spreadsheet = IOFactory::load($archivo);
        $hojaDeProductos= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        
        $user = $proceso['creado_por'];
        $consecutivo = 1;
        $counter = 0;
        $nocounter = 0;
        $insert_values = array();
        $fecha = date ( 'Y-m-d H:m:s' );
        $odtYaCargadas = array();
  
        $datosCargar = array();
        $format = "d/m/Y H:i:s";
        $numeroMayorDeFila = count($hojaDeProductos); 
        //Updatw PRoceso en ejecucion


        for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
            
            # Las columnas están en este orden:
            # Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
            $ODT = $hojaDeProductos[$indiceFila]['A'];
            if(!is_null($ODT)  ) {
                $counter++;
                 
 
                $FechaAlta = $hojaDeProductos[$indiceFila]['B'] ;
                $FechaVencimiento = $hojaDeProductos[$indiceFila]['C'] ; 
                
                $date = DateTime::createFromFormat($format, $FechaAlta);
				// echo $FechaAlta;
                $FechaAlta = $date->format("Y-m-d H:i:s");
                
                $date = DateTime::createFromFormat($format, $FechaVencimiento);
                $FechaVencimiento = $date->format("Y-m-d H:i:s"); 
                
       
                
                $existeEvento = $Procesos->existeEvento($ODT);


                if($existeEvento) {
                    $fecha = date ( 'Y-m-d H:m:s' );

                    $sqlEvento = "UPDATE eventos SET fecha_alta=?, fecha_vencimiento=? WHERE odt = ?";

                    $arrayStringEvento = array (
                        $FechaAlta,
                        $FechaVencimiento,
						$ODT
                    );
                    echo $FechaAlta." ".$FechaVencimiento." ".$ODT." \n ";
                    $Procesos->insert($sqlEvento,$arrayStringEvento);
                    
                    
                } 
            }
        }
        
     


?>
