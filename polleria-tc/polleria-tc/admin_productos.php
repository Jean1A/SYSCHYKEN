<?php
session_start();

include 'conectar.php';

// Si el usuario es administrador, mostrar el formulario
if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] === 1) {
    // Inicializar variables para mensajes
    $mensaje = "";
    $tipo_mensaje = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];

        // Manejo de la carga de la imagen
        $imagen = $_FILES['imagen']['name'];
        $ruta_imagen = 'imagenes/' . basename($imagen); // Ruta donde se guardará la imagen

        // Mover la imagen al directorio correspondiente
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            // Preparar la consulta SQL para insertar el nuevo plato
            $sql = "INSERT INTO productos (nombre, descripcion, categoria, precio, imagen) VALUES (?, ?, ?, ?, ?)";
            
            // Usar sentencias preparadas para evitar inyecciones SQL
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nombre, $descripcion, $categoria, $precio, $ruta_imagen);

            if ($stmt->execute()) {
                $mensaje = "Plato agregado exitosamente.";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error: " . $stmt->error;
                $tipo_mensaje = "error";
            }

            $stmt->close();
        } else {
            $mensaje = "Error al cargar la imagen.";
            $tipo_mensaje = "error";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Plato - Tio Chepe</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <!-- Barra de navegación -->
    <header>
        <div class="container">
            <div class="logo">
                <h1>Tio Chepe 🍽️</h1>
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
        <?php if (!isset($_SESSION['usuario_id'])): ?>
            <h2>Acceso Administrador</h2>
            <?php if (isset($mensaje)): ?>
                <div class="<?= $tipo_mensaje == 'success' ? 'success-message' : 'error-message' ?>">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>

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
            </form>

        <?php else: ?>
            <h2>Agregar Nuevo Plato</h2>
            
            <?php if ($mensaje): ?>
                <div class="<?= $tipo_mensaje == 'success' ? 'success-message' : 'error-message' ?>">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <input type="text" id="categoria" name="categoria" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" name="precio" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
                <button type="submit">Agregar Plato</button>
            </form>

            <a href="index.php">Volver a la página principal</a>
        <?php endif; ?>
    </div>
</body>
</html>
