<?php

include '../modelos/api_db.php';

$noserie = $_REQUEST['no_serie'];

$sql = "SELECT * FROM elavon_universo WHERE serie=?";

$result = $Api->select($sql,array($noserie));

echo json_encode(['existe' => sizeof($result), 'data' => $result]);