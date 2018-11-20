<!doctype html>
<html lang="en">
<head>
    <title>HUGE</title>
    <!-- META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- send empty favicon fallback to prevent user's browser hitting the server for lots of favicon requests resulting in 404s -->
    <link rel="icon" href="data:;base64,=">
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="<?php echo Config::get('URL'); ?>">HUGE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHome" aria-controls="navbarHome" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHome">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if (View::checkForActiveController($filename, "index")) { echo 'active'; } ?>">
                        <a class="nav-link" href="<?php echo Config::get('URL'); ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item <?php if (View::checkForActiveController($filename, "profile")) { echo 'active'; } ?>">
                        <a class="nav-link" href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
                    </li>
                    <?php if (Session::userIsLoggedIn()) { ?>
                        <li class="nav-item <?php if (View::checkForActiveController($filename, "dashboard")) { echo 'active'; } ?>">
                            <a class="nav-link" href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                        </li>
                        <li class="nav-item <?php if (View::checkForActiveController($filename, "note")) { echo 'active'; } ?>">
                            <a class="nav-link" href="<?php echo Config::get('URL'); ?>note/index">My Notes</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item <?php if (View::checkForActiveController($filename, "register/index")) { echo 'active'; } ?>">
                            <a class="nav-link" href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                        </li>
                    <?php } ?>
                </ul>
                <?php if (Session::userIsLoggedIn()) { ?>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Session::get('user_name'); ?> </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUser">
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/index">My Account</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/changeUserRole">Change account type</a>
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/editAvatar">Edit your avatar</a>
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/editusername">Edit my username</a>
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/edituseremail">Edit my email</a>
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/changePassword">Change Password</a>
                                <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                                <div class="dropdown-divider"></div>
                                <?php if (Session::get("user_account_type") == 7) : ?>
                                    <a class="dropdown-item <?php if (View::checkForActiveController($filename, "admin")) {echo 'active';} ?>" href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav">
                        <li class="nav-item <?php if (View::checkForActiveController($filename, "login/index")) { echo 'active'; } ?>">
                            <a class="btn btn-outline-light my-2 my-sm-0" href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>