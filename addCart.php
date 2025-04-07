<?php
session_start();

// Si se recibe el parámetro para resetear el carrito, se borra la sesión de carrito
if (isset($_GET['resetCart']) && $_GET['resetCart'] == 1) {
    unset($_SESSION['carrito']);
    header("Location: addCart.php");
    exit();
}

// Procesa el formulario para agregar un producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $producto = $_POST['producto'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 1;
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    $_SESSION['carrito'][] = ['producto' => $producto, 'cantidad' => $cantidad];
    header("Location: viewCart.php");
    exit();
}

// Lee el inventario desde el archivo almacen.txt
$inventory = [];
$filename = "almacen.txt";
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $fields = preg_split('/\s+/', $line);
        $count = count($fields);
        if ($count >= 3) {
            $stock = $fields[$count - 2];
            $precio = $fields[$count - 1];
            $nameParts = array_slice($fields, 0, $count - 2);
            $nombre = implode(" ", $nameParts);
            $inventory[] = ['nombre' => $nombre, 'stock' => $stock, 'precio' => $precio];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar al Carrito</title>
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
        <h1>Agregar al Carrito</h1>
    </div>
    <div class="accessibility-controls">
        <button onclick="toggleAccessibility('dark-mode')">Modo Nocturno</button>
        <button onclick="toggleAccessibility('high-contrast')">Alto Contraste</button>
        <button onclick="toggleAccessibility('text-large')">Aumentar Texto</button>
        <button onclick="resetText()">Resetear Texto</button>
        <a href="addCart.php?resetCart=1" style="text-decoration:none;">
            <button>Resetear Carrito</button>
        </a>
    </div>
    <nav class="nav">
        <a href="welcomen.php">Inicio</a>
        <a href="viewCart.php">Carrito</a>
        <a href="pedidos.php">Pedidos</a>
    </nav>
    <div class="container">
        <h2>Productos Disponibles</h2>
        <?php if (!empty($inventory)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($item['stock']); ?></td>
                            <td><?php echo '$' . htmlspecialchars($item['precio']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos en el inventario.</p>
        <?php endif; ?>
        <h2>Agregar Producto al Carrito</h2>
        <form action="addCart.php" method="POST">
            <label for="producto">Seleccione el Producto:</label>
            <select id="producto" name="producto" required>
                <?php foreach ($inventory as $item): ?>
                    <option value="<?php echo htmlspecialchars($item['nombre']); ?>">
                        <?php echo htmlspecialchars($item['nombre']) . " - Stock: " . htmlspecialchars($item['stock']) . " - Precio: $" . htmlspecialchars($item['precio']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="1" min="1" required>
            
            <input type="hidden" name="action" value="add">
            <button type="submit">Agregar al Carrito</button>
        </form>
    </div>
    <div class="footer">
    </div>
</body>
</html>
