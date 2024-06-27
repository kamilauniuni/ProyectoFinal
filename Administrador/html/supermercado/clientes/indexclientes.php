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

$sentencia_select = $con->prepare('SELECT * FROM clientes ORDER BY id_cliente DESC');

$sentencia_select->execute();

$resultado = $sentencia_select->fetchAll();



if (isset($_POST['btn_buscar'])) {
    $buscar_text = htmlspecialchars($_POST['buscar']);
    $select_buscar = $con->prepare('SELECT * FROM clientes
                                   WHERE id_cliente LIKE :campo
                                      OR nombre LIKE :campo
                                      OR telefono LIKE :campo');

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
    <title>Clientes</title>
    <link rel="stylesheet" href="stilosclientes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Clientes</h2>
        <div class="navbar">
        <form action="" class="primary" method="post">
            <div class="row align-items-center">
                <div class="col">
                    <input class="form-control me-2" type="text" name="buscar" placeholder="Buscar Cliente"
                        value="<?php if (isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
                </div>
                <div class="col-auto">
                    <input type="submit" class="btn btn-primary" name="btn_buscar" value="Buscar">
                </div>
                <div class="col-auto">
                    <a href="supermercado/clientes/insertclientes.php" class="btn btn-success">Nuevo</a>
                </div>
            </div>
        </form>
        </div>
        <table class="table table-dark table-striped">
            <tr class="text-danger">
                <td>ID Clientes</td>
                <td>Nombre</td>
                <td>Direccion</td>
                <td>telefono</td>
                <td>email</td>
                
                <td colspan="2">Acción</td>
            </tr>
            <?php foreach ($resultado as $fila) : ?>
                <tr>
                    <td><?php echo $fila['id_cliente']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['direccion']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td>
                    <a href="supermercado/clientes/update_clientes.php?id_cliente=<?php echo $fila['id_cliente']; ?>"
                        class="btn__update">Editar</a>
                    </td>
                    <td>
                        <a href="supermercado/clientes/delete_clientes.php?id_cliente=<?php echo $fila['id_cliente']; ?>"
                            class="btn__delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?')">Eliminar</a>
                    </td>

                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>

</html>
