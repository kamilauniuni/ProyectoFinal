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

if(isset($_GET['id_empleado'])) {
    $id_empleado = (int)$_GET['id_empleado'];

    try {

        $consulta_delete = $con->prepare('DELETE FROM empleados WHERE id_empleado = :id_empleado');
        $consulta_delete->execute(array(':id_empleado' => $id_empleado));

        // Redireccionar al usuario a indexempleados.php después de eliminar el empleado
        header('Location: ../../empleados.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al intentar eliminar el registro: " . $e->getMessage();
    }
} else {
    echo "ID de empleado no proporcionado.";
    exit();
}
?>
