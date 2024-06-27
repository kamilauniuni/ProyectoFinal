


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión / Registro</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container" id="container">
        <!-- Formulario de registro -->
        <div class="form-container register-container">
            <form method="post" action=" ">
                <?php
                include "modelo/conexion.php";
                include "login\controlador\controlador_login.php";
                ?>
                

            </form>
        </div>


        
        <!-- Formulario de inicio de sesión -->
        <div class="form-container login-container">
            <form method="post" action=" ">
                <h1>Iniciar sesión</h1>
                <?php
                include "controlador/controlador_login.php"
                ?>
                <input type="text" name="usuario" placeholder="Usuario" >
                <input type="password" name="password" placeholder="Contraseña" >
                <div class="content">
                    <input type="checkbox" name="checkbox" id="checkbox">
                    <label for="checkbox">Recuérdame</label>
                </div>
                <div class="pass-link">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>
                <input name="btningresar" class="btn" type="submit" value="INICIAR SESION">
                <span>o usa tu cuenta</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="lni lni-facebook-fill" id="loginWithFacebook"></i></a>
                    <a href="#" class="social"><i class="lni lni-google" id="loginWithGoogle"></i></a>
                </div>
            </form>
        </div>
      
        
       
    <!-- Contenedor del overlay -->
    <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">Hola</h1>
                    <p>Si tienes una cuenta, inicia sesión aquí</p>
                    <form method="post" action= "">
                        <button type="submit" class="ghost" id="login">Iniciar sesión
                            <i class="lni lni-arrow-left login"></i>
                        </button>
                    </form>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="title">Comienza</h1>
                    <p>Si aún no tienes una cuenta, únete a nosotros</p>
                    <button >Registrarse
                        
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Llamado del JS -->
    <script src="script.js"></script>
</body>
</html>