<?php
require 'conn.php';
session_start();

if (isset($_POST['btn-rec'])) {
    $email = $_POST['email'];

    $fpass = $conn->prepare('SELECT * FROM administrator WHERE email = ? LIMIT 1');
    $fpass->bindParam(1, $email);
    $fpass->execute();
    $row = $fpass->fetch(PDO::FETCH_ASSOC);

    echo $row['email'];

    if ($fpass->rowCount() > 0) {
        $id = base64_encode($row['id_administrator']);
        $token = md5(uniqid(rand()));

        $uptoken = $conn->prepare('UPDATE administrator SET token = ? WHERE email = ?');
        $uptoken->bindParam(1, $token);
        $uptoken->bindParam(2, $email);
        $uptoken->execute();

        // Prepara el mensaje y el asunto del correo que voy a enviar

        $subject = '=?UTF-8?B?' . base64_encode("Restablecer Contraseña") . "=?=";

        $message = "Mensaje de prueba";

        include 'config.mailer.php';
    }
}

?>
<!DOCTYPE html>
<html lang="es-CO" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

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
                <a class="navbar-brand" href="index.html" style="display: flex;">
                    <img src="../assets/media/logo.png" alt="logo" height="60px" width="60px">

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
                                        href="../">Inicio</a></strong>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="../index.php#about-us">Nosotros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="../index.php#contact">Contáctanos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section style="margin-top: 130px;">
            <div class="rounded d-flex align-items-center justify-content-center m-5 p-5" style="background-color: #F6ECE2;">
                <!--Alerts-->
                <?php if (isset($msg)) { ?>
                    <div class="m-3 alert alert-<?php echo $msg[1]; ?> alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <?php echo $msg[0]; ?>.
                    </div>

                <?php } ?>
                <!--Alerts-->
                <form action="" method="post" enctype="application/x-www-form-urlencoded">
                    <h1>Recuperar contraseña</h1>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su email" name="email" required>
                    </div>
                    <div class="d-grid">
                        <button class="btn text-white" type="submit" name="btn-rec" style="background-color: #68BDA2;">Recuperar contraseña</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <footer class="p-4 d-flex justify-content-center align-items-center" style="height: 140px; background-color: #F6ECE2;">
        <p>&copy; 2025 SchoolMaster. Todos los derechos reservados.</p>
    </footer>
    <!--Complements JS-->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <!--Script visualización password-->
    <script src="../assets/js/password.viewer.js"></script>
</body>

</html>