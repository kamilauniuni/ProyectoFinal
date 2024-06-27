<?php
$database = 'supermercado';
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
$inventario_editar = null;

if (isset($_GET['id_inventario'])) {
    $id_inventario_editar = (int)$_GET['id_inventario'];

    $buscar_id = $con->prepare('SELECT * FROM inventarios WHERE id_inventario = :id_inventario');
    $buscar_id->execute(array(':id_inventario' => $id_inventario_editar));

    $inventario_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id_inventario = $_POST['id_inventario'];
    $nombre_producto = $_POST['nombre_producto'];
    $cantidad = $_POST['cantidad'];
    $ubicacion = $_POST['ubicacion'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $nombre_dispensador = $_POST['nombre_dispensador'];
    $cantidad_dispensador = $_POST['cantidad_dispensador'];

    // Verificar si el id_dispensador proporcionado existe en la tabla dispensadores
    $consulta_dispensador = $con->prepare('SELECT id_dispensador FROM dispensadores WHERE nombre = :nombre_dispensador');
    $consulta_dispensador->execute(array(':nombre_dispensador' => $nombre_dispensador));
    $id_dispensador = $consulta_dispensador->fetchColumn();

    // Verificar si el id_producto proporcionado existe en la tabla productos
    $consulta_producto = $con->prepare('SELECT id_producto FROM productos WHERE nombre = :nombre_producto');
    $consulta_producto->execute(array(':nombre_producto' => $nombre_producto));
    $id_producto = $consulta_producto->fetchColumn();

    if ($id_dispensador && $id_producto) {
        try {
            $consulta_insert = $con->prepare('INSERT INTO inventarios (id_inventario, id_producto, cantidad, ubicacion, fecha_ingreso, id_dispensador, cantidad_dispensador) 
                                                    VALUES (:id_inventario, :id_producto, :cantidad, :ubicacion, :fecha_ingreso, :id_dispensador, :cantidad_dispensador)');

            $consulta_insert->execute(array(
                ':id_inventario' => $id_inventario,
                ':id_producto' => $id_producto,
                ':cantidad' => $cantidad,
                ':ubicacion' => $ubicacion,
                ':fecha_ingreso' => $fecha_ingreso,
                ':id_dispensador' => $id_dispensador,
                ':cantidad_dispensador' => $cantidad_dispensador,
            ));

            header('Location: ../../inventario.php');
            exit();
        } catch (PDOException $e) {
            $mensaje = 'Error al insertar el inventario: ' . $e->getMessage();
        }
    } else {
        if (!$id_producto) {
            $mensaje = 'El producto proporcionado no existe en la tabla productos.';
        } else {
            $mensaje = 'El dispensador proporcionado no existe en la tabla dispensadores.';
        }
    }
}

// Consulta de productos
$consulta_productos = $con->query('SELECT id_producto, nombre FROM productos ORDER BY nombre ASC');
$productos = $consulta_productos->fetchAll(PDO::FETCH_ASSOC);

// Consulta de dispensadores
$consulta_dispensadores = $con->query('SELECT id_dispensador, nombre FROM dispensadores ORDER BY nombre ASC');
$dispensadores = $consulta_dispensadores->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $inventario_editar ? 'Editar inventario' : 'Crear inventario'; ?></title>
    <link rel="stylesheet" href="stilosinventario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="contenedor">
        <h2><?php echo $inventario_editar ? 'Editar inventario' : 'Crear inventario'; ?></h2>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="id_inventario" value="<?php echo $inventario_editar ? $inventario_editar['id_inventario'] : ''; ?>" placeholder="id inventario" class="input__text">
            </div>
            <div class="form-group">
                <select name="nombre_producto" class="input__text">
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo $producto['nombre']; ?>"><?php echo $producto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="cantidad" value="<?php echo $inventario_editar ? $inventario_editar['cantidad'] : ''; ?>" placeholder="cantidad" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="ubicacion" value="<?php echo $inventario_editar ? $inventario_editar['ubicacion'] : ''; ?>" placeholder="ubicacion" class="input__text">
            </div>
            <div class="form-group">
                <input type="date" name="fecha_ingreso" value="<?php echo $inventario_editar ? $inventario_editar['fecha_ingreso'] : ''; ?>" placeholder="fecha ingreso" class="input__date">
            </div>
            <div class="form-group">
                <select name="nombre_dispensador" class="input__text">
                    <option value="">Selecciona un dispensador</option>
                    <?php foreach ($dispensadores as $dispensador): ?>
                        <option value="<?php echo $dispensador['nombre']; ?>"><?php echo $dispensador['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="cantidad_dispensador" value="<?php echo $inventario_editar ? $inventario_editar['cantidad_dispensador'] : ''; ?>" placeholder="cantidad dispensador" class="input__text">
            </div>
            <div class="btn__group">
                <a href="../../inventario.php" class="btn btn-dark">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn-info">
            </div>
        </form>
    </div>
</body>

</html>
