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
$empleado_editar = null;

if (isset($_GET['id'])) {
    $id_empleado_editar = (int)$_GET['id'];

    $buscar_id = $con->prepare('SELECT * FROM empleados WHERE id_empleado = :id_empleado');
    $buscar_id->execute(array(':id_empleado' => $id_empleado_editar));

    $empleado_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id_empleado = $_POST['id_empleado'];
    $nombre = $_POST['nombre'];
    $salario = $_POST['salario'];
    $fecha_contratacion = $_POST['fecha_contratacion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $nombre_del_rol = $_POST['nombre_del_rol'];
    $nombre_de_sede = $_POST['nombre_de_sede'];

    // Consulta del rol inicio
    $consulta_rol = $con->prepare('SELECT id FROM roles WHERE tipo_de_rol = :nombre_del_rol');
    $consulta_rol->execute(array(':nombre_del_rol' => $nombre_del_rol));
    $id_rol = $consulta_rol->fetchColumn();

    if (!$id_rol) {
        $insertar_rol = $con->prepare('INSERT INTO roles (tipo_de_rol) VALUES (:tipo_de_rol)');
        $insertar_rol->execute(array(':tipo_de_rol' => $nombre_del_rol));
        $id_rol = $con->lastInsertId();
    }
    // Consulta del rol Fin

    // Consulta de sedes inicio
    $consulta_sede = $con->prepare('SELECT id FROM sedes WHERE nombre = :nombre_de_sede');
    $consulta_sede->execute(array(':nombre_de_sede' => $nombre_de_sede));
    $id_sedes = $consulta_sede->fetchColumn();

    if (!$id_sedes) {
        $insertar_sede = $con->prepare('INSERT INTO sedes (nombre) VALUES (:nombre)');
        $insertar_sede->execute(array(':nombre' => $nombre_de_sede));
        $id_sedes = $con->lastInsertId();
    }
    // Consulta de sedes Fin

    try {
        $consulta_update = $con->prepare('UPDATE empleados SET salario = :salario, fecha_contratacion = :fecha_contratacion, telefono = :telefono, email = :email, id_rol = :id_rol, id_sedes = :id_sedes
                                          WHERE id_empleado = :id_empleado');

        $consulta_update->execute(array(
            ':id_empleado' => $id_empleado,
            ':salario' => $salario,
            ':fecha_contratacion' => $fecha_contratacion,
            ':telefono' => $telefono,
            ':email' => $email,
            ':id_rol' => $id_rol,
            ':id_sedes' => $id_sedes,
        ));

        header('Location: ../../empleados.php');
        exit();
    } catch (PDOException $e) {
        $mensaje = 'Error al actualizar el empleado: ' . $e->getMessage();
    }
}

$consulta_roles = $con->query('SELECT id, tipo_de_rol FROM roles ORDER BY tipo_de_rol ASC');
$roles = $consulta_roles->fetchAll(PDO::FETCH_ASSOC);

$consulta_sedes = $con->query('SELECT id, nombre FROM sedes ORDER BY nombre ASC');
$sedes = $consulta_sedes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="stilosempleados.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="contenedor">
        <h2>Editar Empleado</h2>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="id_empleado" value="<?php echo $empleado_editar ? $empleado_editar['id_empleado'] : ''; ?>" placeholder="ID Empleado" class="form-control" readonly>
            </div>
            <div class="form-group">
                <input type="text" name="nombre" value="<?php echo $empleado_editar ? $empleado_editar['nombre'] : ''; ?>" placeholder="Nombre" class="form-control" readonly>
            </div>
            <div class="form-group">
                <input type="text" name="salario" value="<?php echo $empleado_editar ? $empleado_editar['salario'] : ''; ?>" placeholder="Salario" class="form-control">
            </div>
            <div class="form-group">
                <input type="date" name="fecha_contratacion" value="<?php echo $empleado_editar ? $empleado_editar['fecha_contratacion'] : ''; ?>" placeholder="Fecha de Contratación" class="form-control">
            </div>
            <div class="form-group">
                <input type="number" name="telefono" value="<?php echo $empleado_editar ? $empleado_editar['telefono'] : ''; ?>" placeholder="Teléfono" class="form-control">
            </div>
            <div class="form-group">
                <input type="email" name="email" value="<?php echo $empleado_editar ? $empleado_editar['email'] : ''; ?>" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
                <label for="nombre_del_rol">Rol:</label>
                <select id="nombre_del_rol" name="nombre_del_rol" class="input__text">
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?php echo $rol['tipo_de_rol']; ?>" <?php echo ($empleado_editar && $rol['id'] == $empleado_editar['id_rol']) ? 'selected' : ''; ?>>
                            <?php echo $rol['tipo_de_rol']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre_de_sede">Sede:</label>
                <select id="nombre_de_sede" name="nombre_de_sede" class="input__text">
                    <?php foreach ($sedes as $sede): ?>
                        <option value="<?php echo $sede['nombre']; ?>" <?php echo ($empleado_editar && $sede['id'] == $empleado_editar['id_sedes']) ? 'selected' : ''; ?>>
                            <?php echo $sede['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="botones">
                <a href="../../empleados.php" class="btn btn-dark">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn-info">
            </div>
        </form>
    </div>
</body>

</html>
