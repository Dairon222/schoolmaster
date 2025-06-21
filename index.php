<?php

/*Validación de usuarios
Seguridad de la aplicación*/

include 'app/conn.php';
session_start();

/*Validar si el usuario ya se encuentra Logueado
Si el usuario ya se encuentra logueado, redirigirlo a la pagina de inicio */

if (isset($_SESSION['administrator'])) {
    header('Location: app/home');
    exit();
}

if (isset($_POST['btn-login'])) {
    $login = $conn->prepare('SELECT * FROM administrator WHERE email = ?');
    $login->bindParam(1, $_POST['email']);
    $login->execute();
    $result = $login->fetch(PDO::FETCH_ASSOC);

    if (is_array($result)) {
        if (password_verify($_POST['password'], $result['password'])) {
            $_SESSION['administrator'] = $result['email'];
            $_SESSION['idadministrator'] = $result['idadministrator'];
            header('Location: app/home');
        } else {
            $msg = array("Contraseña incorrecta", "warning");
        }
    } else {
        $msg = array("El correo no existe", "danger");
    }
}
?>

<!DOCTYPE html>
<html lang="es-CO">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchoolMaster</title>
    <link rel="shortcut icon" href="assets/media/logo.png" type="image/x-icon">
    <meta name="author" content="Justapp">
    <meta name="description" content="Sistema de gestión administrativa escolar">
    <meta name="keywords"
        content="SchoolMaster, Schoolmaster, SCHOOLMASTER, schoolmaster, Sistema de gestión, SISTEMA DE GESTIÓN, sistema de gestión, Gestión, GESTIÓN, gestion, Administración escolar, ADMINISTRACIÓN ESCOLAR, administración escolar, Directivas docentes, DIRECTIVAS DOCENTES, directivas docentes, Gestión docente, GESTIÓN DOCENTE, gestión docente">
    <meta name="theme-color" content="#008b9d">
    <meta name="MobileOptimized" content="width">
    <meta name="HandlhledFriendly" content="true">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-wep-app-status-bar-style" content="black-translucent">
    <!--Styles Bootstrap-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!---Scripts Bootstrap-->
    <script src="assets/js/bootstrap.bundle.js"></script>
    <!--icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--¿Cómo esconder el "#" hash de una url-->
    <script type="text/javascript">
        window.onhashchange = function() {
            window.history.pushState('', document.title, window.location.pathname)
        }
    </script>
</head>

