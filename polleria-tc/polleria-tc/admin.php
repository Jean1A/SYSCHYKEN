<?php
session_start();

include 'conectar.php';

if (!isset($_SESSION['usuario_id'])) {
    // Comprobar las credenciales del admin
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña'];

        // Comprobar si las credenciales coinciden
        if ($correo === 'admin@gmail.com' && $contraseña === 'admin') {
            // Guardar el ID del admin en la sesión (puedes usar cualquier ID, aquí se usa 1)
            $_SESSION['usuario_id'] = 1; 
        } else {
            $mensaje = "Credenciales incorrectas.";
            $tipo_mensaje = "error";
        }
    } else {
        header("Location: login.php");
        exit();
    }
}
// Información del administrador (puedes personalizar estos datos o sacarlos de la base de datos)
$nombre_admin = "Administrador Tio Chepe"; // Cambia esto según el nombre del administrador
$correo_admin = "admin@gmail.com"; // El correo del administrador

$conn->close();
?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tio Chepe</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header>
        <div class="container">
            <div class="logo">
                <h1>Tio Chepe 🍽️</h1>  <!-- Nombre o logo del restaurante -->
            </div>
            <nav>
                <ul>
                    <li><a href="admin.php">Home</a></li>
                    <li><a href="admin_pedidos.php">Pedidos</a></li>
                    <li><a href="admin_productos.php">Agregar</a></li>
                </ul>
            </nav>
            <div class="user-options">
                <a href="perfil.php" class="icon">👤</a>
            </div>
        </div>

    </header>

    <div class="container">
        <h2>Perfil del Administrador</h2>
        <div class="perfil">
            <p><strong>Nombre:</strong> <?= $nombre_admin ?></p>
            <p><strong>Correo:</strong> <?= $correo_admin ?></p>
        </div>

      
        <a href="index.php">Volver al menu de usuario</a>
    </div>
</body>
</html>

