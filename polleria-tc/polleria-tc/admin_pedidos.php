<?php
// Verificar acceso (aquí debes incluir tu verificación de sesión)
session_start();

include 'conectar.php';

// Consultar pedidos de la base de datos
$sql = "SELECT * FROM pedidos";
$resultado = $conn->query($sql);
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
    </header>
    <div class="container">
        <h2>Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>N°</th>

                    <th>Precio Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $fila['id'] ?></td>
                            <td>S/. <?= number_format($fila['precio_total'], 2) ?></td>
                            <td><?= $fila['fecha_pedido'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay pedidos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="index.php">Volver a la Página Principal</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
