<?php
// Conexión a la base de datos
include 'conectar.php';

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $telefono = $_POST['telefono'];

    $sql = "INSERT INTO clientes (nombre, correo, contraseña, telefono) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $contraseña, $telefono);

    if ($stmt->execute()) {
        $mensaje = "Registro exitoso. ¡Bienvenido!";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Error: " . $stmt->error;
        $tipo_mensaje = "error";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tio Chepe</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
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
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        
        <?php if ($mensaje): ?>
            <div class="<?= $tipo_mensaje == 'success' ? 'success-message' : 'error-message' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <button type="submit">Registrar</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
    </div>
</body>
</html>