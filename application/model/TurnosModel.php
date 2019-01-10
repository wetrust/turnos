<?php

class TurnosModel
{
    public static function calendar($departamento, $mes, $ano){
        
        try {
            $fecha = new DateTime($ano . '-' . $mes .'-01');
            $diaDeLaSemana = $fecha->format('N'); 
            $diasEnElMes = $fecha->format('t');

            $return = new stdClass();
            $return->fecha = $fecha;
            $return->diaDeLaSemana = $diaDeLaSemana;
            $return->diasEnElMes = $diasEnElMes;
            $return->default = self::getProfesionalesDefault($departamento, $mes, $ano);
            $return->turnos = self::getMonthTurnos($departamento, $mes, $ano);
            $return->comentarios = self::getAllComentarios($mes, $ano, $departamento);

            return $return;

        } catch (Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
    }

    public static function simpleCalendar($departamento, $mes, $ano, $semana){

        $fecha = new DateTime($ano . '-' . $mes .'-01');
        $diaDeLaSemana = $fecha->format('N') -1; 
        $database = DatabaseFactory::getFactory()->getConnection();

        $return = new stdClass();

        $semana_ini = 1;
        $semana_fin = 0;

        if ($semana == 1){
            $intervalo = "P". $diaDeLaSemana."D";
            $Lunes = $fecha->sub(new DateInterval($intervalo));
            $semana_ini = $Lunes->format('d');
            $semana_fin = 7 - $diaDeLaSemana;
            $return->mesAnt = $Lunes->format('t');
            $return->mesPres = 0;
            $mesA = intval($mes) -1;
            if ($mesA < 10){
                $mesA =  "0". $mesA; 
            }
            if ($semana_ini < 10){
                $semana_ini = '0'. $semana_ini;
            }
            $fecha1 = "$ano-$mesA-$semana_ini";
            if ($semana_fin < 10){
                $semana_fin = '0'. $semana_fin;
            }
            $fecha2 = "$ano-$mes-$semana_fin";
        }
        else{
            $semana_ini = ((7 * ($semana -1)) - $diaDeLaSemana)+1;
            $semana_fin = (7 * $semana) - $diaDeLaSemana;
            $return->mesAnt = 0;
            if ($semana_fin > $fecha->format('t')){
                $return->mesPres = $fecha->format('t');
            }
            else{
                $return->mesPres = 0;
            }
            if ($semana_ini < 10){
                $semana_ini = '0'. $semana_ini;
            }
            $fecha1 = "$ano-$mes-$semana_ini";
            if ($semana_fin < 10){
                $semana_fin = '0'. $semana_fin;
            }
            $fecha2 = "$ano-$mes-$semana_fin";
        }

        $return->semana_ini = $semana_ini;
        $return->semana_fin = $semana_fin;

        $sql = "SELECT default_turno.turno_profesional, default_turno.default_fecha, users.user_nombre FROM default_turno INNER JOIN users ON default_turno.turno_profesional = users.user_id WHERE default_turno.turno_departamento = :departamento AND default_turno.default_fecha BETWEEN :turno_fechain AND :turno_fechaout ORDER BY default_turno.default_fecha";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento' => $departamento, ':turno_fechain' => $fecha1, ':turno_fechaout' => $fecha2));

        $return->data = $query->fetchAll();
        return $return;

    }

    public static function getMonthTurnos($departamento,$mes, $ano)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $fecha1 = $ano . "-" . $mes . "-" .'-01';
        $fecha = new DateTime($ano . '-' . $mes .'-01');
        $fecha2 = $ano . "-" . $mes . "-" . $fecha->format('t');

        $sql = "SELECT turnos.turno_id, turnos.turno_departamento, turnos.turno_profesional, turnos.turno_fechain, turnos.turno_turno, users.user_nombre FROM turnos INNER JOIN users ON turnos.turno_profesional = users.user_id WHERE turnos.turno_departamento = :departamento AND turnos.turno_fechain BETWEEN :turno_fechain AND :turno_fechaout";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento' => $departamento, ':turno_fechain' => $fecha1, ':turno_fechaout' => $fecha2));
        
        return $query->fetchAll();
    }

    public static function getProfesionalesTurnos($fecha, $departamento_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT turno_id, turno_profesional, turno_fechain, turno_turno, turno_departamento FROM turnos WHERE turno_fechain = :turno_fechain AND turno_departamento = :turno_departamento";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_fechain' => $fecha, ':turno_departamento' => $departamento_id));

        return $query->fetchAll();
    }


