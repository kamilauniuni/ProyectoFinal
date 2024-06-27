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
$cliente_editar = null;

if (isset($_GET['id_cliente'])) {
    $id_cliente_editar = (int)$_GET['id_cliente'];

    $buscar_id = $con->prepare('SELECT * FROM clientes WHERE id_cliente = :id_cliente');
    $buscar_id->execute(array(':id_cliente' => $id_cliente_editar));

    $cliente_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    try {
        // Utilizar UPDATE en lugar de INSERT ON DUPLICATE KEY UPDATE
        $consulta_update = $con->prepare('UPDATE clientes 
                                          SET nombre = :nombre, direccion = :direccion, telefono = :telefono, email = :email 
                                          WHERE id_cliente = :id_cliente');

        $consulta_update->execute(array(
            ':id_cliente' => $id_cliente,
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email,
        ));

        header('Location: ../../clientes.php');
        exit();
    } catch (PDOException $e) {
        $mensaje = 'Error al actualizar el cliente: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $cliente_editar ? 'Editar Cliente' : 'Crear Cliente'; ?></title>
    <link rel="stylesheet" href="stilosclientes.css">
</head>

<body>
    <div class="contenedor">
        <h2><?php echo $cliente_editar ? 'Editar Cliente' : 'Crear Cliente'; ?></h2>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="id_cliente" value="<?php echo $cliente_editar ? $cliente_editar['id_cliente'] : ''; ?>" placeholder="ID Cliente" class="input__text" readonly>
            </div>
            <div class="form-group">
                <input type="text" name="nombre" value="<?php echo $cliente_editar ? $cliente_editar['nombre'] : ''; ?>" placeholder="Nombre" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="direccion" value="<?php echo $cliente_editar ? $cliente_editar['direccion'] : ''; ?>" placeholder="Direccion" class="input__text">
            </div>
            <div class="form-group">
                <input type="number" name="telefono" value="<?php echo $cliente_editar ? $cliente_editar['telefono'] : ''; ?>" placeholder="Teléfono" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="email" value="<?php echo $cliente_editar ? $cliente_editar['email'] : ''; ?>" placeholder="Email" class="input__text">
            </div>
            <div class="btn__group">
                <a href="../../clientes.php" class="btn btn_danger">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
            </div>
        </form>
    </div>
</body>

</html>

