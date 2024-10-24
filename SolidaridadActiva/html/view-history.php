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

// Consulta para obtener el historial de donaciones
$query = mysqli_query($conn, "SELECT nombre_donante, cantidad_alimentos, tipo_alimentos_id, fecha_donacion, fecha_entrega FROM donaciones WHERE correo_donante='$email'");

if (!$query) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Verifica si hay donaciones
if (mysqli_num_rows($query) == 0) {
    echo "<p>No has realizado donaciones.</p>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Historial de Donaciones</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .donation {
            border-bottom: 1px solid #eee;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }
        .donation:hover {
            background-color: #f9f9f9;
        }
        .donation h5 {
            margin: 0 0 5px;
        }
        .donation p {
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Historial de Donaciones</h1>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="donation">
                <h5><?php echo htmlspecialchars($row['nombre_donante']); ?></h5>
                <p>Cantidad de alimentos: <?php echo htmlspecialchars($row['cantidad_alimentos']); ?></p>
                <p>Fecha de donación: <?php echo htmlspecialchars($row['fecha_donacion']); ?></p>
                <p>Fecha de entrega: <?php echo htmlspecialchars($row['fecha_entrega']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
