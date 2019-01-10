<?php

class TurnosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function api()
    {
        $accion = Request::post('accion');
        $resultado = "";
        switch ($accion) {
            case "calendario":
                $resultado = TurnosModel::calendar(Request::post('departamento'), Request::post('mes'),Request::post('ano'));
                break;
            case "calendarioSimple":
                $resultado = TurnosModel::simpleCalendar(Request::post('departamento'), Request::post('mes'),Request::post('ano'),Request::post('semana'));
                break;
            case "profesionales":
                $resultado = UserModel::getPublicProfilesOfAllUsers();
                break;
            case "profesionalesDepartamento":
                $resultado = UserModel::getPublicProfilesOfAllUsersAndDepartaments();
                break;
            case "turnos":
                $resultado = TurnosModel::getAllTurnos(Request::post('dia'),Request::post('mes'), Request::post('ano'));
                break;
            case "turnosUno":
                $resultado = TurnosModel::getTurno(Request::post('id'));
                break;
            case "turnosNuevo":
                $resultado = TurnosModel::createTurnos(Request::post('profesional'),Request::post('fechainic'),Request::post('turno'),Request::post('departamento_id'));
                break;
            case "turnosEliminar":
                $resultado = TurnosModel::deteleTurnos(Request::post('id'));
                break;
            case "turnosCambiar":
                $resultado = TurnosModel::changeTurnos(Request::post('id'), Request::post('profesional'), Request::post('profesional_nombre'));
                break;
            case "comentario":
                $resultado = TurnosModel::getComentario(Request::post('fecha'), Request::post('departamento_id'));
                break;
            case "comentarioGuardar":
                $resultado = TurnosModel::createComentario(Request::post('fecha'), Request::post('text'), Request::post('departamento_id'));
                break;
            case "comentarioUpdate":
                $resultado = TurnosModel::updateComentario(Request::post('id'), Request::post('text'), Request::post('departamento_id'));
                break;
            case "sumaturnos":
                $resultado = TurnosModel::countTurno(Request::post('mes'), Request::post('ano'), Request::post('profesional'), Request::post('departamento_id'));
                break;
            case "user_id_profesional":
                $resultado = TurnosModel::getIdProfesional(Session::get('user_id'));
                break;
            case "profesionalBasic":
                $resultado = TurnosModel::getAllProfesionalesBasic();
                break;
            case "user_id_set":
                $resultado = TurnosModel::setIdProfesional(Request::post('id'));
                break;
            case "contrasena":
                $resultado = PasswordResetModel::changePassword(Session::get('user_id'), Request::post('user_password_current'), Request::post('user_password_new'), Request::post('user_password_repeat'));
                break;
            case "email":
                $resultado = UserModel::editUserEmail(Request::post('user_email'));
                break;
            case "nombre":
                $resultado = UserModel::saveUserName(Request::post('user_nombre'));
                break;
            case "telefono":
                $resultado = UserModel::saveTelefono(Request::post('user_telefono'));
                break;
            case "departamentos":
                $resultado = DepartamentoModel::getAllDepartamentos();
                break;
            case "departamento":
                $resultado = DepartamentoModel::getDepartamento(Request::post('departamento_id'));
                break;
            case "departamentosNuevo":
                $resultado = DepartamentoModel::createDepartamento(Request::post('departamento_name'), Request::post('departamento_jefe'));
                break;
            case "departamentosUpdate":
                $resultado = DepartamentoModel::updateDepartamento(Request::post('departamento_id'), Request::post('departamento_name'), Request::post('departamento_jefe'));
                break;
            case "departamentosEliminar":
                $resultado = DepartamentoModel::deleteDepartamento(Request::post('departamento_id'));
                break;
            case "profesionalesFiltrados":
                $resultado = UserModel::getPublicProfilesOfAllUsersAndDepartamentsFilter(Request::post('departamento_id'));
                break;
            case "userDepartamentoNew":
                $resultado = DepartamentoModel::createUserDepartamento(Request::post('departamento_id'), Request::post('user_id'));
                break;
            case "default":
                $resultado = TurnosModel::getProfesionalesDefault(Request::post('departamento_id'), Request::post('mes'), Request::post('ano'));
                break;
            case "defaultOne":
                $resultado = TurnosModel::getProfesionalDefault(Request::post('id'));
                break;
            case "defaultNuevo":
                $resultado = TurnosModel::createProfesionalDefault(Request::post('departamento_id'), Request::post('default_fecha'),Request::post('profesional'));
                break;
            case "defaultUpdate":
                $resultado = TurnosModel::updateProfesionalDefault(Request::post('id'),Request::post('profesional'));
                break;
        }
        return $this->View->renderJSON($resultado);

    }
}