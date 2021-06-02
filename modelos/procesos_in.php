<?php
//error_reporting( error_reporting() & ~E_NOTICE ); //undefined Problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('procesos_db.php');

$params = $_REQUEST;

$module = $params['module'];

if($module == 'getProcesosActivos') {

    $rows = $Procesos->getCargasEnProceso($params['tipo']);
	echo json_encode($rows);
}

if($module == 'getProcesos') {

    $rows = $Procesos->getProcesos($params,true);
    $rowsTotal = $Procesos->getProcesos($params,false);
    $data = array("draw"=>$_POST['draw'],"data" =>$rows,'recordsTotal' =>  count($rowsTotal), "recordsFiltered" => count($rowsTotal) );

	echo json_encode($data); //$val;
}

if($module == 'getODTNoProcesados') {

    $rows = $Procesos->getODTNoProcesados($params['id']);

    echo  $rows;
}



?>