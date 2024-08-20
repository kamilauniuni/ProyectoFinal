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

if(isset($_GET['id_dato'])) {
    $id_dato = (int)$_GET['id_dato'];

    try {

        $consulta_delete = $con->prepare('DELETE FROM datos WHERE id_dato = :id_dato');
        $consulta_delete->execute(array(':id_dato' => $id_dato));

        // Redireccionar al usuario a indexclientes.php después de eliminar el cliente
        header('Location: indexc.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al intentar eliminar el registro: " . $e->getMessage();
    }
} else {
    echo "ID de cliente no proporcionado.";
    exit();
}
?>
