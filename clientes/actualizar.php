<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    // Si no hay sesión iniciada, redirige a la página de inicio de sesión o muestra un mensaje de error
    header("Location: login.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Obtener los datos del usuario desde la sesión
$datosUsuario = $_SESSION['datosUsuario'];

$mensaje = '';

// Procesar el formulario cuando se envíe
if (isset($_POST['guardar'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];
    $correo = $_POST['correo'];

    // Validar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        $mensaje = 'Las contraseñas no coinciden.';
    } else {
        try {
            // Preparar la consulta de actualización para usuario
            $consulta_update_usuario = $conexion->prepare('UPDATE usuarios SET usuario = :usuario, password = :password WHERE id = :id');
            
            // Vincular parámetros para usuario
            $consulta_update_usuario->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $consulta_update_usuario->bindParam(':password', $password, PDO::PARAM_STR);
            $consulta_update_usuario->bindParam(':id', $datosUsuario['id'], PDO::PARAM_INT);
            
            // Ejecutar la consulta para usuario
            $consulta_update_usuario->execute();

            // Actualizar los datos en la sesión para usuario
            $_SESSION['datosUsuario']['usuario'] = $usuario;

            // Preparar la consulta de actualización para correo electrónico
            $consulta_update_correo = $conexion->prepare('UPDATE usuarios SET correo = :correo WHERE id = :id');
            
            // Vincular parámetros para correo electrónico
            $consulta_update_correo->bindParam(':correo', $correo, PDO::PARAM_STR);
            $consulta_update_correo->bindParam(':id', $datosUsuario['id'], PDO::PARAM_INT);
            
            // Ejecutar la consulta para correo electrónico
            $consulta_update_correo->execute();

            // Actualizar los datos en la sesión para correo electrónico
            $_SESSION['datosUsuario']['correo'] = $correo;

            // Redirigir después de actualizar
            header('Location: ../perfil.php');
            exit();
        } catch (PDOException $e) {
            $mensaje = 'Error al actualizar los datos: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Perfil - Supermercados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .alert-danger {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Actualizar Perfil</h1>
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-danger"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nuevo Usuario</label>
            <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : $datosUsuario['usuario']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
            <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Nuevo Correo Electrónico</label>
            <input type="email" id="correo" name="correo" class="form-control" value="<?php echo isset($_POST['correo']) ? $_POST['correo'] : $datosUsuario['correo']; ?>" required>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" name="guardar" class="btn btn-primary">Guardar Cambios</button>
            <a href="../perfil.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-tBB8xjpmKIlr6t7EGA2XzIgbIddH+3QkekZZigZT89l8Utd9+BbO2mcxjfSTacbM" crossorigin="anonymous"></script>
</body>
</html>
