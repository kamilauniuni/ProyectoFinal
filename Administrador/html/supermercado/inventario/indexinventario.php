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
$resultado = [];

$sentencia_select = $con->prepare('SELECT * FROM inventarios ORDER BY id_inventario DESC');

$sentencia_select->execute();

$resultado = $sentencia_select->fetchAll();



if (isset($_POST['btn_buscar'])) {
    $buscar_text = htmlspecialchars($_POST['buscar']);
    $select_buscar = $con->prepare('SELECT * FROM inventarios
                                   WHERE id_inventario LIKE :campo
                                      OR id_producto IN (SELECT id_producto FROM productos WHERE nombre_producto LIKE :nombre_producto)
                                      OR cantidad LIKE :campo');

    try {
        $select_buscar->execute(array(':campo' => "%" . $buscar_text . "%", ':nombre_producto' => "%" . $buscar_text . "%"));
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
    <title>inventario</title>
    <link rel="stylesheet" href="stilosinventario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="container my-5">
        <h2 class="text-center text-primary mb-4">inventario</h2>
        <div class="navbar">
        <form action="" class="primary" method="post">
            <div class="row align-items-center">
                <div class="col">
                    <input class="form-control me-2" type="text" name="buscar" placeholder="Buscar"
                        value="<?php if (isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
                </div>
                <div class="col-auto">
                    <input type="submit" class="btn btn-primary" name="btn_buscar" value="Buscar">
                </div>
                <div class="col-auto">
                    <a href="supermercado/inventario/insertinventario.php" class="btn btn-success">Nuevo</a>
                </div>
            </div>
        </form>
        </div>
        <table class="table table-dark table-striped">
            <tr class="head">
                <td>ID inventario</td>
                <td>Producto</td>
                <td>Cantidad</td>
                <td>Ubicación</td>
                <td>Fecha de ingreso</td>
                <td>Dispensador</td>
                <td>Cantidad dispensador</td>
                <td colspan="2">Acción</td>
            </tr>
            <?php foreach ($resultado as $fila) : ?>
                <tr>
                    <td><?php echo $fila['id_inventario']; ?></td>
                    <td>
                        <?php  
                        $id_producto = $fila['id_producto'];
                        $consulta_producto = $con->prepare('SELECT nombre FROM productos WHERE id_producto = :id_producto');
                        $consulta_producto->execute(array(':id_producto' => $id_producto));
                        $nombre_producto = $consulta_producto->fetchColumn();
                        echo $nombre_producto;
                        ?>
                    </td>
                    <td><?php echo $fila['cantidad']; ?></td>
                    <td><?php echo $fila['ubicacion']; ?></td>
                    <td><?php echo $fila['fecha_ingreso']; ?></td>
                    <td>
                        <?php  
                        $id_dispensador = $fila['id_dispensador'];
                        $consulta_dispensador = $con->prepare('SELECT nombre FROM dispensadores WHERE id_dispensador = :id_dispensador');
                        $consulta_dispensador->execute(array(':id_dispensador' => $id_dispensador));
                        $nombre_dispensador = $consulta_dispensador->fetchColumn();
                        echo $nombre_dispensador;
                        ?>
                    </td>
                    <td><?php echo $fila['cantidad_dispensador']; ?></td>
                    <td>
                        <a href="supermercado/inventario/update_inventario.php?id_inventario=<?php echo $fila['id_inventario']; ?>"
                            class="btn__update">Editar</a>
                    </td>
                    <td>
                        <a href="supermercado/inventario/delete_inventario.php?id_cliente=<?php echo $fila['id_inventario']; ?>"
                            class="btn__delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este inventario?')">Eliminar</a>
                    </td>

                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>

</html>
