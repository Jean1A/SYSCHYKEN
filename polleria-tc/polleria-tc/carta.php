<?php
// Incluir el archivo de conexión
include 'conectar.php';

// Consultar datos de productos
$sql = "SELECT nombre, descripcion, categoria, precio, imagen FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta - Pollos y Parrillas Tío Chepe</title>
    <link rel="stylesheet" href="css/estilo.css">  <!-- Vinculamos la hoja de estilos -->
  
</head>
<body>
    <!-- Parte superior con título -->
    <div class="header">
        Pollos y Parrillas Tío Chepe
    </div>

    <!-- Barra de navegación -->
    <div class="navbar">
        <a href="index.php">Inicio</a>
        <a href="#">Promociones</a>
        <a href="#">Contacto</a>
    </div>

    <!-- Menú de la carta -->
    <div class="menu">CARTA</div>

    <!-- Categorías -->
    <div class="categories">
        <button>Pollos</button>
        <button>Parrillas</button>
        <button>Bebidas</button>
        <button>Ensaladas</button>
        <button>Guarniciones</button>
    </div>

    <!-- Productos -->
    <div class="card-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='imagenes/" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
                echo "<div class='details'>";
                echo "<h3>" . $row['nombre'] . "</h3>";
                echo "<p>" . $row['descripcion'] . "</p>";
                echo "<div class='price'>S/ " . $row['precio'] . "</div>";
                echo "<button>Añadir al carrito</button>";
                echo "</div></div>";
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        ?>
    </div>

</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>