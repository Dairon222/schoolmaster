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
            <title>Registro administradores</title>

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
                <nav class="navbar navbar-expand-sm navbar-dark fixed-top" style="background-color: #F6ECE2;">
                    <div class="container-fluid">
                        <img src="../assets/media/logo.png" alt="logo" height="60px" width="60px">

                        <div class="mx-3 my-auto d-flex">
                            <h2 class="text-dark"><b>School</b><span style="color: #008B9D;">Master</span></h2>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsibleNavbar" aria-label="boton1">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavbar">
                            <div class="ms-auto">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <strong><a class="nav-link bold" style="color: #008B9D;" href="logout">Salir</a></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <main>
                
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