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

if(isset($_GET['id_inventario'])) {
    $id_inventario = (int)$_GET['id_inventario'];

    try {

        $consulta_delete = $con->prepare('DELETE FROM inventarios WHERE id_inventario = :id_inventario');
        $consulta_delete->execute(array(':id_inventario' => $id_inventario));

        // Redireccionar al usuario a indexinventario.php después de eliminar el inventario
        header('Location: ../../inventario.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al intentar eliminar el inventario ingreso : " . $e->getMessage();
    }
} else {
    echo "ID de inventario no encontrado.";
    exit();
}
?>