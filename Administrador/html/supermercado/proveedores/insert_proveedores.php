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

if (isset($_GET['id'])) {
    $id_proveedor_editar = (int)$_GET['id'];

    $buscar_id = $con->prepare('SELECT * FROM proveedores WHERE id = :id');
    $buscar_id->execute(array(':id' => $id_proveedor_editar));

    $proveedor_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id_proveedor = htmlspecialchars($_POST['id_proveedor']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $correo = htmlspecialchars($_POST['correo']);

    try {
        // Consulta para insertar o actualizar proveedores
        $consulta_insert_update = $con->prepare('INSERT INTO proveedores (id, nombre, direccion, telefono, correo) 
                                                VALUES (:id, :nombre, :direccion, :telefono, :correo)
                                                ON DUPLICATE KEY UPDATE nombre = :nombre, direccion = :direccion, telefono = :telefono, correo = :correo');

        $consulta_insert_update->execute(array(
            ':id' => $id_proveedor,
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':correo' => $correo,
        ));

        header('Location: ../../proveedores.php');
        exit();
    } catch (PDOException $e) {
        $mensaje = 'Error al insertar o actualizar el proveedor: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $proveedor_editar ? 'Editar Proveedor' : 'Crear Proveedor'; ?></title>
    <link rel="stylesheet" href="stilosproveedores.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4"><?php echo $proveedor_editar ? 'Editar Proveedor' : 'Crear Proveedor'; ?></h2>
        <?php if (!empty($mensaje)): ?>
            <p class="text-danger"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="id_proveedor" class="form-label">ID Proveedor</label>
                <input type="text" id="id_proveedor" name="id_proveedor" class="form-control"
                    value="<?php echo $proveedor_editar ? $proveedor_editar['id'] : ''; ?>" <?php echo $proveedor_editar ? 'readonly' : ''; ?>>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="<?php echo $proveedor_editar ? $proveedor_editar['nombre'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control"
                    value="<?php echo $proveedor_editar ? $proveedor_editar['direccion'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control"
                    value="<?php echo $proveedor_editar ? $proveedor_editar['telefono'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="text" id="correo" name="correo" class="form-control"
                    value="<?php echo $proveedor_editar ? $proveedor_editar['correo'] : ''; ?>">
            </div>
            <button type="submit" name="guardar" class="btn btn-primary"><?php echo $proveedor_editar ? 'Actualizar' : 'Guardar'; ?></button>
            <a href="../../proveedores.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
