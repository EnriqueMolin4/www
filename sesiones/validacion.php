<?php
session_start();
include '../modelos/conexion.php';
	
if( !empty( $_POST['user'] ) and !empty( $_POST['pass'] ) ) {



	$user = $_POST['user'];

	$pass = sha1($_POST['pass']);

	$qry = "SELECT cuentas.id,cuentas.tipo_user,cuentas.validacion,cuentas.plaza,cuentas.almacen, detalle_usuarios.nombre, detalle_usuarios.apellidos ,cuentas.cve,cuentas.territorial
			from `cuentas`,detalle_usuarios where cuentas.id = detalle_usuarios.cuenta_id AND correo = '$user' and pass = '$pass'";

	$acces = $conexion->query($qry);

	$row_acces = mysqli_num_rows($acces);



	if( $row_acces > 0) {
		
		$dato_acces = mysqli_fetch_array($acces);
		
		//datos de MEnu 
		$tipoRol = $dato_acces['tipo_user'];

		$sqlMenu = "select url,grupoid,modulo,edit FROM menu,modulousuario
					WHERE menu.id = modulousuario.menu_id
					AND modulousuario.tipo_id = $tipoRol
					and modulousuario.estatus = 1 ";
		$menuqry = $conexion->query($sqlMenu);
		$menu_count = mysqli_num_rows($menuqry);
		 
		
		$module = array();
		$counter = 0;
		while($row = $menuqry->fetch_assoc()) {
		//foreach ( $menu_dato as $key => $value ) {
			//array_push($module,$row['Url']);
			$module[$counter]['group'] = $row['grupoid'];
			$module[$counter]['url'] = $row['url'];
			$module[$counter]['module'] = $row['modulo'];
			$module[$counter]['edit'] = $row['edit'];
			$counter++;
		}
	
	
		$_SESSION['user'] = $user;
		$_SESSION['userid'] = $dato_acces['id'];
		$_SESSION['nombre'] = $dato_acces['nombre'];
		$_SESSION['apellidos'] = $dato_acces['apellidos'];
		$_SESSION['cve_user'] = $dato_acces['cve'];
		$_SESSION['territorial'] = $dato_acces['territorial'];
		$_SESSION['Modules'] = $module;
		$_SESSION['validacion'] = $dato_acces['validacion'];
		$_SESSION['plaza'] = $dato_acces['plaza'];
		$_SESSION['almacen'] = $dato_acces['almacen'];
		$urlRedirect = ''; //'sinttecomprod/index.php';

		switch ($dato_acces['tipo_user']) {

			case '1':

				$_SESSION['tipo_user'] = 'supervisor';
				$_SESSION['user_role'] = 'Supervisor';

			//header('Location: ../index.php');

				break;

			case '2':

				$_SESSION['tipo_user'] = 'almacen';
				$_SESSION['user_role'] = 'Almacen';

			//header('Location: ../index.php');

				break;

			case '3':

				$_SESSION['tipo_user'] = 'tecnico';
				$_SESSION['user_role'] = 'Tecnico';
				//$urlRedirect = 'mobile/index.html';
			header('Location: ../index.php');

				break;

			case '4':

				$_SESSION['tipo_user'] = 'callcenter';
				$_SESSION['user_role'] = 'Call Center';
				//$_SESSION['validacion'] = $dato_acces['validacion'];

			//header('Location: ../index.php');

				break;
			
			case '5':

				$_SESSION['tipo_user'] = 'pdf';
				$_SESSION['user_role'] = 'PDF';

			//header('Location: /index.php');

				break;

			case '7':

				$_SESSION['tipo_user'] = 'admin';
				$_SESSION['user_role'] = 'Administrador';

			//header('Location: ../index.php');

				break;

			case '8':

				$_SESSION['tipo_user'] = 'user';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Usuario';

			//header('Location: ../index.php');

				break;
			case '10':

				$_SESSION['tipo_user'] = 'VO';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Visita Ocular';

			

			break;
			case '11':

				$_SESSION['tipo_user'] = 'supVO';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Supervisor VO';

			break;
			case '12':

				$_SESSION['tipo_user'] = 'supOp';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Supervisor Operativo';

			break;
			case '13':

				$_SESSION['tipo_user'] = 'RH';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Recursos Humanos';

			break;

			case '14':

				$_SESSION['tipo_user'] = 'CA';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Coordinador Almacen';

			break;

			case '15':

				$_SESSION['tipo_user'] = 'AN';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Analista';

			break;

			case '16':

				$_SESSION['tipo_user'] = 'AL';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Almacenista';

			break;
		
			case '17':

				$_SESSION['tipo_user'] = 'callcenterADM';

				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Callcenter ADM';

			break;

			case '18':

				$_SESSION['tipo_user'] = 'consulta';

				$_SESSION['user_role'] = 'Consulta Evaluacion';

			break;

			case '19':

				$_SESSION['tipo_user'] = 'LA';

				$_SESSION['cve'] = $dato_access['cve'];
				$_SESSION['user_role'] = 'Laboratorio';

			break;

			case '20' :
				$_SESSION['tipo_user'] = 'FA';
				$_SESSION['cve'] = $dato_acces['cve'];
				$_SESSION['user_role'] = 'Finanzas';
			break;


		}
		
		
		header("location: http://".$_SERVER['HTTP_HOST']."/www/".$urlRedirect);
		//header("location: https://".$_SERVER['HTTP_HOST']."".$urlRedirect);


	}

	else{

		//echo 'USUARIO O CONTRASEÑA NO VALIDOS';

		session_destroy();
		header("location: http://".$_SERVER['HTTP_HOST']."/www/index.php?msg=1");
		//header("location: http://".$_SERVER['HTTP_HOST']."/index.php?msg=1");

	}

}

else{

	//echo 'LLENA AMBOS CAMPOS';
	session_destroy();
	header("location: http://".$_SERVER['HTTP_HOST']."/www/index.php?msg=2");
	//header("location: http://".$_SERVER['HTTP_HOST']."/index.php?msg=2");


}



?>
