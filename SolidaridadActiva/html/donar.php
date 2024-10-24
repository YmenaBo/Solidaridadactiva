<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión de correo electrónico está configurada
if (!isset($_SESSION['email'])) {
    // Si no está iniciada la sesión, redirigir al login
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
include("connect.php");

// Si el formulario fue enviado, manejar la donación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre_donante = $_POST['nombre_donante'];
    $correo_donante = $_SESSION['email']; 
    $telefono_donante = $_POST['telefono_donante'];
    $direccion_donante = $_POST['direccion_donante'];
    $cantidad_alimentos = $_POST['cantidad_alimentos'];
    $tipo_alimentos_id = $_POST['tipo_alimentos_id'];
    $comentario = $_POST['comentario'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $horario_disponible = $_POST['horario_disponible'];
    $preferencia_contacto = $_POST['preferencia_contacto'];
    $cantidad_donaciones = $_POST['cantidad_donaciones'];

    // Insertar la donación en la base de datos
    $query = "INSERT INTO donaciones (nombre_donante, correo_donante, telefono_donante, direccion_donante, cantidad_alimentos, tipo_alimentos_id, comentario, fecha_entrega, horario_disponible, preferencia_contacto, cantidad_donaciones) 
              VALUES ('$nombre_donante', '$correo_donante', '$telefono_donante', '$direccion_donante', '$cantidad_alimentos', '$tipo_alimentos_id', '$comentario', '$fecha_entrega', '$horario_disponible', '$preferencia_contacto', '$cantidad_donaciones')";
    
    if (mysqli_query($conn, $query)) {
        echo "¡Gracias por tu donación!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Consulta para obtener los tipos de alimentos
$tipos_alimentos = mysqli_query($conn, "SELECT * FROM tipos_alimentos");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donar</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px; 
            box-sizing: border-box; 
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            box-sizing: border-box; 
            margin: auto; 
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
            font-size: 14px;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="date"], input[type="time"], textarea, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box; /* Para que el padding no afecte el tamaño total */
        }
        button {
            background-color: #1877f2;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #155dbd;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .small-text {
            font-size: 12px;
            color: #777;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Formulario de Donación</h2>
        <form action="donar.php" method="POST">
            <!-- Nombre del donante -->
            <div class="form-group">
                <label for="nombre_donante">Nombre Donante:</label>
                <input type="text" id="nombre_donante" name="nombre_donante" required>
            </div>

            <!-- Correo del donante (obtenido de la sesión) -->
            <div class="form-group">
                <label for="correo_donante">Correo Donante:</label>
                <input type="email" id="correo_donante" name="correo_donante" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
            </div>

            <!-- Teléfono del donante -->
            <div class="form-group">
                <label for="telefono_donante">Teléfono Donante:</label>
                <input type="text" id="telefono_donante" name="telefono_donante" required>
            </div>

            <!-- Dirección del donante -->
            <div class="form-group">
                <label for="direccion_donante">Dirección Donante:</label>
                <textarea id="direccion_donante" name="direccion_donante" required></textarea>
            </div>

            <!-- Cantidad de alimentos -->
            <div class="form-group">
                <label for="cantidad_alimentos">Cantidad de Alimentos:</label>
                <input type="number" id="cantidad_alimentos" name="cantidad_alimentos" required>
            </div>

            <!-- Tipo de alimentos -->
            <div class="form-group">
                <label for="tipo_alimentos">Tipo de Alimentos:</label>
                <select id="tipo_alimentos" name="tipo_alimentos_id" required>
                    <option value="">Seleccionar</option>
                    <?php while ($row = mysqli_fetch_assoc($tipos_alimentos)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nombre_tipo']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Comentario opcional -->
            <div class="form-group">
                <label for="comentario">Comentario (opcional):</label>
                <textarea id="comentario" name="comentario"></textarea>
            </div>

            <!-- Fecha de entrega -->
            <div class="form-group">
                <label for="fecha_entrega">Fecha de Entrega:</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" required>
            </div>

            <!-- Horario disponible -->
            <div class="form-group">
                <label for="horario_disponible">Horario Disponible:</label>
                <input type="time" id="horario_disponible" name="horario_disponible" required>
            </div>

            <!-- Preferencia de contacto -->
            <div class="form-group">
                <label for="preferencia_contacto">Preferencia de Contacto:</label>
                <select id="preferencia_contacto" name="preferencia_contacto" required>
                    <option value="">Seleccionar</option>
                    <option value="Correo">Correo</option>
                    <option value="Teléfono">Teléfono</option>
                </select>
            </div>

            <!-- Número de donaciones -->
            <div class="form-group">
                <label for="cantidad_donaciones">Número de Donaciones:</label>
                <input type="number" id="cantidad_donaciones" name="cantidad_donaciones" required>
            </div>

            <!-- Botón para enviar el formulario -->
            <div class="form-group">
                <button type="submit">Realizar Donación</button>
            </div>
        </form>
    </div>
</body>

</html>
