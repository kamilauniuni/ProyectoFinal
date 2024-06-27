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

// Consulta inicial para obtener todos los proveedores ordenados por ID de forma descendente
$sentencia_select = $con->prepare('SELECT * FROM proveedores ORDER BY id DESC');

// Ejecutar la consulta
$sentencia_select->execute();

// Obtener todos los resultados como un array asociativo
$resultado = $sentencia_select->fetchAll();

if (isset($_POST['btn_buscar'])) {
    $buscar_text = htmlspecialchars($_POST['buscar']);
    // Consulta para buscar proveedores por ID, nombre o teléfono que contenga el texto buscado
    $select_buscar = $con->prepare('SELECT * FROM proveedores
                                   WHERE id LIKE :campo
                                      OR nombre LIKE :campo
                                      OR telefono LIKE :campo');

    try {
        // Ejecutar la consulta de búsqueda utilizando el texto buscado
        $select_buscar->execute(array(':campo' => "%" . $buscar_text . "%"));
        // Obtener los resultados de la búsqueda
        $resultado = $select_buscar->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="stilosproveedores.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Proveedores</h2>
        <div class="navbar">
            <form action="" method="post" class="primary">
                <div class="row align-items-center">
                    <div class="col">
                        <input type="text" name="buscar" placeholder="Buscar Proveedor"
                            value="<?php echo isset($buscar_text) ? $buscar_text : ''; ?>"
                            class="form-control me-2 input__text">
                    </div>
                    <div class="col-auto">
                        <input type="submit" class="btn btn-primary" name="btn_buscar" value="Buscar">
                    </div>
                    <div class="col-auto">
                        <a href="supermercado/proveedores/insert_proveedores.php" class="btn btn-success">Nuevo</a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-dark table-striped">
            <thead>
                <tr class="head">
                    <th>ID Proveedor</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $fila) : ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['direccion']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['correo']; ?></td>
                    <td>
                        <a href="supermercado/proveedores/update_proveedores.php?id=<?php echo $fila['id']; ?>"
                            class="btn__update">Editar</a>
                    </td>
                    <td>
                        <a href="supermercado/proveedores/delete_proveedor.php?id=<?php echo $fila['id']; ?>"
                            class="btn__delete"
                            onclick="return confirm('¿Estás seguro de que quieres eliminar este proveedor?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
