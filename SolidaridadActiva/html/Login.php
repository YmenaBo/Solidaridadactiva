<?php

session_start();
include("connect.php");

$error_message = "";

// Verifica si el formulario de inicio de sesión se envió
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener la información del usuario
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if (!$query) {
        die("Error en la consulta: " . mysqli_error($conn)); 
    }

    $row = mysqli_fetch_assoc($query);

    if ($row && password_verify($password, $row['password'])) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['email'] = $email;
        header("Location: homepage.php");
        exit();
    } else {
        // Contraseña incorrecta aqui
        $error_message = "Correo electrónico o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/stylescuenta.css">
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <main>

        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="contenedor__todo">
                    <div class="caja__trasera">
                        <div class="caja__trasera-login">
                            <h3>¿Ya tienes una cuenta?</h3>
                            <p>Inicia sesión para entrar en la página</p>
                            <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                        </div>
                        <div class="caja__trasera-register">
                            <h3>¿Aún no tienes una cuenta?</h3>
                            <p>Regístrate para que puedas iniciar sesión</p>
                            <button id="btn__registrarse">Regístrarse</button>
                        </div>
                    </div>
                    <!--Formulario de Login y registro-->
                    <div class="contenedor__login-register">
                        <!--Login-->
                        <form method="post" action="login.php" class="formulario__login">
                            <h2>Iniciar Sesión</h2>
                            <?php if ($error_message): ?>
                                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
                            <?php endif; ?>
                            <input type="email" name="email" placeholder="Correo Electrónico" required>
                            <input type="password" name="password" placeholder="Contraseña" required>
                            <button type="submit" name="login">Entrar</button>
                        </form>

                        <!--Register-->
                        <form method="post" action="register.php" class="formulario__register">
                            <h2>Regístrarse</h2>
                            <input type="text" name="nombre" placeholder="Nombre completo" required>
                            <input type="email" name="email" placeholder="Correo Electrónico" required>
                            <input type="text" name="usuario" placeholder="Usuario" required>
                            <input type="password" name="password" placeholder="Contraseña" required>
                            <button type="submit" name="signUp">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
            <script src="js/script.js"></script>
</body>

</html>
