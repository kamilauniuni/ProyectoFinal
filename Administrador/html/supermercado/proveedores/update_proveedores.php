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
$proveedor_editar = null;

if (isset($_GET['id_proveedor'])) {
    $id_proveedor_editar = (int)$_GET['id_proveedor'];

    $buscar_id = $con->prepare('SELECT * FROM proveedores WHERE id = :id_proveedor');
    $buscar_id->execute(array(':id_proveedor' => $id_proveedor_editar));

    $proveedor_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id_proveedor = $_POST['id_proveedor'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    try {
        $consulta_update = $con->prepare('UPDATE proveedores SET nombre = :nombre, direccion = :direccion, telefono = :telefono, correo = :correo WHERE id_proveedor = :id_proveedor');

        $consulta_update->execute(array(
            ':id_proveedor' => $id_proveedor,
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':correo' => $correo,
        ));

        header('Location: ../../proveedores.php');
        exit();
    } catch (PDOException $e) {
        $mensaje = 'Error al actualizar el proveedor: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $proveedor_editar ? 'Editar Proveedor' : 'Crear Proveedor'; ?></title>
    <link rel="stylesheet" href="stilosproveedores.css">
</head>

<body>
    <div class="contenedor">
        <h2><?php echo $proveedor_editar ? 'Editar Proveedor' : 'Crear Proveedor'; ?></h2>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="hidden" name="id_proveedor" value="<?php echo $proveedor_editar ? $proveedor_editar['id_proveedor'] : ''; ?>">
                <input type="text" name="nombre" value="<?php echo $proveedor_editar ? $proveedor_editar['nombre'] : ''; ?>" placeholder="Nombre" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="direccion" value="<?php echo $proveedor_editar ? $proveedor_editar['direccion'] : ''; ?>" placeholder="Direccion" class="input__text">
            </div>
            <div class="form-group">
                <input type="number" name="telefono" value="<?php echo $proveedor_editar ? $proveedor_editar['telefono'] : ''; ?>" placeholder="Telefono" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="correo" value="<?php echo $proveedor_editar ? $proveedor_editar['correo'] : ''; ?>" placeholder="Correo" class="input__text">
            </div>
            <div class="btn__group">
                <a href="../../proveedores.php" class="btn btn_danger">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
            </div>
        </form>
    </div>
</body>

</html>