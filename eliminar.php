<?php

include_once 'horario.php';

$horario = new horario();
$idhorario = isset($_REQUEST['horario']) ? $_REQUEST['horario'] : '';

$resp = $horario->mantenimientoHorario(2, $idhorario, '', '', '');

echo json_encode(array('msj' => $resp[0]['msj'], 'icon' => $resp[0]['icon']));

