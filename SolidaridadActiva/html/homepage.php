<?php
session_start();
include("connect.php");

// Verifica si el usuario está autenticado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Obtiene el email de la sesión
$email = $_SESSION['email'];

// Consulta para obtener la información del usuario
$query = mysqli_query($conn, "SELECT nombre FROM users WHERE email='$email'");
if (!$query) {
    die("Error en la consulta: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($query);
if (!$row) {
    die("No se encontraron datos para el usuario.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>HomeCare</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi cuenta</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 100px;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
            flex: 1;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .user-info p {
            font-size: 24px;
            color: #555;
        }

        .account-actions {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .account-actions a {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            text-decoration: none;
            background-color: #f0f0f0;
            color: #333;
            border-radius: 5px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            /* Agrega una sombra ligera */
            transition: background-color 0.3s, color 0.3s;
            /* Suaviza las transiciones al hacer hover */
        }

        .account-actions a:hover {
            background-color: #ccc;
            /* Cambia el fondo cuando se pasa el mouse */
            color: #000;
            /* Cambia el color del texto cuando se pasa el mouse */
        }

        .account-actions a:last-child {
            margin-top: 5px;
            background-color: #ff4d4d;
            color: white;
        }

        .account-actions a.logout:hover {
            background-color: #e60000;
            color: #fff;
        }


        .profile-image img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="header_section">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="logo"><a href="index.html"><img src="images/logo.png"></a></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="medicine.html">Organizaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="news.html">Beneficiarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php" id="btnLogin">Mi Cuenta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="images/search-icon.png"></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h1>Bienvenido a tu cuenta</h1>

            <!-- Sección de imagen de perfil -->
            <div class="profile-image">
                <img src="images/usuario.png" alt="Imagen de perfil">
                <p>Cambiar imagen de perfil</p>
            </div>

            <!-- Sección de saludo al usuario -->
            <div class="user-info">
                <p>Hola, <?php echo htmlspecialchars($row['nombre']); ?>!</p>
            </div>

            <!-- Sección de acciones de la cuenta -->
            <div class="account-actions">
                <a href="edit-profile.php">Editar perfil</a>
                <a href="change-password.php">Cambiar contraseña</a>
                <a href="view-history.php">Ver historial</a>
                <a href="donar.php">Donar</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>

        <!-- Footer fuera del container, siempre al final -->
        <footer>
            <p>&copy; 2024 Solidaridad Activa. Todos los derechos reservados.</p>
        </footer>

</body>

</html>