<?php
// viewCart.php - Vista del carrito
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
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
        <h1>Carrito de Compras</h1>
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
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])):
                    foreach ($_SESSION['carrito'] as $producto):
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                    </tr>
                <?php
                    endforeach;
                else:
                    echo "<tr><td colspan='2'>El carrito está vacío.</td></tr>";
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <div class="footer">
    </div>
</body>
</html>
