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

if(isset($_GET['id_proveedor'])) {
    $id_proveedor = (int)$_GET['id_proveedor'];

    try {

        $consulta_delete = $con->prepare('DELETE FROM proveedores WHERE id_proveedor = :id_proveedor');
        $consulta_delete->execute(array(':id_proveedor' => $id_proveedor));

        // Redireccionar al usuario a indexproveedores.php después de eliminar el proveedor
        header('Location: ../../proveedores.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al intentar eliminar el registro: " . $e->getMessage();
    }
} else {
    echo "ID de proveedor no proporcionado.";
    exit();
}
?>