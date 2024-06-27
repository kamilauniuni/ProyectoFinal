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

// Ajustar la consulta para usar la columna correcta
$sentencia_select = $con->prepare('SELECT * FROM empleados ORDER BY id_empleado DESC');
$sentencia_select->execute();
$resultado = $sentencia_select->fetchAll();

if (isset($_POST['btn_buscar'])) {
    $buscar_text = htmlspecialchars($_POST['buscar']);
    $select_buscar = $con->prepare('SELECT * FROM empleados
                                   WHERE id_empleado LIKE :campo
                                      OR nombre LIKE :campo
                                      OR salario LIKE :campo');
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
    <title>Empleados</title>
    <link rel="stylesheet" href="stilosclientes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Empleados</h2>
        <div class="navbar">
        <form action="" class="primary" method="post">
            <div class="row align-items-center">
                <div class="col">
                    <input class="form-control me-2" type="text" name="buscar" placeholder="Buscar Empleado"
                        value="<?php if (isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
                </div>
                <div class="col-auto">
                    <input type="submit" class="btn btn-primary" name="btn_buscar" value="Buscar">
                </div>
                <div class="col-auto">
                    <a href="supermercado/empleados/insertempleados.php" class="btn btn-success">Nuevo</a>
                </div>
            </div>
        </form>
        </div>
        <table class="table table-dark table-striped">
            <tr class="text-danger">
                <td>ID Empleados</td>
                <td>Nombre</td>
                <td>Salario</td>
                <td>Fecha de Contratacion</td>
                <td>Telefono</td>
                <td>Email</td>
                <td>Rol</td>
                <td>Sedes</td>
                <td colspan="2">Acción</td>
            </tr>
            <?php foreach ($resultado as $fila) : ?>
                <tr>
                    <td><?php echo $fila['id_empleado']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['salario']; ?></td>
                    <td><?php echo $fila['fecha_contratacion']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td>
                        <?php  
                            $id_rol = $fila['id_rol'];
                            $consulta_id_rol = $con->prepare('SELECT tipo_de_rol FROM roles WHERE id = :id_rol');
                            $consulta_id_rol->execute(array(':id_rol' => $id_rol));
                            $nombre_rol = $consulta_id_rol->fetchColumn();
                            echo $nombre_rol;
                        ?>
                    </td>
                    <td>
                        <?php  
                            $id_sede = $fila['id_sedes'];
                            $consulta_id_sede = $con->prepare('SELECT nombre FROM sedes WHERE id = :id');
                            $consulta_id_sede->execute(array(':id' => $id_sede));
                            $nombre_sede = $consulta_id_sede->fetchColumn();
                            echo $nombre_sede;
                        ?>
                    </td>
                    <td>
                        <a href="supermercado/empleados/update_empleados.php?id=<?php echo $fila['id_empleado']; ?>" class="btn__update">Editar</a>
                    </td>
                    <td>
                        <a href="supermercado/empleados/delete_empleados.php?id=<?php echo $fila['id_empleado']; ?>" class="btn__delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este empleado?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>
</html>
