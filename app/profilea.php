<?php
include_once 'conn.php';

if (isset($_GET['msg']) && isset($_GET['type'])) {
    $msg = [urldecode($_GET['msg']), $_GET['type']];
}

if (isset($_SESSION['administrator'])) {
    $stmt = $conn->prepare("SELECT * FROM administrator WHERE email = ?");
    $stmt->execute([$_SESSION['administrator']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo "Administrador no encontrado.";
        exit;
    }
} else {
    header("Location: ../");
    exit;
}
?>

<body style="background-color: #FEFFEF;">
    <div class="container mt-5 pt-5">
        <?php if (isset($msg)) { ?>
            <div class="alert alert-<?php echo htmlspecialchars($msg[1]); ?> alert-dismissible fade show mt-4" role="alert">
                <strong>Alerta:</strong> <?php echo htmlspecialchars($msg[0]); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php } ?>

        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header text-white" style="background-color: #008B9D;">
                <h4 class="mb-0">Perfil del Administrador</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <?php if ($admin['picture']): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($admin['picture']); ?>" class="rounded-circle" width="120" height="120" alt="Foto de perfil">
                    <?php else: ?>
                        <img src="../assets/media/default-avatar.png" class="rounded-circle" width="120" height="120" alt="Foto por defecto">
                    <?php endif; ?>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($admin['names'] . ' ' . $admin['last_name']); ?></li>
                    <li class="list-group-item"><strong>Correo:</strong> <?php echo htmlspecialchars($admin['email']); ?></li>
                    <li class="list-group-item"><strong>Rol:</strong> <?php echo htmlspecialchars($admin['role']); ?></li>
                    <li class="list-group-item"><strong>Documento:</strong> <?php echo htmlspecialchars($admin['id_document']); ?></li>
                    <li class="list-group-item"><strong>Fecha de nacimiento:</strong> <?php echo htmlspecialchars($admin['birthdate']); ?></li>
                    <li class="list-group-item"><strong>Fecha de registro:</strong> <?php echo htmlspecialchars($admin['regdate']); ?></li>
                </ul>
            </div>
            <div class="text-center mb-4">
                <button class="btn" style="background-color: #008B9D; color: white;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    Editar perfil
                </button>
            </div>

        </div>
    </div>
    <!-- Modal para editar perfil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="update_profile.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileLabel">Editar perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="idadministrator" value="<?php echo htmlspecialchars($admin['idadministrator']); ?>">

                        <div class="mb-3">
                            <label for="names" class="form-label">Nombres</label>
                            <input type="text" class="form-control" name="names" id="names" value="<?php echo htmlspecialchars($admin['names']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo htmlspecialchars($admin['last_name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_document" class="form-label">Documento</label>
                            <input type="text" class="form-control" name="id_document" id="id_document" value="<?php echo htmlspecialchars($admin['id_document']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                            <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($admin['birthdate']); ?>" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>