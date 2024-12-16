<?php
session_start();

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    header("Location: menu.php"); // Redirigir si no hay productos en el carrito
    exit();
}

// Calcular el costo total
$total = 0;
$productos = [];

include 'conectar.php'; // Incluir la conexión a la base de datos

foreach ($_SESSION['carrito'] as $id => $cantidad) {
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
        $productos[] = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'cantidad' => $cantidad,
            'precio' => $producto['precio'],
            'total' => $producto['precio'] * $cantidad
        ];
        $total += $producto['precio'] * $cantidad;
    }
}

$stmt->close();

// Procesar el pedido al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar_pedido'])) {
    $precio_total = $total; // Total calculado
    $id_cliente = $_SESSION['cliente_id'] ?? null; // Obtener ID del cliente de la sesión

    include 'conectar.php'; // Incluir la conexión a la base de datos

    // Insertar el pedido en la base de datos
    $sql = "INSERT INTO pedidos (id_cliente, precio_total) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $id_cliente, $precio_total);

    if ($stmt->execute()) {
        // Vaciar el carrito
        unset($_SESSION['carrito']);
        
        // Redirigir a la página de pedido completado
        header("Location: pedido_completado.php");
        exit();
    } else {
        $error = "Error al enviar el pedido: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Tio Chepe</title>
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
    </header><br>
    <h2><center>Carrito de Compras</h2><br></center><br>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                   <center> <th>Cantidad</th></center>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                        <td>S/. <?= number_format($producto['precio'], 2) ?></td>
                        <td>S/. <?= number_format($producto['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">Total General</td>
                    <td>S/. <?= number_format($total, 2) ?></td>
                </tr>
            </tbody>
        </table>
        <?php if (isset($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
        <br><button type="submit" name="enviar_pedido">Enviar Pedido</button>
        </form>
    </div>
</body>
</html>
