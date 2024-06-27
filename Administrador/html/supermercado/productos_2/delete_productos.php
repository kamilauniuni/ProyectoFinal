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

if (isset($_GET['id'])) {
    $id_producto = (int)$_GET['id'];

    try {
        $consulta_delete = $con->prepare('DELETE FROM productos WHERE id = :id');
        $consulta_delete->execute(array(':id' => $id_producto));

        // Redireccionar al usuario a productos.php después de eliminar el producto
        header('Location: ../../productos.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al intentar eliminar el registro: " . $e->getMessage();
    }
} else {
    echo "ID de producto no proporcionado.";
    exit();
}

?>
