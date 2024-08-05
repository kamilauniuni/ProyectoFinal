<?php
$database = 'supermercadoosmar';
$user = 'root';
$password = '';

try {
    $con = new PDO('mysql:host=localhost;dbname=' . $database, $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

$mensaje = '';
$usuario_editar = null;

// Verificar si se está editando un usuario
if (isset($_GET['id'])) {
    $id_usuario_editar = (int)$_GET['id'];

    $buscar_id = $con->prepare('SELECT * FROM usuarios WHERE id = :id');
    $buscar_id->execute(array(':id' => $id_usuario_editar));

    $usuario_editar = $buscar_id->fetch();
}

// Procesar el formulario cuando se envíe
if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password']; // Nuevo campo

    // Validar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        $mensaje = 'Las contraseñas no coinciden.';
    } else {
        $rol = 1; // Rol por defecto es cliente

        try {
            if ($usuario_editar) {
                // Si se está editando, se realiza un UPDATE
                $consulta_insert_update = $con->prepare('UPDATE usuarios SET nombre = :nombre, correo = :correo, usuario = :usuario, password = :password, rol = :rol WHERE id = :id');
                $consulta_insert_update->execute(array(
                    ':nombre' => $nombre,
                    ':correo' => $correo,
                    ':usuario' => $usuario,
                    ':password' => $password,
                    ':rol' => $rol,
                    ':id' => $usuario_editar['id']
                ));
            } else {
                // Si no se está editando, se realiza un INSERT
                $consulta_insert_update = $con->prepare('INSERT INTO usuarios (nombre, correo, usuario, password, rol) VALUES (:nombre, :correo, :usuario, :password, :rol)');
                $consulta_insert_update->execute(array(
                    ':nombre' => $nombre,
                    ':correo' => $correo,
                    ':usuario' => $usuario,
                    ':password' => $password,
                    ':rol' => $rol
                ));
            }

            header('Location: ../login/login.php');
            exit();
        } catch (PDOException $e) {
            $mensaje = 'Error al insertar o actualizar el usuario: ' . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $usuario_editar ? 'Editar Usuario' : 'Crear Usuario'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stilos.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="contenedor">
            <h2 class="mb-4"><?php echo $usuario_editar ? 'Editar Usuario' : 'Crear Usuario'; ?></h2>
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-danger"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <?php if ($usuario_editar): ?>
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario_editar['id']; ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $usuario_editar ? $usuario_editar['nombre'] : ''; ?>" placeholder="Nombre" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" name="correo" id="correo" class="form-control" value="<?php echo $usuario_editar ? $usuario_editar['correo'] : ''; ?>" placeholder="Correo" required>
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $usuario_editar ? $usuario_editar['usuario'] : ''; ?>" placeholder="Usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="confirmar_password" id="confirmar_password" class="form-control" placeholder="Confirmar Contraseña" required>
                </div>
                <div class="d-grid gap-2">
                    <a href="../index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-mCkAdTpI1JflsSJAHRWFO2dfvNzCjvub6gZpYHeg/dL5I3ZO0uP2lKJ40yZJv2ua" crossorigin="anonymous"></script>
</body>

</html>
