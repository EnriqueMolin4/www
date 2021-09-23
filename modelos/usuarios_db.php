<?php
session_start();
error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
date_default_timezone_set('America/Monterrey');
include('../librerias/enviomails.php');
include('../librerias/cargamasivas.php');

include 'IConnections.php';
class Usuarios implements IConnections {
	private static $connection;
	private static $logger;
	function __construct($db, $log) {
		self::$connection = $db->getConnection  ( 'sinttecom' );
		self::$logger=  $log;
	}
	function fetch() {
		if (isset ( self::$connection )) {
			return self::execute_sel ();
		} else {
			return array ();
		}
	}
	private static function execute_sel() {
		try {
			$stmt = self::$connection->prepare ( "SELECT * FROM `eventos`" );
			$stmt->execute ( array () );
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: execute_sel();	Functionality: Select Warehouses;	Log:" . $e->getMessage () );
		}
	}
	private static  function execute_ins($prepareStatement, $arrayString) {
		try {
			$stmt = self::$connection->prepare ( $prepareStatement );
			$stmt->execute ( $arrayString );
			$stmt = self::$connection->query("SELECT LAST_INSERT_ID()");
			return $stmt->fetchColumn();
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: execute_ins();	Functionality: Insert/Update ProdReceival;	Log:" . $prepareStatement . " " . $e->getMessage () );
		}
	}
	function insert($prepareStatement, $arrayString) {

			return self::execute_ins ( $prepareStatement, $arrayString );

	}
	
	function getEstados() {
		
		$sql = "select * from estados";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getEstados();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getTipoUser() {
		$where = "";
		
		if($_SESSION['tipo_user'] != 'admin') {
			
			$where .= " AND id in ( 3,12 ) ";
		}
		
		$sql = "select id,nombre from tipo_user where status=1 $where ";
		
		self::$logger->error ($sql);
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTipoUser();	Functionality: Get Products price From Users;	Log:" . $e->getMessage () );
        }
	}
	
	function getBancos($tecnico) {
		
		$sql = "SELECT bancos.id,banco,IFNULL(tecnico_bancos.tecnico_id,0) tecnico_id 
				FROM bancos 
				LEFT JOIN tecnico_bancos ON tecnico_bancos.banco_id = bancos.id AND tecnico_bancos.tecnico_id = $tecnico
				WHERE status=1 
				 ";
		
		//self::$logger->error($sql);
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getBancos();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
	}

