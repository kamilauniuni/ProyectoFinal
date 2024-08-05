<?php
session_start();

if (!empty($_POST["btningresar"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        // Suponiendo que $conexion ya está configurado y conectado a tu base de datos

        // Consulta SQL para obtener el usuario con el nombre y contraseña proporcionados
        $sql = $conexion->query("SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'");

        if ($sql) { // Verifica si la consulta se ejecutó correctamente
            if ($datos = $sql->fetch_object()) {
                // Guarda los datos del usuario en la sesión
                $_SESSION["id"] = $datos->id;
                $_SESSION["nombre"] = $datos->nombre;

                // Verifica el rol del usuario
                if ($datos->rol == 1) {
                    // Si el usuario tiene id igual a 2 (cliente), redirige al inicio de la página cliente
                    header("Location: ../index.php");
                } else {
                    // De lo contrario, redirige al inicio de la página de administrador
                    header("Location: ../Administrador/html/index.php");
                }
                exit(); // Finaliza el script después de redirigir
            } else {
                // Si no se encontraron datos, muestra un mensaje de acceso denegado
                echo "<div class='alert alert-danger'>Acceso denegado</div>";
            }
        } else {
            // Si hubo un error en la consulta SQL, muestra el mensaje de error
            echo "<div class='alert alert-danger'>Error en la consulta SQL: " . $conexion->error . "</div>";
        }
    } else {
        // Si los campos están vacíos, muestra un mensaje de advertencia
        echo "<div class='alert alert-warning'>Por favor, complete todos los campos</div>";
    }
}
?>
