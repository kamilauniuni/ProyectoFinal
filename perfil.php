<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    // Si no hay sesión iniciada, redirige a la página de inicio de sesión o muestra un mensaje de error
    header("Location: login.php"); // Redirige a tu página de inicio de sesión
    exit();
}

// Incluir tu archivo de conexión a la base de datos
include 'login/modelo/conexion.php';

// Obtener todos los datos del usuario desde la base de datos
$idUsuario = $_SESSION['id'];

// Consulta SQL usando consulta preparada
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario); // "i" indica que $idUsuario es de tipo entero (integer)
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Guarda los datos del usuario en $_SESSION si se encontraron resultados
    $datosUsuario = $resultado->fetch_assoc();
    $_SESSION['datosUsuario'] = $datosUsuario;
} else {
    // Si no se encontraron datos, maneja el caso según tu aplicación
    echo "Error: No se encontraron datos de usuario";
    exit();
}

// Cerrar la conexión a la base de datos y liberar recursos
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - Supermercados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="stilos.css">
    <link rel="stylesheet" type="text/css" href="clientes/diseño.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media only screen and (max-width: 600px) {
            table, th, td {
                display: block;
            }
            th, td {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center text-md-left">
                <h1>Supermercados
                    <img src="img/carrito-de-compras (1).png" alt="Icono" style="vertical-align: middle; width: 35px; height: 35px;">
                </h1>
            </div>
            <div class="col-12 col-md-6">
                <nav class="navbar navbar-expand-lg bg-body">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-start" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php">Hogar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="catalogo.php">Catálogo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="sobreNosotros.php">Quiénes somos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contactanos.php">Contáctenos</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php 
                                            if (isset($_SESSION['nombre'])) {
                                                echo $_SESSION['nombre'];
                                            } else {
                                                echo '<img src="img/perfil8.png" alt="" class="usuario" style="vertical-align: middle; width: 25px; height: 25px;">';
                                            }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php 
                                            if (isset($_SESSION['nombre'])) {
                                                echo '<li><a class="dropdown-item" href="perfil.php">Perfil</a></li>';
                                                echo '<li><a class="dropdown-item" href="login/controlador/controlador_cerrar_session.php">Salir</a></li>';
                                            } else {
                                                echo '<li><a class="dropdown-item" href="login/login.php">Iniciar sesión</a></li>';
                                            }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
    <div class="container">
        <h1>Bienvenido a tu perfil, <?php echo $_SESSION['datosUsuario']['nombre']; ?></h1>
        <table>
            <tr>
                <th>Tus Datos</th>
                
            </tr>
            <tr>
                <td>ID</td>
                <td><?php echo $_SESSION['datosUsuario']['id']; ?></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><?php echo $_SESSION['datosUsuario']['nombre']; ?></td>
            </tr>
            <tr>
                <td>Correo electrónico</td>
                <td><?php echo $_SESSION['datosUsuario']['correo']; ?></td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td><?php echo $_SESSION['datosUsuario']['usuario']; ?></td>
            </tr>
            <!-- Añade más filas según los campos de tu tabla de usuarios -->
        </table>
        <div>
            <a href="login/controlador/controlador_cerrar_session.php" class="btn btn-danger">Cerrar sesión</a>
            <a href="clientes/actualizar.php" class="btn btn-primary">Actualizar Datos</a>
            <a href="index.php">volver al inicio</a>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-tBB8xjpmKIlr6t7EGA2XzIgbIddH+3QkekZZigZT89l8Utd9+BbO2mcxjfSTacbM" crossorigin="anonymous"></script>
</body>
</html>
