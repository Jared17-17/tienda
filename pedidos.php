<?php
// pedidos.php - Página de Pedidos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos Realizados</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleAccessibility(className) {
            document.body.classList.toggle(className);
        }
        function resetText() {
            document.body.classList.remove('text-large');
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>Pedidos Realizados</h1>
    </div>
    <div class="accessibility-controls">
        <button onclick="toggleAccessibility('dark-mode')">Modo Nocturno</button>
        <button onclick="toggleAccessibility('high-contrast')">Alto Contraste</button>
        <button onclick="toggleAccessibility('text-large')">Aumentar Texto</button>
        <button onclick="resetText()">Resetear Texto</button>
    </div>
    <nav class="nav">
        <a href="welcomen.php">Inicio</a>
        <a href="viewCart.php">Carrito</a>
        <a href="pedidos.php">Pedidos</a>
    </nav>
    <div class="container">
        <h2>Historial de Pedidos</h2>
        <?php
        // Ejemplo random de pedidos
        $pedidos = [
            ['id' => 101, 'fecha' => '2025-03-20', 'total' => '$30'],
            ['id' => 102, 'fecha' => '2025-03-22', 'total' => '$50']
        ];
        if (!empty($pedidos)) {
            echo "<table>";
            echo "<thead><tr><th>ID Pedido</th><th>Fecha</th><th>Total</th></tr></thead>";
            echo "<tbody>";
            foreach ($pedidos as $pedido) {
                echo "<tr>";
                echo "<td>".$pedido['id']."</td>";
                echo "<td>".$pedido['fecha']."</td>";
                echo "<td>".$pedido['total']."</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No hay pedidos realizados.</p>";
        }
        ?>
    </div>
    <div class="footer">
    </div>
</body>
</html>
