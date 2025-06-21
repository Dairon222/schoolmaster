<?php

include_once 'conn.php';
session_start();

// Verifica al usuario para iniciar sesión

if (isset($_SESSION['administrator'])) {
    $login = $conn->prepare('SELECT * FROM administrator WHERE email = ?');
    $login->bindParam(1, $_SESSION['administrator']);
    $login->execute();
    $result = $login->fetch(PDO::FETCH_ASSOC);
    if (is_array($result)) {
?>

        <!DOCTYPE html>
        <html lang="es-CO" class="h-100">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sección administradores</title>

            <!--Favicon-->
            <link rel="shortcut icon" href="../assets/media/logo.png" type="image/x-icon">

            <!--SEO Tags-->
            <meta name="author" content="Justapp">

            <!--Optimization Tags-->
            <meta name="theme-color" content="#000000">
            <meta name="MobileOptimized" content="width">
            <meta name="HandlhledFriendly" content="true">
            <meta name="mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="black-traslucent">

            <!--Styles and complements Bootstrap 5.3-->
            <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
            <!--styles Icons Bootstrap-->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        </head>

        <body style="background-color: #FEFFEF;">
            <header>
                <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" style="background-color: #F6ECE2;">
                    <div class="container-fluid">
                        <a class="navbar-brand d-flex align-items-center" href="?page=home">
                            <img src="../assets/media/logo.png" alt="logo" height="50" class="me-2">
                            <span class="fs-4 text-dark"><strong>School</strong><span style="color: #008B9D;">Master</span></span>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
                            aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarAdmin">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="?page=home">
                                        <i class="bi bi-house-door-fill me-1"></i>Inicio
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="?page=profilea">
                                        <i class="bi bi-person-fill me-1"></i>Perfil
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="?page=pubs">
                                        <i class="bi bi-megaphone-fill me-1"></i>Publicaciones
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-danger fw-bold" href="logout">
                                        <i class="bi bi-box-arrow-right me-1"></i>Salir
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="container pt-5">
                <?php
                $page = isset($_GET['page']) ? strtolower($_GET['page']) : 'home';
                $pagePath = './' . $page . '.php';

                if (file_exists($pagePath)) {
                    require_once $pagePath;

                    if ($page === 'home') {
                        require_once './init.php';
                    }
                } else {
                    echo "<div class='container mt-5 pt-5'><div class='alert alert-warning shadow-sm'>La página solicitada no existe.</div></div>";
                }
                ?>

            </main>
            <!--Complements JS-->
            <script src="../assets/js/bootstrap.bundle.min.js"></script>
            <!--Script visualización password-->
            <script src="../assets/js/password.viewer.js"></script>
    <?php
    }
} else {
    header('Location: ../');
}
    ?>
        </body>

        </html>