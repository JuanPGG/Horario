<?php

include_once('mySqli.php');

class horario {

    public function consultacurso() {

        $db = new Conect_MySqli();

        $sql = "SELECT * FROM curso";

        $result = $db->execute($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            $data = array();
        }
        $db->close_db();

        return $data;
    }

    public function consultahoras() {

        $db = new Conect_MySqli();

        $sql = "SELECT * FROM hora";

        $result = $db->execute($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            $data = array();
        }
        $db->close_db();

        return $data;
    }

    public function mantenimientoHorario($flag, $idhorario, $idhora, $idcurso, $dia) {

        $db = new Conect_MySqli();
        $xflag = $db->realescapestring($flag);
        $xidhorario = $db->realescapestring($idhorario);
        $xidhora = $db->realescapestring($idhora);
        $xidcurso = $db->realescapestring($idcurso);
        $xdia = $db->realescapestring($dia);

        $sql = "CALL sp_mantenimientoHorario('$xflag', '$xidhorario', '$xidhora', '$xidcurso', '$xdia')";

        $result = $db->execute($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            $data = array();
        }
        $db->close_db();

        return $data;
    }

    public function consultahorarioCurso($dia, $hora) {

        $db = new Conect_MySqli();

        $sql = "CALL sp_consultaHorarioCurso('$dia','$hora');";

        $result = $db->execute($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            $data = array();
        }
        $db->close_db();

        return $data;
    }

}
