<?php
session_start();

include 'conectar.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM clientes WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    echo "No se encontró información del usuario.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Tio Chepe</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <!-- Parte superior con título -->
    <div class="header">
        Tío Chepe 🍽️
    </div>
    <!-- Barra de navegación -->
    <div class="navbar">
        <div class="user-options">
            <a href="perfil.php" class="icon">👤</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="sobre.php">DELIVERY</a></li>
                <li><a href="menu.php">ORDENAR</a></li>
            </ul>
        </nav>
    </div>
    <br>
    <br>
 <center><h2>Perfil de Usuario</h2>
 <br>
 <br>
    <div class="">
       
        
        <div class="perfil-info">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p> <br>
            <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']) ?></p> <br>
            <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono']) ?></p> <br>
        </div>
        

    </div>
    <a href="cerrar.php">Cerrar sesión</a></center>
</body>
</html>
