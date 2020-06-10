<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once 'horario.php';

$horario = new horario();

$cursos = $horario->consultacurso();
$horas = $horario->consultahoras();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <title></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1></h1>
            <div class="row">
                <div class="col-lg-10">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miercoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                                <th>Sabado</th>
                                <th>Domingo</th>
                            </tr>

                            <?php foreach ($horas as $hora) { ?>
                                <tr>
                                    <td><?php echo $hora['inicio'] . ' - ' . $hora['fin']; ?></td>
                                    <?php
                                    for ($c = 1; $c <= 7; $c++) {
                                        $datoscursos = $horario->consultahorarioCurso($c, $hora['idhora']);
                                        if (count($datoscursos) > 0) {
                                            foreach ($datoscursos as $value) {
                                                ?>
                                                <td id="td<?php echo $hora['idhora'] . $c; ?>" class="dropzone" idhora="<?php echo $hora['idhora']; ?>" iddia="<?php echo $c ?>" idhorario="<?php echo $value['idhorariocurso'] ?>"><a style='margin-left:4px;' href='javascript:void(0)' onclick="eliminarhorario('td<?php echo $hora['idhora'] . $c; ?>')"><i class='fa fa-trash-o'></i> Eliminar</a><?php echo $value['nombre'] ?></td>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td id="td<?php echo $hora['idhora'] . $c; ?>" class="dropzone" idhora="<?php echo $hora['idhora']; ?>" iddia="<?php echo $c ?>" idhorario=""></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php } ?>

                        </thead>
                    </table>
                </div>
                <div class="col-lg-2">
                    <?php
                    foreach ($cursos as $curso) {
                        ?>
                        <div idcurso="<?php echo $curso['idcurso'] ?>" draggable="true" ondragstart="event.dataTransfer.setData('text/plain',null)" style="border: 1px solid red;margin-bottom: 5px;padding: 5px;border-radius:4px;"><?php echo $curso['nombre']; ?></div>
                    <?php } ?>
                </div>
            </div>

        </div>
        <script>
            crearmovimiento();
            function crearmovimiento() {
                var dragged;
                var copia;
                var idcurso;
                /* events fired on the draggable target */
                document.addEventListener("drag", function (event) {

                }, false);

                document.addEventListener("dragstart", function (event) {
                    // store a ref. on the dragged elem
                    dragged = event.target;
                    // make it half transparent
                    event.target.style.opacity = .5;

                    idcurso = event.target.getAttribute("idcurso");

                    copia = "<div> <a style='margin-left:4px;' href='javascript:void(0)'><i class='fa fa-trash-o'></i> Eliminar</a>" + dragged.innerHTML + "</div>";

                    event.dataTransfer.setData('Text', copia);

                }, false);

                document.addEventListener("dragend", function (event) {
                    // reset the transparency
                    event.target.style.opacity = "";
                }, false);

                /* events fired on the drop targets */
                document.addEventListener("dragover", function (event) {
                    // prevent default to allow drop
                    event.preventDefault();
                }, false);

                document.addEventListener("dragenter", function (event) {
                    // highlight potential drop target when the draggable element enters it
                    if (event.target.className == "dropzone") {
                        event.target.style.background = "#EAF0E7";
                    }

                }, false);

                document.addEventListener("dragleave", function (event) {
                    // reset background of potential drop target when the draggable element leaves it
                    if (event.target.className == "dropzone") {
                        event.target.style.background = "";
                    }

                }, false);

                document.addEventListener("drop", function (event) {
                    // prevent default action (open as link for some elements)
                    event.preventDefault();
                    // move dragged elem to the selected drop target
                    if (event.target.className == "dropzone") {
                        event.target.style.background = "";

                        event.target.innerHTML = event.dataTransfer.getData("Text");
                        var hora = event.target.getAttribute("idhora");
                        var dia = event.target.getAttribute("iddia");
                        var idtd = event.target.getAttribute("id");
                        var idhorario = event.target.getAttribute("idhorario");
                        var curso = idcurso;

                        $("#" + idtd + " > div > a").click(function () {
                            eliminarhorario(idtd);
                        });

                        guardarhorario(hora, dia, curso, idtd);


                        event.target.style.height = "auto";

                    }

                }, true);
            }
            function guardarhorario(hora, dia, curso, idtd) {
                var data = {hora: hora, dia: dia, curso: curso};
                var url = "guardar.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function (r) {
                        var d = JSON.parse(r);
                        $('#' + idtd).attr('idhorario', d['id']);
                        swal({
                            title: '',
                            text: d['msj'],
                            icon: d['icon']
                        });
                    }
                });
            }
            function eliminarhorario(idtd) {
                var data = {horario: $('#' + idtd).attr('idhorario')};
                var url = "eliminar.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function (r) {
                        var d = JSON.parse(r);
                        $("#" + idtd).empty();
                        $("#" + idtd).css("height", "50px");
                        swal({
                            title: '',
                            text: d['msj'],
                            icon: d['icon']
                        });
                    }
                });
            }
        </script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>
</html>
