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

if (isset($_GET['responder_id'])) {
    $responder_id = $_GET['responder_id'];
    $update_query = $con->prepare('UPDATE datos SET respondido = 1 WHERE id_dato = :id');
    $update_query->bindParam(':id', $responder_id);

    if ($update_query->execute()) {
        echo "Estado actualizado a respondido.";
    } else {
        echo "Error al actualizar el estado.";
    }
}
?>
