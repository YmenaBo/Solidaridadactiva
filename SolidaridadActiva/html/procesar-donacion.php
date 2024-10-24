<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "login"); // Sin contraseña

// Verificar conexion 
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener datos del formulario
$nombre_donante = $_POST['nombre_donante'];
$correo_donante = $_POST['correo_donante'];
$telefono_donante = $_POST['telefono_donante'];
$direccion_donante = $_POST['direccion_donante'];
$cantidad_alimentos = $_POST['cantidad_alimentos'];
$tipo_alimentos_id = $_POST['tipo_alimentos_id'];
$comentario = $_POST['comentario'];
$fecha_entrega = $_POST['fecha_entrega']; 
$horario_disponible = $_POST['horario_disponible']; 
$preferencia_contacto = $_POST['preferencia_contacto']; 
$cantidad_donaciones = 1; 

// Insertar datos en la tabla donaciones
$sql = "INSERT INTO donaciones (nombre_donante, correo_donante, telefono_donante, direccion_donante, cantidad_alimentos, tipo_alimentos_id, comentario, fecha_entrega, horario_disponible, preferencia_contacto, cantidad_donaciones) 
VALUES ('$nombre_donante', '$correo_donante', '$telefono_donante', '$direccion_donante', $cantidad_alimentos, $tipo_alimentos_id, '$comentario', '$fecha_entrega', '$horario_disponible', '$preferencia_contacto', $cantidad_donaciones)";

if ($conexion->query($sql) === TRUE) {
    echo "Donación registrada con éxito.";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
