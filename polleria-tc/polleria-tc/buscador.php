<?php
session_start();
include 'conectar.php'; // Incluir la conexión a la base de datos

// Inicializar variable de búsqueda
$busqueda = "";

// Verificar si se ha realizado una búsqueda
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda'];
    $sql = "SELECT * FROM productos WHERE nombre LIKE ?";
    $stmt = $conn->prepare($sql);
    $busqueda_param = "%" . $busqueda . "%"; // Agregar los comodines para LIKE
    $stmt->bind_param("s", $busqueda_param);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $productos = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    // Si no hay búsqueda, no mostrar ningún producto
    $productos = [];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Platos - Tio Chepe</title>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="sobre.php">Sobre Nosotros</a></li>
                    <li><a href="menu.php">Menú</a></li>
                </ul>
            </nav>
            <div class="user-options">
                <a href="buscador.php" class="icon">🔍</a>
                <a href="carrito.php" class="icon">🛒(0)</a>
                <a href="perfil.php" class="icon">👤</a>
            </div>
        </div>
    </header>
    <div class="container">
        <h2>Buscador de Platos</h2>

        <!-- Formulario de Búsqueda -->
        <form action="buscador.php" method="post">
            <input type="text" name="busqueda" placeholder="Buscar un plato..." value="<?= htmlspecialchars($busqueda) ?>" required>
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <?php if (isset($_POST['buscar']) && count($productos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" width="100"></td>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                            <td>S/. <?= number_format($producto['precio'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_POST['buscar'])): ?>
            <p>No se encontraron platos que coincidan con la búsqueda.</p>
        <?php endif; ?>

        <a href="menu.">  </a>
    </div>
</body>
</html>