<body class="bg-image" style="background-image: url('assets/media/fondo.jpg'); height: 100vh;">


    <!--Modal de inicio de sesión-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #F6ECE2;">
                <div class="modal-header" style="background-color: #F6ECE2;">
                    <i class="bi bi-person-circle d-flex justify-content-center m-2" style="font-size: 25px; color: #008B9D;"></i>
                    <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--Alerts-->
                <?php if (isset($msg)) { ?>

                    <div class="m-3 alert alert-<?php echo $msg[1]; ?> alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <?php echo $msg[0]; ?>.
                    </div>

                <?php } ?>
                <!--Alerts-->

                <div class="modal-body rounded" style="background-color: #F6ECE2;">
                    <form action="" method="post" enctype="application/x-www-form-urlencoded">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo" name="email" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña" name="password" required>
                        </div>
                        <button name="btn-login" type="submit" class="btn w-100 text-white" style="background-color: #68BDA2;">Ingresar</button>
                        <div class="text-center mt-3">
                            <a href="app/pass_recovery.php">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal de inicio de sesión-->

    <header>
        <nav class="navbar navbar-expand-sm navbar-dark fixed-top" style="background-color: #F6ECE2;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html" style="display: flex;">
                    <img src="assets/media/logo.png" alt="logo" height="60px" width="60px">

                    <div class="mx-3 my-auto d-flex">
                        <h2 class="text-dark"><b>School</b><span style="color: #008B9D;">Master</span></h2>
                    </div>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar" aria-label="boton1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <div class="ms-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <strong><a class="nav-link bold" style="color: #008B9D;"
                                        href="#main">Inicio</a></strong>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#about-us">Nosotros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#contact">Contáctanos</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#loginModal"><b>Iniciar Sesión</b></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section id="main" class="p-4 w-auto h-auto" style="margin-top: 100px;">
            <div class="w-auto row mx-4 rounded-4" style="height: auto; background-color: #F6ECE2;">
                <div class="col-md-6 p-5 d-flex flex-column align-items-start justify-content-center">
                    <h1 class="text-dark display-3" style="font-weight: 600"><b>School</b><span
                            style="color: #008B9D;">Master</span></h1>
                    <p class="fs-4">Tu mejor opción en gestión administrativa en educación.</p>
                    <div>
                        <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#loginModal" style="background-color: #68BDA2;">Empieza ahora</button>
                    </div>
                </div>
                <div class="col-md-6 p-4 d-flex justify-content-center align-items-center">
                    <div class="rounded-4 p-3" style="background-color: #008B9D;">
                        <img class="d-flex align-items-center rounded-4" style="height: 350px;"
                            src="assets/media/Imagen123.jpg" alt="imagen ilustrativa de IEFCD">
                    </div>
                </div>
            </div>
        </section>
        <section id="about-us" class="p-4 w-auto h-auto">
            <div class="w-auto mx-4 rounded-4" style="height: auto; background-color: #F6ECE2;">
                <div class="row">
                    <div class="col-md-6 p-5 d-flex flex-column align-items-start justify-content-center">
                        <h1 class="display-4" style="color: #008B9D;"><b>Nosotros</b></h1>
                        <p class="fs-5">Somos un equipo de estudiantes de ultimo grado inspirados por mejorar las
                            condiciones laborales de el personal administrativo de las instituciones educativas, creando
                            “SchoolMaster” como nuestro proyecto de grado.</p>
                    </div>
                    <div class="col-md-6 p-4 d-flex justify-content-center align-items-center">
                        <div class="rounded-4 p-3" style="background-color: #68BDA2;">
                            <img class="d-flex align-items-center rounded-4" style="height: 350px;"
                                src="assets/media/us.jpg" alt="imagen ilustrativa de IEFCD">
                        </div>
                    </div>
                </div>
                <div class="w-auto row mx-4 rounded-4 d-flex align-items-start py-4" style="height: auto; background-color: #F6ECE2;">
                    <div class="col-md-4 d-flex flex-column text-center">
                        <h1 class="flex-grow-0" style="color: #008B9D;">Misión</h1>
                        <p class="flex-grow-1">Nuestra misión es mejorar la gestión de la institución educativa Celia Duque a través de una plataforma digital eficiente y segura, que facilite la comunicación entre docentes, estudiantes y familias, y que optimice los procesos administrativos.
                        </p>
                    </div>
                    <div class="col-md-4 d-flex flex-column text-center">
                        <h1 class="flex-grow-0" style="color: #008B9D;">Visión</h1>
                        <p class="flex-grow-1">Nuestro sitio web, busca reducir la carga administrativa, mediante herramientas accesibles que permitan hacer la experiencia administrativa mas eficiente a partir del aplicativo “SchoolMaster”.
                        </p>
                    </div>
                    <div class="col-md-4 d-flex flex-column text-center">
                        <h1 class="flex-grow-0" style="color: #008B9D;">Objetivo</h1>
                        <p class="flex-grow-1">Este proyecto tiene como objetivo optimizar la eficiencia de los procesos manuales en la institución, incluyendo la gestión de matrículas e informes como anotaciones y suspensiones. También se pretende crear un horario accesible para los estudiantes, lo que ayudará en la organización de las actividades académicas.
                        </p>
                    </div>
                </div>
            </div>

        </section>
        <section id="contact" class="p-5 w-auto h-auto">
            <div class="w-auto rounded-4 p-5" style="height: auto; background-color: #F6ECE2;">
                <h1 style="font-weight: 600; color: #008B9D;">Contáctanos</h1>
                <ul class="fs-5">
                    <li><a href="mailto:schoolmaster3101@gmail.com">Schoolmaster3101@gmail.com</a></li>
                    <li>@SchoolMaster en Instagram</li>
                </ul>
            </div>
        </section>
    </main>
    <footer class="p-4 d-flex justify-content-center align-items-center" style="height: 140px; background-color: #F6ECE2;">
        <p>&copy; 2025 SchoolMaster. Todos los derechos reservados.</p>
    </footer>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            <?php if (isset($msg)) { ?>
                let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            <?php } ?>
        });
    </script>
</body>

</html>