<?php

/**
 * DepartamentoModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class DepartamentoModel
{
    /**
     * Get all departamentos (departamentos are just example data that the user has created)
     * @return array an array with several objects (the results)
     */
    public static function getAllDepartamentos()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT T1.departamento_id, T1.departamento_name, T1.departamento_jefe, T2.user_nombre, COUNT(T3.departamento_id) AS user_cantidad FROM departamentos AS T1 INNER JOIN users AS T2 ON (T1.departamento_jefe = T2.user_id) LEFT JOIN user_departamento AS T3 ON (T1.departamento_id = T3.departamento_id) group by T1.departamento_id";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    /**
     * Get a single departamento
     * @param int $departamento_id id of the specific departamento
     * @return object a single object (the result)
     */
    public static function getDepartamento($departamento_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT departamentos.departamento_id, departamentos.departamento_name, departamentos.departamento_jefe, users.user_nombre FROM departamentos INNER JOIN users ON (departamentos.departamento_jefe = users.user_id) WHERE departamentos.departamento_id = :departamento_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id' => $departamento_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }

    /**
     * Set a departamento (create a new one)
     * @param string $departamento_text departamento text that will be created
     * @return bool feedback (was the departamento created properly ?)
     */
    public static function createDepartamento($departamento_text, $departamento_jefe)
    {
        if (!$departamento_text || strlen($departamento_text) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO departamentos (departamento_name, departamento_jefe) VALUES (:departamento_name, :departamento_jefe)";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_name' => $departamento_text, ':departamento_jefe' => $departamento_jefe,));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function createUserDepartamento($departamento_id, $user_id)
    {
        if (!$departamento_id) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO user_departamento (departamento_id, user_id) VALUES (:departamento_id, :user_id)";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id' => $departamento_id, ':user_id' => $user_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    /**
     * Update an existing departamento
     * @param int $departamento_id id of the specific departamento
     * @param string $departamento_text new text of the specific departamento
     * @return bool feedback (was the update successful ?)
     */
    public static function updateDepartamento($departamento_id, $departamento_name, $departamento_jefe)
    {
        if (!$departamento_id || !$departamento_name) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE departamentos SET departamento_name = :departamento_name, departamento_jefe = :departamento_jefe WHERE departamento_id = :departamento_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id' => $departamento_id, ':departamento_name' => $departamento_name, ':departamento_jefe' => $departamento_jefe));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    /**
     * Delete a specific departamento
     * @param int $departamento_id id of the departamento
     * @return bool feedback (was the departamento deleted properly ?)
     */
    public static function deleteDepartamento($departamento_id)
    {
        if (!$departamento_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM departamentos WHERE departamento_id = :departamento_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':departamento_id' => $departamento_id,));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_DELETION_FAILED'));
        return false;
    }
}