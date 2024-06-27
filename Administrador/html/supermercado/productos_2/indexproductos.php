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
$resultado = [];

$sentencia_select = $con->prepare('SELECT * FROM productos ORDER BY id DESC');
$sentencia_select->execute();
$resultado = $sentencia_select->fetchAll();

if (isset($_POST['btn_buscar'])) {
    $buscar_text = htmlspecialchars($_POST['buscar']);
    $select_buscar = $con->prepare('SELECT * FROM productos
                                   WHERE id LIKE :campo
                                      OR nombre LIKE :campo
                                      OR descripcion LIKE :campo
                                      OR cantidad_disponible LIKE :campo
                                      OR precio_unitario LIKE :campo
                                      OR estado LIKE :campo');
    try {
        $select_buscar->execute(array(':campo' => "%" . $buscar_text . "%"));
        $resultado = $select_buscar->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="stilosproductos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="contenedor">
        <div class="container my-5">
            <h2 class="text-center text-primary mb-4">Productos</h2>
            <div class="barra_buscador">
                <form action="" class="formulario" method="post">
                    <div class="row align-items-center">
                        <div class="col">
                            <input class="form-control me-2" type="text" name="buscar" placeholder="Buscar Producto"
                                value="<?php if (isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-primary" name="btn_buscar" value="Buscar">
                        </div>
                        <div class="col-auto">
                            <a href="supermercado/productos_2/insert_productos.php" class="btn btn-success">Nuevo</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-dark table-striped">
            <tr class="head">
                <td>ID Producto</td>
                <td>Nombre</td>
                <td>Descripción</td>
                <td>Cantidad Disponible</td>
                <td>Imagen</td>
                <td>Precio Unitario</td>
                <td>Fecha Ingreso</td>
                <td>Fecha Salida</td>
                <td>Estado</td>
                <td colspan="2">Acción</td>
            </tr>
            <?php foreach ($resultado as $fila) : ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['descripcion']; ?></td>
                    <td><?php echo $fila['cantidad_disponible']; ?></td>
                    <td>
                        <?php if ($fila['imagen']) : ?>
                            <img src="data:image/jpg;base64, <?php echo base64_encode($fila['imagen']); ?>" style="width: 100px; height: auto;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $fila['precio_unitario']; ?></td>
                    <td><?php echo $fila['fecha_ingreso']; ?></td>
                    <td><?php echo $fila['fecha_salida']; ?></td>
                    <td><?php echo $fila['estado']; ?></td>
                    <td>
                        <a href="supermercado/productos_2/update_productos.php?id=<?php echo $fila['id']; ?>" class="btn btn-warning">Editar</a>
                    </td>
                    <td>
                        <a href="supermercado/productos_2/delete_productos.php?id=<?php echo $fila['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>
</html>
