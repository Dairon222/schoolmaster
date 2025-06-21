<?php
require_once 'conn.php';

if (isset($_POST['btn-reg'])) {
    $insert = $conn->prepare('INSERT INTO administrator(names,last_name,id_document,role,email,password) VALUES(?,?,?,?,?,?)');
    $insert->bindParam(1, $_POST['names']);
    $insert->bindParam(2, $_POST['last_name']);
    $insert->bindParam(3, $_POST['id_document']);
    $insert->bindParam(4, $_POST['role']);
    $insert->bindParam(5, $_POST['email']);
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $insert->bindParam(6, $pass);

    /* Data Validation */
    $search = $conn->prepare('SELECT * FROM administrator WHERE id_document = ?');
    $search->bindParam(1, $_POST['id_document']);
    $search->execute();
    $result = $search->fetch(PDO::FETCH_ASSOC);
    
    // Validar si el correo ya existe
    $searchEmail = $conn->prepare('SELECT * FROM administrator WHERE email = ?');
    $searchEmail->bindParam(1, $_POST['email']);
    $searchEmail->execute();
    $resultEmail = $searchEmail->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $msg = array("El documento de identidad ya existe", "danger");
    } elseif ($resultEmail) {
        $msg = array("El correo ya está registrado", "danger");
    } elseif ($insert->execute()) {
        $msg = array("Usuario Creado", "success");
    } else {
        $msg = array("Usuario no Creado", "danger");
    }
}

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
        <section style="margin-top: 50px;">
            <div class="rounded d-flex align-items-center justify-content-center m-5 p-5" style="background-color: #F6ECE2;">
                <form action="" method="post" enctype="application/x-www-form-urlencoded">
                    <h1>Registrar administrador</h1>
                    <!--Alerts-->
                    <?php if (isset($msg)) { ?>

                        <div class="m-3 alert alert-<?php echo $msg[1]; ?> alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo $msg[0]; ?>.
                        </div>

                    <?php } ?>
                    <!--Alerts-->
                    <div class="mb-3 mt-3">
                        <label for="names" class="form-label">Nombres:</label>
                        <input type="text" class="form-control" id="names" placeholder="Ingrese sus nombres"
                            name="names" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="last_name" class="form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Ingrese sus apellidos"
                            name="last_name" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="id_document" class="form-label">Documento de identidad:</label>
                        <input type="text" class="form-control" id="id_document" name="id_document"
                            placeholder="Ingrese su documento de identidad" required pattern="^[0-9]+$"
                            title="El documento de identidad debe contener solo números enteros">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="role" class="form-label">Rol:</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="" disabled selected>Seleccione un rol</option>
                            <option value="principal">Rector@</option>
                            <option value="secretary">Secretari@</option>
                            <option value="coordinator">Coordinador@</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su email" name="email"
                            required>
                    </div>


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
                        <button class="btn text-white" type="submit" name="btn-reg" style="background-color: #68BDA2;">Registrar</button>
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