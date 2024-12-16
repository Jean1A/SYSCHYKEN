<?php
// Iniciar sesión
session_start();

// Inicializar variables para mensajes
$mensaje = "";
$tipo_mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Comprobar si las credenciales son correctas
    if ($correo === 'admin@gmail.com' && $contraseña === 'admin') {
        $_SESSION['usuario_id'] = 1; // Asignar un ID a la sesión para el admin
        header("Location: admin.php"); // Redirigir al admin
        exit();
    } else {
        // Aquí puedes incluir la lógica para verificar las credenciales de los usuarios normales
        // Si es un usuario normal, verifica en la base de datos

        include 'conectar.php'; // Incluir conexión a la base de datos

        // Consultar la base de datos para encontrar el usuario
        $sql = "SELECT * FROM clientes WHERE correo = ? AND contraseña = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $correo, $contraseña);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Credenciales correctas, iniciar sesión
            $usuario = $resultado->fetch_assoc();
            $_SESSION['usuario_id'] = $usuario['id']; // Asigna el ID del usuario a la sesión
            header("Location: index.php"); // Redirigir al usuario normal a la página principal
            exit();
        } else {
            $mensaje = "Credenciales incorrectas.";
            $tipo_mensaje = "error";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tio Chepe</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <!-- Barra de navegación -->
    <header>
        <div class="container">
            <div class="logo">
                <h1>Tio Chepe 🍽️</h1>  <!-- Nombre o logo del restaurante -->
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="sobre.php">Sobre Nosotros</a></li>
                    <li><a href="menu.php">Menú</a></li>
                </ul>
            </nav>
            <div class="user-options">
                <a href="buscador.php" class="icon">🔍</a>
                <a href="carrito.php" class="icon">🛒(0)</a>  <!-- Ícono de carrito -->
                <a href="perfil.php" class="icon">👤</a>  <!-- Ícono de usuario (login/registro) -->
            </div>
        </div>
    </header>
    <br>
    <br>
    <center><h2>Iniciar Sesión</h2></center>
        
    <div class="container">

        <?php if ($mensaje): ?>
            <div class="<?= $tipo_mensaje == 'success' ? 'success-message' : 'error-message' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>
  <center>
       <form action="" method="post">
           <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form></center>
       
        <a href="registro.php">Registrate</a>

    </div>
</body>
</html>
