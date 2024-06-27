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
$cliente_editar = null;

if (isset($_GET['id_cliente'])) {
    $id_cliente_editar = (int)$_GET['id_cliente'];

    $buscar_id = $con->prepare('SELECT * FROM clientes WHERE id_cliente = :id_cliente');
    $buscar_id->execute(array(':id_cliente' => $id_cliente_editar));

    $cliente_editar = $buscar_id->fetch();
}

if (isset($_POST['guardar'])) {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    

 
    
   
    

    try {
     
        $consulta_insert_update = $con->prepare('INSERT INTO clientes (id_cliente, nombre, direccion, telefono, email) 
                                                VALUES (:id_cliente, :nombre, :direccion, :telefono, :email)
                                                ON DUPLICATE KEY UPDATE nombre = :nombre, direccion = :direccion, telefono = :telefono, email = :email');

        $consulta_insert_update->execute(array(
            ':id_cliente' => $id_cliente,
            ':nombre' => $nombre,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email,
        ));

        header('Location: ../../clientes.php');
        exit();
    } catch (PDOException $e) {
        $mensaje = 'Error al insertar o actualizar el cliente: ' . $e->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $cliente_editar ? 'Editar Ciente' : 'Crear Cliente'; ?></title>
    <link rel="stylesheet" href="stilosclientes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="contenedor">
        <h2><?php echo $cliente_editar ? 'Editar Ciente' : 'Crear Cliente'; ?></h2>
        <?php if (!empty($mensaje)): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="id_cliente" value="<?php echo $cliente_editar ? $cliente_editar['id_cliente'] : ''; ?>" placeholder="ID clientes" class="input__text">
                
            </div>
            <div class="form-group">
            <input type="text" name="nombre" value="<?php echo $cliente_editar ? $cliente_editar['nombre'] : ''; ?>" placeholder="Nombre" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="direccion" value="<?php echo $cliente_editar ? $cliente_editar['direccion'] : ''; ?>" placeholder="Direccion" class="input__text">
            </div>
            <div class="form-group">
                <input type="number" name="telefono" value="<?php echo $cliente_editar ? $cliente_editar['precio'] : ''; ?>" placeholder="telefono" class="input__text">
            </div>
            <div class="form-group">
                <input type="text" name="email" value="<?php echo $cliente_editar ? $cliente_editar['email'] : ''; ?>" placeholder="email" class="input__text">
            </div>
            <div class="btn__group">
                <a href="../../clientes.php" class="btn btn-dark">Cancelar</a>
                <input type="submit" name="guardar" value="Guardar" class="btn btn-info">
            </div>
        </form>
    </div>
</body>

</html>
