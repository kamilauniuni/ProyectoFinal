<?php

session_start();

if (!empty($_POST["btningresar"])) {

    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        $sql = $conexion->query("SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'");

        if ($sql) { 
            if ($datos = $sql->fetch_object()) {
   
                $_SESSION["id"] = $datos->id;
                $_SESSION["nombre"] = $datos->nombre;
                

                
                 header("Location: ../Administrador/html/index.php");
                exit(); 
            } else {
     
                echo "<div class='alert alert-danger'>Acceso denegado</div>";
            }
        } else {

            echo "<div class='alert alert-danger'>Error en la consulta SQL: " . $conexion->error . "</div>";
        }
    } else {
        // Mostrar un mensaje de error si los campos están vacíos
        echo "<div class='alert alert-warning'>Por favor, complete todos los campos</div>";
    }
}
?>