    public static function getProfesionalesDefault($departamento_id,$mes, $ano)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $fecha1 = $ano . "-" . $mes . "-" .'-01';
        $fecha = new DateTime($ano . '-' . $mes .'-01');
        $fecha2 = $ano . "-" . $mes . "-" . $fecha->format('t');

        $sql = "SELECT default_turno.default_id, default_turno.turno_profesional, default_turno.default_fecha, users.user_nombre FROM default_turno INNER JOIN users ON default_turno.turno_profesional = users.user_id WHERE default_fecha BETWEEN :turno_fechain AND :turno_fechaout AND turno_departamento = :turno_departamento";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_fechain' => $fecha1, ':turno_fechaout' => $fecha2, ':turno_departamento' => $departamento_id));

        return $query->fetchAll();
    }

    public static function countTurno($mes, $ano, $profesional, $departamento_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $fecha1 = $ano . "-" . $mes . "-" .'-01';
        $fecha = new DateTime($ano . '-' . $mes .'-01');
        $fecha2 = $ano . "-" . $mes . "-" . $fecha->format('t');

        $sql = "SELECT turno_turno FROM turnos WHERE turno_departamento = :departamento_id AND turno_turno = 0 AND turno_profesional = :profesional AND turno_fechain BETWEEN :turno_fechain AND :turno_fechaout";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id'  => $departamento_id, ':profesional' => $profesional, ':turno_fechain' => $fecha1, ':turno_fechaout' => $fecha2));

        $dia =  $query->rowCount();

        $sql = "SELECT turno_turno FROM turnos WHERE turno_departamento = :departamento_id AND turno_turno = 1 AND turno_profesional = :profesional AND turno_fechain BETWEEN :turno_fechain AND :turno_fechaout";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id'  => $departamento_id,':profesional' => $profesional, ':turno_fechain' => $fecha1, ':turno_fechaout' => $fecha2));

        $noche =  $query->rowCount();

        $return = new stdClass();
        $return->conteo = (($dia + $noche) * 12) . ' Hrs ( ' . ($dia + $noche) . ' turnos )';
        return $return;
    }

    public static function getAllTurnos($dia, $mes, $ano)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $fecha = $ano . "-" . $mes . "-" . $dia;
        $sql = "SELECT turnos.turno_id, turnos.turno_profesional, turnos.turno_fechain, turnos.turno_turno, users.user_nombre FROM turnos WHERE turno_fechain = :turno_fechain INNER JOIN users ON turnos.turno_profesional = users.user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_fechain' => $fecha));

        return $query->fetchAll();
    }

    public static function getTurno($id_turno)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT turnos.turno_id, turnos.turno_profesional, turnos.turno_fechain, turnos.turno_turno, users.user_nombre FROM turnos INNER JOIN users ON turnos.turno_profesional = users.user_id WHERE turno_id = :turno_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_id' => $id_turno));

        return $query->fetch();
    }

    public static function getProfesionalDefault($default_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT default_turno.default_id, default_turno.turno_profesional, default_turno.default_fecha, users.user_nombre FROM default_turno INNER JOIN users ON default_turno.turno_profesional = users.user_id WHERE default_id = :default_id";
        $query = $database->prepare($sql);
        $query->execute(array(':default_id' => $default_id,));

        return $query->fetch();
    }
    
    public static function createTurnos($profesional, $fechainic,$turno, $departamento_id)
    {
        $return = new stdClass();
        $return->resultado = false;

        if (!$profesional) {
            $return->resultado = false;
        }

        if ($turno == 2){
            $return->resultado = self::createTurnos($profesional,$fechainic,0, $departamento_id);
            $return->resultado = self::createTurnos($profesional,$fechainic,1, $departamento_id);
        }
        else {
            $database = DatabaseFactory::getFactory()->getConnection();

            $sql = "SELECT turno_profesional, turno_fechain, turno_turno, turno_departamento FROM turnos WHERE turno_profesional = :turno_profesional AND turno_fechain = :turno_fechain AND turno_turno = :turno_turno";
            $query = $database->prepare($sql);
            $query->execute(array(':turno_profesional' => $profesional, ':turno_fechain' => $fechainic, ':turno_turno' => intval($turno)));

            if ($query->rowCount() == 1) {
                $return->resultado = true;
            }
            else{
                $sql = "INSERT INTO turnos (turno_profesional, turno_fechain, turno_turno, turno_departamento) VALUES (:turno_profesional, :turno_fechain, :turno_turno, :turno_departamento)";
                $query = $database->prepare($sql);
                $query->execute(array(':turno_profesional' => $profesional, ':turno_fechain' => $fechainic, ':turno_turno' => intval($turno), ':turno_departamento' => $departamento_id));

                if ($query->rowCount() == 1) {
                    $return->resultado = true;
                }
            }
        }

        return $return;
    }

    public static function changeTurnos($turno_id, $turno_profesional, $turno_profesional_nombre)
    {
        if (!$turno_id || !$turno_profesional) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE turnos SET turno_profesional = :turno_profesional WHERE turno_id = :turno_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_profesional' => $turno_profesional, ':turno_id' => $turno_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    public static function deleteTurnos($turno_id)
    {
        if (!$turno_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM turnos WHERE turno_id = :turno_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_id' => $turno_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_DELETION_FAILED'));
        return false;
    }

    public static function getAllComentarios($mes, $ano, $departamento_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $fecha1 = $ano . "-" . $mes . "-" .'-01';
        $fecha = new DateTime($ano . '-' . $mes .'-01');
        $fecha2 = $ano . "-" . $mes . "-" . $fecha->format('t');

        $sql = "SELECT comentario_id, comentario_fecha, comentario_text FROM comentarios WHERE departamento_id = :departamento_id AND comentario_fecha BETWEEN :comentario_fechain AND :comentario_fechaout";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id' => $departamento_id,':comentario_fechain' => $fecha1, ':comentario_fechaout' => $fecha2));

        return $query->fetchAll();
    }

    public static function getComentario($comentario_fecha, $departamento_id)
    {
        $return = new stdClass();
        $return->autorizado = false;

        $turnos = self::getProfesionalesTurnos($comentario_fecha, $departamento_id);

        foreach ($turnos as $turno) {
            if ($turno->turno_profesional == Session::get('user_id')){
                $return->autorizado = true;
            }
        }

        if ($return->autorizado){
            $database = DatabaseFactory::getFactory()->getConnection();

            $sql = "SELECT comentario_id, comentario_fecha, comentario_text, departamento_id FROM comentarios WHERE comentario_fecha = :comentario_fecha AND departamento_id = :departamento_id LIMIT 1";
            $query = $database->prepare($sql);
            $query->execute(array(':comentario_fecha' => $comentario_fecha, ':departamento_id' => $departamento_id));

            if ($query->rowCount() == 1) {
                $return->comentario = $query->fetch();
            }
            else{
                $return->comentario = '';
            }
        }

        return $return;
    }

    public static function createComentario($fecha,$text,$departamento_id)
    {
        if (!$fecha) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return 'fuck';
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO comentarios (comentario_fecha, comentario_text, departamento_id) VALUES (:comentario_fecha, :comentario_text, :departamento_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':comentario_fecha' => $fecha, ':comentario_text' => $text, ':departamento_id' => $departamento_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function createProfesionalDefault($departamento_id, $fecha, $turno_profesional)
    {
        $return = new stdClass();
        $return->resultado = false;

        if (!$turno_profesional) {
            $return->resultado = false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT turno_profesional FROM default_turno WHERE turno_profesional = :turno_profesional AND default_fecha = :default_fecha AND turno_departamento = :turno_departamento";
        $query = $database->prepare($sql);
        $query->execute(array(':turno_profesional' => $turno_profesional, ':default_fecha' => $fecha, ':turno_departamento' => $departamento_id));

        if ($query->rowCount() == 1) {
            $return->resultado = true;
        }
        else {
            $sql = "INSERT INTO default_turno (turno_profesional, default_fecha, turno_departamento) VALUES (:turno_profesional, :default_fecha, :turno_departamento)";
            $query = $database->prepare($sql);
            $query->execute(array(':turno_profesional' => $turno_profesional, ':default_fecha' => $fecha, ':turno_departamento' => $departamento_id));

            if ($query->rowCount() == 1) {
                $return->resultado = true;
                self::createTurnos($turno_profesional, $fecha, 2, $departamento_id);
            }
        }

        return $return;
    }

    public static function updateProfesionalDefault($default_id, $turno_profesional)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE default_turno SET turno_profesional = :turno_profesional WHERE default_id = :default_id";
        $query = $database->prepare($sql);
        $query->execute(array(':default_id' => $default_id,':turno_profesional' => $turno_profesional));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function updateComentario($comentario_id, $text, $departamento_id)
    {
        if (!$comentario_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE comentarios SET comentario_text = :comentario_text WHERE comentario_id = :comentario_id AND departamento_id = :departamento_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':comentario_text' => $text, ':comentario_id' => $comentario_id, ':departamento_id' => $departamento_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }
}