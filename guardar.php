<?php

include_once 'horario.php';

$horario = new horario();
$idhorario = isset($_REQUEST['horario']) ? $_REQUEST['horario'] : '';
$idhora = isset($_REQUEST['hora']) ? $_REQUEST['hora'] : '';
$idcurso = isset($_REQUEST['dia']) ? $_REQUEST['curso'] : '';
$dia = isset($_REQUEST['curso']) ? $_REQUEST['dia'] : '';

$resp = $horario->mantenimientoHorario(1, $idhorario, $idhora, $idcurso, $dia);

echo json_encode(array('msj' => $resp[0]['msj'], 'icon' => $resp[0]['icon'],'id'=> $resp[0]['horario']));
