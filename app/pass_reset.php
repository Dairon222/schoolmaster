<?php
session_start();
include 'conn.php';

if (isset($_GET['id']) && isset($_GET['token'])) {
    $id = base64_decode($_GET['id']);
    $token = $_GET['token'];

    $rpass = $conn->prepare('SELECT * FROM administrator WHERE id_document=:id AND token = :token');
    $rpass->execute(array(':id'=>$id, ':token'=>$token));
    $row = $rpass->fetch(PDO::FETCH_ASSOC);

    if ($rpass->rowCount() > 0) {
        if (isset($_POST['btn-resetpass'])) {
            $pass = $_POST['pass'];
            $cpass = $_POST['cpass'];
            if ($pass = $cpass) {
                $msg = array("Las contraseñas no coinciden", "danger"); 
            } else {
                $npass = password_hash($pass, PASSWORD_BCRYPT);

                $uppass = $conn->prepare('UPDATE administrator SET password = :pass WHERE id_document = :id');

                $uppass->execute(array(':pass'=>$npass, ':id'=>$row['id_document']));

                $msg = array("Contraseña actualizada correctamente, redireccionando...", "success");
                header('refresh:5; ./');
            }

    }
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
                <form action="" method="post" enctype="application/x-www-form-urlencoded">
                    <h1>Recuperar contraseña</h1>
                    <!--Alerts-->
                    <?php if (isset($msg)) { ?>

                        <div class="m-3 alert alert-<?php echo $msg[1]; ?> alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo $msg[0]; ?>.
                        </div>

                    <?php } ?>
                    <!--Alerts-->
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password"
                                placeholder="Ingreso su contraseña" name="pass" required>
                            <span class="input-group-text" onclick="pass_show_hide();">
                                <i class="bi bi-eye-fill d-none" id="showeye"></i>
                                <i class="bi bi-eye-slash-fill" id="hideeye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn text-white" type="submit" name="btn-resetpass" style="background-color: #68BDA2;">Restablecer contraseña</button>
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