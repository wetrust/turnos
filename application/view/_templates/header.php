<!doctype html>
<html lang="es-CL">
<head>
    <title>Turnos Clínica Alemana Temuco</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="data:;base64,=">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
    <base href="<?php echo Config::get('URL'); ?>">
    <style>
        .oficina{
            background-image: url('<?php echo Config::get('URL'); ?>img/oficina.jpg');
            background-repeat: no-repeat;
            background-size:cover;
        }
    </style>
</head>
<body class="<?php if (View::checkForActiveController($filename, "login")) { echo 'oficina'; } ?>">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand" href="<?php echo Config::get('URL'); ?>">Turnos Clínica Alemana Temuco</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHome" aria-controls="navbarHome" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHome">
                <ul class="navbar-nav mr-auto">
                    <?php if (Session::get("user_account_type") == 6) : ?>
                        <li class="nav-item"><a class="nav-link" href="#" id="boton.configuracion"><small>Configuración unidad y profesionales</small></a></li>
                        <li class="nav-item"><a class="nav-link" href="#" id="boton.default"><small>Turnos programados</small></a></li>
                        <li class="nav-item"><a class="nav-link" href="#" id="boton.turno"><small>Turnos realizados</small></a></li>
                    <?php endif; ?>
                    <?php if (Session::get("user_account_type") < 3 && Session::get("user_account_type") > 0) : ?>
                        <li class="nav-item"><a class="nav-link" href="#" id="boton.listado.profesionales"><small>Ver listado de profesionales</small></a></li>
                    <?php endif; ?>
                </ul>
                <?php if (Session::userIsLoggedIn()) { ?>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuario activo: <?php echo Session::get('user_name'); ?></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <?php if (Session::get("user_account_type") > 1) : ?>
                                <a class="dropdown-item" href="#" id="boton.pormes">Ver turnos por mes</a>
                            <?php endif; ?>
                                <a class="dropdown-item" href="#" id="boton.imprimir">Ver resumen del mes</a>
                                <a class="dropdown-item" href="#" id="boton.semana">Ver resumen semanal</a>
                                <a class="dropdown-item" href="login/logout">Salir del programa</a>
                                <div class="dropdown-divider"></div>
                                <?php if (Session::get("user_account_type") > 1) : ?>
                                <a class="dropdown-item dropdown-toggle" href="#" id="modificarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Modificar</a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="modificarDropdown">
                                    <a class="dropdown-item" href="#" id="modificar.nombre">Nombre</a>
                                    <a class="dropdown-item" href="#" id="modificar.correo">Correo</a>
                                    <a class="dropdown-item" href="#" id="modificar.contrasena">Contraseña</a>
                                    <a class="dropdown-item" href="#" id="modificar.telefono">Teléfono</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>