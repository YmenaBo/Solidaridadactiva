<?php 
include 'connect.php';

if (isset($_POST['signUp'])) {
    // Obtener los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre'])); // Asumiendo que 'nombre' es el campo completo del nombre del usuario
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $password = $_POST['password'];

    // Encriptar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el email ya existe en la base de datos
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    
    if ($result->num_rows > 0) {
        echo "¡La dirección de correo ya existe!";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $insertQuery = "INSERT INTO users (nombre, email, usuario, password) VALUES ('$nombre', '$email', '$usuario', '$passwordHash')";
        
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: Login.php"); 
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Consultar si el usuario existe con el email proporcionado
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['email'] = $row['email'];
            header("Location: homepage.php");
            exit();
        } else {
            echo "No encontrado, correo o contraseña incorrecta.";
        }
    } else {
        echo "No encontrado, correo o contraseña incorrecta.";
    }
}
?>
