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

$sentencia_select = $con->prepare('SELECT * FROM datos ORDER BY id_dato DESC');
$sentencia_select->execute();
$resultado = $sentencia_select->fetchAll();

if (isset($_POST['btn_buscar'])) {
    $buscar_text = htmlspecialchars($_POST['buscar']);
    $select_buscar = $con->prepare('SELECT * FROM datos WHERE id_dato LIKE :campo OR nombre LIKE :campo OR email LIKE :campo');
    
    try {
        $select_buscar->execute(array(':campo' => "%" . $buscar_text . "%"));
        $resultado = $select_buscar->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Actualizar el estado a "respondido" si se hace clic en "Responder"
if (isset($_GET['responder_id'])) {
    $responder_id = $_GET['responder_id'];
    $update_query = $con->prepare('UPDATE datos SET respondido = 1 WHERE id_dato = :id');
    $update_query->bindParam(':id', $responder_id);
    
    if ($update_query->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>correo</title>
    <link rel="stylesheet" href="stilos/responsive.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Correo</h2>
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
            </div>
        </form>
        </div>
        <table class="table table-dark table-striped">
            <tr class="text-danger">
                <td>ID</td>
                <td>Nombre</td>
                <td>Email</td>
                <td>Asunto</td>
                <td>Mensaje</td>
                <td>Fecha</td>
                <td>Estado</td>
                <td colspan="2">Acción</td>
            </tr>
            <?php foreach ($resultado as $fila) : ?>
                <tr>
                    <td><?php echo $fila['id_dato']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td><?php echo $fila['asunto']; ?></td>
                    <td><?php echo $fila['mensaje']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td><?php echo $fila['respondido'] ? 'Respondido' : 'No Respondido'; ?></td>
                    <td>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo $fila['email']; ?>&su=Re: <?php echo urlencode($fila['asunto']); ?>" 
                        target="_blank" class="btn__update" 
                        onclick="updateStatus(<?php echo $fila['id_dato']; ?>)">Responder</a>
                    </td>

                    <td>
                        <a href="eliminarco.php?id_dato=<?php echo $fila['id_dato']; ?>"
                            class="btn__delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <script>
        function updateStatus(id) {
            // Usamos fetch para hacer una solicitud asincrónica para actualizar el estado de respondido
            fetch('update_status.php?responder_id=' + id)
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Para depuración, puedes ver la respuesta del servidor aquí
                    // Después de actualizar, no hacemos nada más porque la redirección ya la maneja el enlace
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

</body>
</html>
