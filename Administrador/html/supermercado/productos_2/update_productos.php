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
$producto_editar = null;

if (isset($_GET['id'])) {
    $id_producto_editar = (int)$_GET['id'];

    $buscar_id = $con->prepare('SELECT * FROM productos WHERE id = :id');
    $buscar_id->execute(array(':id' => $id_producto_editar));

    $producto_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $precio_unitario = $_POST['precio_unitario'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];
    $estado = $_POST['estado'];

    // Verificar si se ha subido una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name']) {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
    } else {
        // Si no se ha subido una nueva imagen, mantener la imagen existente
        $imagen = $producto_editar['imagen'];
    }

    try {
        $consulta_update = $con->prepare('UPDATE productos SET 
                                            nombre = :nombre, 
                                            descripcion = :descripcion, 
                                            cantidad_disponible = :cantidad_disponible, 
                                            imagen = :imagen, 
                                            precio_unitario = :precio_unitario, 
                                            fecha_ingreso = :fecha_ingreso, 
                                            fecha_salida = :fecha_salida, 
                                            estado = :estado 
                                            WHERE id = :id');

        $consulta_update->execute(array(
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':cantidad_disponible' => $cantidad_disponible,
            ':imagen' => $imagen,
            ':precio_unitario' => $precio_unitario,
            ':fecha_ingreso' => $fecha_ingreso,
            ':fecha_salida' => $fecha_salida,
            ':estado' => $estado,
            ':id' => $id
        ));

        header('Location: ../../productos.php');
        exit();
    } catch (PDOException $e) {
        $mensaje = 'Error al actualizar el producto: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $producto_editar ? 'Editar Producto' : 'Crear Producto'; ?></title>
    <link rel="stylesheet" href="stilosproductos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="contenedor">
        <h2><?php echo $producto_editar ? 'Editar Producto' : 'Crear Producto'; ?></h2>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $producto_editar ? $producto_editar['id'] : ''; ?>">
                <input type="text" name="nombre" value="<?php echo $producto_editar ? $producto_editar['nombre'] : ''; ?>" placeholder="Nombre" class="input__text" required>
            </div>
            <div class="form-group">
                <textarea name="descripcion" placeholder="Descripción" class="input__text" required><?php echo $producto_editar ? $producto_editar['descripcion'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <input type="number" name="cantidad_disponible" value="<?php echo $producto_editar ? $producto_editar['cantidad_disponible'] : ''; ?>" placeholder="Cantidad Disponible" class="input__text" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label><br>
                <?php if ($producto_editar && $producto_editar['imagen']) : ?>
                    <img src="data:image/jpg;base64, <?php echo base64_encode($producto_editar['imagen']); ?>" style="width: 100px; height: auto;">
                    <br>
                <?php endif; ?>
                <input type="file" name="imagen" id="imagen" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="precio_unitario" value="<?php echo $producto_editar ? $producto_editar['precio_unitario'] : ''; ?>" placeholder="Precio Unitario" class="input__text" required>
            </div>
            <div class="form-group">
                <input type="date" name="fecha_ingreso" value="<?php echo $producto_editar ? $producto_editar['fecha_ingreso'] : ''; ?>" placeholder="Fecha Ingreso" class="input__text" required>
            </div>
            <div class="form-group">
                <input type="date" name="fecha_salida" value="<?php echo $producto_editar ? $producto_editar['fecha_salida'] : ''; ?>" placeholder="Fecha Salida" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="estado" value="<?php echo $producto_editar ? $producto_editar['estado'] : ''; ?>" placeholder="Estado" class="input__text" required>
            </div>
            <div class="btn__group">
                <a href="../../productos.php" class="btn btn-dark">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn-info">
            </div>
        </form>
    </div>
</body>

</html>
