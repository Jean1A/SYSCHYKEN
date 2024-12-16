<?php
session_start();
include 'conectar.php'; // Incluir la conexión a la base de datos

// Verificar si el carrito existe, si no, crear uno nuevo
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Consultar los productos en la base de datos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);
$productos = [];

if ($resultado->num_rows > 0) {
    while ($producto = $resultado->fetch_assoc()) {
        $productos[] = $producto;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Tio Chepe</title>
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
    <br>
    <center><h2>Menú de Productos</h2><br></center>
    <br>

    <div class="container">

        <table>
            <thead>
                <tr>
                <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" width="100"></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                        <td>S/. <?= number_format($producto['precio'], 2) ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="number" name="cantidad" value="1" min="1" max="10">
                                <input type="hidden" name="id_producto" value="<?= $producto['id'] ?>">
                                <button type="submit" name="agregar">Agregar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Agregar al carrito
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];

            if (isset($_SESSION['carrito'][$id_producto])) {
                $_SESSION['carrito'][$id_producto] += $cantidad;
            } else {
                $_SESSION['carrito'][$id_producto] = $cantidad;
            }

            echo "<p>Producto añadido al carrito.</p>";
        }
        ?>

    </div>
</body>
</html>