	/*Para combobox de Usuario Nuevo (CUENTA)*/
	function getBancosUser()
	{
		$sql = "SELECT * FROM `bancos` WHERE status = 1";

		try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getBancosUser();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }

	}	
	/**/
	
	function getPlazas() {
		$sql = "select id,nombre from plazas where estatus=1 ";
		
	
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getPlazas();	Functionality: Get Bancos;	Log:" . $e->getMessage () );
        }
	}


    function getTable($params,$total) {

		$start = $params['start'];
		$length = $params['length'];

		$orderField =  $params['columns'][$params['order'][0]['column']]['data'];
		$orderDir = $params['order'][0]['dir'];
		$order = '';

		$filter = "";
		$param = "";
		$where = "";

		
		if(isset($orderField) ) {
			$order .= " ORDER BY   $orderField   $orderDir";
		}

		if(isset($start) && $length != -1 && $total) {
			$filter .= " LIMIT  $start , $length";
		}

		if( !empty($params['search']['value'])  &&  $total) {   
			$where .=" AND ";
			$where .=" ( user LIKE '".$params['search']['value']."%' ";    
			$where .=" OR c.tipo_user LIKE '".$params['search']['value']."%' ";
			$where .=" OR du.nombre LIKE '".$params['search']['value']."%'  ";
			$where .=" OR du.email LIKE '%".$params['search']['value']."%'  )";

		}

		$sql = " SELECT 
				c.id Id,
				c.user sgs,
				CONCAT(du.nombre,' ',du.apellidos) nombre,
				c.correo,
				tu.nombre TipoUser,
				GROUP_CONCAT(p.nombre) plazas,
				CASE WHEN c.tipo_user = 3 THEN GROUP_CONCAT(t.nombre) ELSE t2.nombre END territorios,
				c.fecha_alta,
				c.estatus
				FROM cuentas c
				LEFT JOIN territorios t2 ON t2.id = c.territorial
				LEFT JOIN tipo_user tu ON tu.id = c.tipo_user ,detalle_usuarios du
				LEFT JOIN plaza_tecnico pt ON pt.tecnico_id = du.cuenta_id
				LEFT JOIN plazas p ON p.id = pt.plaza_id
				LEFT JOIN territorio_plaza tp ON tp.plaza_id = pt.plaza_id
				LEFT JOIN territorios t ON t.id = tp.territorio_id
				WHERE c.id = du.cuenta_id
				$where 		
				group by c.id,du.nombre,du.apellidos,c.correo
				$order
				$filter 
		";

		/* $sql = "select cuentas.id Id,cuentas.tipo_user,cuentas.cve,territorios.nombre territorial,
				CASE WHEN  detalle_usuarios.apellidos is null THEN detalle_usuarios.nombre ELSE CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) END nombre,
				detalle_usuarios.email correo,cuentas.fecha_alta, cuentas.estatus,GetNameById(cuentas.tipo_user,'TipoUser') TipoUser from cuentas 
				LEFT JOIN territorios ON  cuentas.territorial = territorios.id
				,detalle_usuarios
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				$where 
				$order
				$filter "; */

	
		try {
			$stmt = self::$connection->prepare ($sql);
			$stmt->execute();
			return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			self::$logger->error ("File: usuarios_db.php;	Method Name: getTable();	Functionality: Get Table;	Log:" . $e->getMessage () );
		}
	}

    function getEvento($id) {
        $sql = "select * from eventos where id = $id";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getEvento();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getImagenesODT($id) {
		$sql = "select * from img where odt = '$id' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getImagenesODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getHistoriaODT($id,$user) {
		$sql = "select * from historial_img where odt = '$id' and user_revisado =  '$user' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getHistoriaODT();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getSupervisores() {
		$sql = "select cuentas.id,CONCAT(detalle_usuarios.nombre,' ',detalle_usuarios.apellidos) nombre from cuentas,detalle_usuarios  where cuentas.id = detalle_usuarios.cuenta_id AND tipo_user in (1,11) AND cuentas.estatus = 1";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getSupervisores();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTerritorial() {
		$sql = "select  id,nombre from territorios ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute ();
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTerritorial();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getAlmacen($plaza) {

		 
		$plazas = implode(",",json_decode(stripslashes($plaza)));
		 
		$sql = " Select tipo_ubicacion.id,tipo_ubicacion.nombre 
				 FROM tipo_ubicacion,plazas_almacen
				 WHERE tipo_ubicacion.id = plazas_almacen.almacen_id
				 AND almacen = 1
				 AND plazas_almacen.plaza_id in ($plazas)
				 GROUP BY  tipo_ubicacion.id,tipo_ubicacion.nombre ";
				 

        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($plaza));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getAlmacen();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	

	function searchUser($usuario) {
		$sql = "select cuentas.Id,cuentas.tipo_user,cuentas.cve,cuentas.supervisor supervisor,
				detalle_usuarios.nombre,detalle_usuarios.apellidos,
				detalle_usuarios.email correo,cuentas.fecha_alta from cuentas,detalle_usuarios 
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				AND cuentas.correo = ? ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($usuario));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: searchUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getUser($id) {
		$sql = "select 
				cuentas.Id,
				cuentas.user sgs,
				cuentas.tipo_user,
				cuentas.cve,
				cuentas.supervisor supervisor,
				detalle_usuarios.nombre,
				detalle_usuarios.apellidos,
				cuentas.user,cuentas.territorial,
				detalle_usuarios.email correo,
				cuentas.fecha_alta,
				cuentas.almacen,
				GROUP_CONCAT(pt.plaza_id) plazas,
				GROUP_CONCAT(tp.territorio_id) territorios
				from cuentas 
				LEFT JOIN plaza_tecnico pt ON pt.tecnico_id = cuentas.id
				LEFT JOIN territorio_plaza tp ON tp.plaza_id = pt.plaza_id
				,detalle_usuarios
				WHERE cuentas.Id = detalle_usuarios.cuenta_id
				AND cuentas.id = ?
				Group by cuentas.id,detalle_usuarios.nombre,detalle_usuarios.apellidos,detalle_usuarios.email   ";
				
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array($id));
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getUser();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
	
	function getTerritorio($territorio) {
		$territorio = is_null($territorio) ? 0 : $territorio;
		$sql = "select  Id from territorios   
				WHERE nombre LIKE '%$territorio%' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTerritorio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getPlazasTerritorio($territorio) {

		 

		$sql = "SELECT plazas.id plaza_id,plazas.nombre,IFNULL(plaza_tecnico.tecnico_id,0) tecnico_id 
				FROM plazas  
				LEFT JOIN plaza_tecnico ON plaza_tecnico.plaza_id = plazas.id AND plaza_tecnico.tecnico_id = $tecnico
				";

				"SELECT plazas.id plaza_id,plazas.nombre,IFNULL(plaza_tecnico.tecnico_id,0) tecnico_id 
				FROM plazas 
				LEFT JOIN plaza_tecnico ON plaza_tecnico.plaza_id = plazas.id AND plaza_tecnico.tecnico_id = $tecnico,
				territorio_plaza
				WHERE plazas.id = territorio_plaza.plaza_id
				AND territorio_plaza.territorio_id in (0) ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getPlazasTerritorio();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTerritorioPlazas($ter,$usr) {
		$where = '';

		$territorio = json_decode($ter);

		if( sizeof($territorio) > 0 ) {
			$territorios = implode(',',$territorio);

			$where .= " AND territorio_plaza.territorio_id IN ( $territorios ) ";
		} else {
			$where .= " AND territorio_plaza.territorio_id IN (-1) ";
		}
		

		$sql = "SELECT 
				territorio_plaza.plaza_id,
				plazas.nombre ,
				IFNULL(plaza_tecnico.tecnico_id,0) tecnico_id
				FROM territorio_plaza 
				LEFT JOIN  plaza_tecnico ON territorio_plaza.plaza_id = plaza_tecnico.plaza_id  AND plaza_tecnico.tecnico_id = $usr
				,plazas
				WHERE plazas.id = territorio_plaza.plaza_id
				$where
				GROUP BY plazas.id,plaza_tecnico.tecnico_id
				";
		
        try {
            $stmt = self::$connection->prepare ($sql);
            $stmt->execute (array());
            return  $stmt->fetchAll ( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTerritorioPlazas();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}

	function getTipoUserId($tipo) {

		$sql = "select  Id from tipo_user   
				WHERE nombre LIKE '%$tipo%' ";
		
        try {
            $stmt = self::$connection->prepare ($sql );
            $stmt->execute (array());
            return  $stmt->fetch ( PDO::FETCH_COLUMN, 0 );
        } catch ( PDOException $e ) {
            self::$logger->error ("File: usuarios_db.php;	Method Name: getTipoUserId();	Functionality: Get Products price From PriceLists;	Log:" . $e->getMessage () );
        }
	}
}
//
include 'DBConnection.php';
$Usuario = new Usuarios ( $db,$log );

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getTable') {

    $rows = $Usuario->getTable($params,true);
    $rowsTotal = $Usuario->getTable($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}



if($module == 'existeuser') {
	$existe = $Usuario->searchUser($params['correo']);

	echo json_encode(['existe' => count($existe),'usuario' => $existe ]);
}

if($module == 'nuevousuario') {
	$fecha_alta = date("Y-m-d H:i:s");
	$existe = $Usuario->searchUser($params['correo']);
	$territorios = json_decode($params['territorial']);
	$plazas = json_decode($params['plaza']);
	$negocios = json_decode( $params['negocio']);
	$almacen = $params['almacen'];
	$user = $_SESSION['userid'];
	$sgs = $params['user'];
	//$pass = sha1($params['contrasena']);
	//
	
	$bancos = implode("','",$negocios);//Guardar bancos como cadena ¿?


	if(count($existe) == 0 ) {
		$prepareStatement = "INSERT INTO `cuentas`
		( `user`,`pass`,`supervisor`,`cve`,`tipo_user`,`nombre`,`correo`,`plaza`,`territorial`,`fecha_alta`,`almacen`)
		VALUES
		(?,?,?,?,?,?,?,?,?,?,?);
						";
		$arrayString = array (
			$sgs,
			sha1($params['contrasena']),
			0,
			$bancos, //Guardar banco(s) ¿?
			$params['tipo'],
			$params['nombre'],
			$params['correo'],
			0,
			0,
			$fecha_alta,
			$almacen
		);

		$id = $Usuario->insert($prepareStatement,$arrayString);

		
		if($id == 0) {
			$envio = "problemas con el alta de usuarios";
		} else {
		$prepareStatement = "INSERT INTO `detalle_usuarios`
			( `nombre`,`apellidos`,`email`,`territorial`,`cuenta_id`)
			VALUES
			(?,?,?,?,?);
			";
			$arrayString = array (
				$params['nombre'],
				$params['apellidos'],
				$params['correo'],
				0,
				$id
			);

			$Usuario->insert($prepareStatement,$arrayString);

			
			$email = new envioEmail();

			$body = "Se a creado tu cuenta para el Sistema Sinttecom SAES <br /> Tus datos de acceso son  <br/> Usuario :".$params['correo']." <br/>"; 
			$body .= "Contraseña: ".$params['contrasena']." <br /> Acceso Sistema <a href='http://sinttecom.net'>Click Aqui</a>";
			$header = "Acceso Sistema Sinttecom SAES";

			$email->send($header,$body,$params['correo']);
			$envio = "Se Creo al  Usuario";
		} 
	} else {

		$id = $params['userid'];

		//$oldPass = $Usuario->getPass($id);

		//$newPass = strlen($pass) > 0 ? $pass : $oldPass;

		$prepareStatement = "UPDATE  `cuentas` SET `cve`=?,`tipo_user`=?,`nombre`=?,`fecha_alta`=?,`territorial`=?,`plaza`=?,`almacen`=? WHERE `id`=? ; ";
		$arrayString = array (
			$bancos,
			$params['tipo'],
			$params['nombre'],
			$fecha_alta,
			$territorios[0],
			$plazas[0],
			$almacen,
			$params['userid']
		);

		$Usuario->insert($prepareStatement,$arrayString);

		if(!empty($params['contrasena'])) {
			$prepareStatement = "UPDATE  `cuentas` SET `pass`=? WHERE `id`=? ; ";
			$arrayString = array (
				sha1($params['contrasena']),
				$params['userid']
			);

			$Usuario->insert($prepareStatement,$arrayString);
		}		
		
		$prepareStatement = "UPDATE `detalle_usuarios` SET `nombre`=?,`apellidos`=?,`email`=?,`territorial`=? WHERE `cuenta_id`=? ; ";

		$arrayString = array (
			$params['nombre'],
			$params['apellidos'],
			$params['correo'],
			$params['territorial'],
			$params['userid']
		);

		$Usuario->insert($prepareStatement,$arrayString);		
		$envio = "El Usuario se actualizo correctamente ";
	}

	if($params['tipo'] == '3') {

				
	
			//Actualizar Relacion Plaza Tecnico
			$prepareStatement = "DELETE FROM plaza_tecnico WHERE tecnico_id = ? ";

			$arrayString = array (
				$id 
			);

			$Usuario->insert($prepareStatement,$arrayString);

			

			foreach($plazas as $plaza ) {

				$prepareStatement = "INSERT INTO `plaza_tecnico`
					( `plaza_id`,`tecnico_id`,`creado_por`,`fecha_creacion`,`modificado_por`,`fecha_modificacion`)
					VALUES
					(?,?,?,?,?,?);
					";
					$arrayString = array (
						$plaza,
						$id,
						$user,
						$fecha_alta,
						$user,
						$fecha_alta
					);

					$Usuario->insert($prepareStatement,$arrayString);
			}

			//ACtualizar RElacion Banco Tecnico
			$prepareStatement = "DELETE FROM tecnico_bancos WHERE tecnico_id = ? ";

			$arrayString = array (
				$id 
			);

			$Usuario->insert($prepareStatement,$arrayString);

			

			foreach($negocios as $negocio ) {

				$prepareStatement = "INSERT INTO `tecnico_bancos`
					( `banco_id`,`tecnico_id`,`creado_por`,`fecha_creacion`,`modificado_por`,`fecha_modificacion`)
					VALUES
					(?,?,?,?,?,?);
					";
					$arrayString = array (
						$negocio,
						$id,
						$user,
						$fecha_alta,
						$user,
						$fecha_alta
					);

				$Usuario->insert($prepareStatement,$arrayString);
			}
	}

	echo $envio;
}

if($module == 'getSupervisores') {
	$rows = $Usuario->getSupervisores();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;
}

if($module == 'getTipoUser') {

	$rows = $Usuario->getTipoUser();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'getTerritorial') {

	$rows = $Usuario->getTerritorial();
	$val = '';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getPlazasTerritorio') {
	$rows = $Usuario->getPlazasTerritorio($params['territorio']);
	 

	echo json_encode($rows);
	
}

if($module == 'getTerritorioPlazas') {

	$rows = $Usuario->getTerritorioPlazas($params['territorio'],$params['usr']);

	echo json_encode($rows);
}


if($module == 'getAlmacen') {

	$rows = $Usuario->getAlmacen($params['plaza']);
	$val = '<option value="0" selected>Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '" >' . $row ['nombre'] . '</option>';
	}
	echo $val;

}


if($module == 'getBancos') {

	$rows = $Usuario->getBancos($params['tecnico']);
	$val = '';
	 
	 
	foreach ( $rows as $row ) {
		$selected = $row['tecnico_id'] == '0' ? '' : 'selected';
		$val .=  "<option value='". $row ['id']."' $selected>" . $row ['banco'] . "</option>";
	}
	echo $val;

}

if($module == 'getBancosUser')
{
	$rows = $Usuario->getBancosUser();
	$val = '';

	foreach ( $rows as $row ) {
		
		$val .=  "<option value='". $row ['cve']."'>" . $row ['banco'] . "</option>";
	}
	echo $val;

}

if($module == 'getPlazas') {

	$rows = $Usuario->getPlazas();
	$val = '<option value="0">Seleccionar</option>';
	foreach ( $rows as $row ) {
		$val .=  '<option value="' . $row ['id'] . '">' . $row ['nombre'] . '</option>';
	}
	echo $val;

}

if($module == 'getUser') {
	$user = $Usuario->getUser($params['id']);

	echo json_encode($user);
}

if($module == 'delUser') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`cuentas` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		0,
    	$params['id']
		
	);

	$Usuario->insert($prepareStatement,$arrayString);
	echo $params['id'];
}

if($module == 'addUser') {
	$fecha_alta = date("Y-m-d H:i:s");
	$prepareStatement = "UPDATE`cuentas` SET `estatus` = ? WHERE id = ?;
					";
	$arrayString = array (
		1,
    	$params['id']
		
	);

	$Usuario->insert($prepareStatement,$arrayString);
	echo $params['id'];
}

if($module == 'masivoUsers') {

	$eventoMasivo = new CargasMasivas();

	$hojaDeUsuarios = $eventoMasivo->loadFile($_FILES);

	$consecutivo = 1;
	$insert_values = array();
	$fecha = date ( 'Y-m-d H:m:s' );
	$numeroMayorDeFila = $hojaDeUsuarios->getHighestRow(); // Numérico
	$letraMayorDeColumna = $hojaDeUsuarios->getHighestColumn(); // Letra
	$Existe = array();
	$Nuevo = array();
	# Convertir la letra al número de columna correspondiente
	$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

	for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {

		$proveedor = $hojaDeUsuarios->getCellByColumnAndRow(1, $indiceFila);
		$nombre = $hojaDeUsuarios->getCellByColumnAndRow(2, $indiceFila);
		$email = $hojaDeUsuarios->getCellByColumnAndRow(3, $indiceFila);
		$password = $hojaDeUsuarios->getCellByColumnAndRow(4, $indiceFila);
		$segurosocial = $hojaDeUsuarios->getCellByColumnAndRow(5, $indiceFila);
		$fechaNacimiento = $hojaDeUsuarios->getCellByColumnAndRow(6, $indiceFila);
		$rfc = $hojaDeUsuarios->getCellByColumnAndRow(7, $indiceFila);
		$fechaIngreso = $hojaDeUsuarios->getCellByColumnAndRow(9, $indiceFila);
		$telefono = $hojaDeUsuarios->getCellByColumnAndRow(8, $indiceFila);
		$tipo = $hojaDeUsuarios->getCellByColumnAndRow(10, $indiceFila);
		$territorial = $hojaDeUsuarios->getCellByColumnAndRow(11, $indiceFila);
		$cve = $hojaDeUsuarios->getCellByColumnAndRow(12, $indiceFila);

		//$fechaNacimiento = str_replace('/','-',$fechaNacimiento);
		//$fechaNacimiento =  date('Y-m-d H:m:s', strtotime($fechaNacimiento));
		//$fechaIngreso = str_replace('/','-',$fechaIngreso);
		//$fechaIngreso =  date('Y-m-d H:m:s', strtotime($fechaIngreso));
		$territorioExist = $Usuario->getTerritorio($territorial->getValue()) ;
		$territorio = $territorioExist ? $territorioExist : 0;
		$tipoExist = $Usuario->getTipoUserId($tipo);
		$tipoUsuario = $tipoExist ? $tipoExist : 0 ;
		$usuarioExiste = $Usuario->searchUser($email);
		
		if( sizeof($usuarioExiste) == 0 ) {

			$datafieldsCuentas = array('pass','tipo_user','cve','nombre','correo','fecha_alta','estatus','supervisor','territorial');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsCuentas), '?'));

			$sql = "INSERT INTO cuentas (" . implode(",", $datafieldsCuentas ) . ") VALUES (".$question_marks.")"; 
			
			$arrayString = array (
				sha1($password),
				$tipoUsuario,
				'037',
				$nombre, 
				$email,
				$fecha,
				1,
				0,
				$territorio
			);
		
			$newUserId = $Usuario->insert($sql,$arrayString);

			//ALta Detalle Usuarios
			$datafieldsdetalle = array('nombre','telefono','email','cuenta_id');
	
			$question_marks = implode(', ', array_fill(0, sizeof($datafieldsdetalle), '?'));

			$sql = "INSERT INTO detalle_usuarios (" . implode(",", $datafieldsdetalle ) . ") VALUES (".$question_marks.")"; 
			
			$arrayString = array (
				$nombre,
				$telefono, 
				$email,
				$newUserId
			);
		
			$newDetalleId = $Usuario->insert($sql,$arrayString);

			array_push($Nuevo,$email) ;
		}  else {

			$prepareStatement = "UPDATE  `cuentas` SET `cve`=?,`tipo_user`=?,`nombre`=?,`fecha_alta`=?,`territorial`=?,`pass`=?  WHERE `id`=? ; ";
			$arrayString = array (
				$cve,
				$tipoUsuario,
				$nombre,
				$fecha,
				$territorio,
				sha1($password),
				$usuarioExiste[0]['Id']
			);

			$Usuario->insert($prepareStatement,$arrayString);
	
			
			$prepareStatement = "UPDATE `detalle_usuarios` SET `nombre`=?,`email`=?,`territorial`=?,`fecha_ingreso`=? WHERE `cuenta_id`=? ; ";

			$arrayString = array (
				$nombre,
				$email,
				$territorio,
				$fecha,
				$usuarioExiste[0]['Id']
			);

			$Usuario->insert($prepareStatement,$arrayString);		
		 
			array_push($Existe,$email) ;
		}

	}

	echo json_encode(["cantidad" => $numeroMayorDeFila,"existe" => $Existe,"Nuevo" => $Nuevo ]);
} 

?>