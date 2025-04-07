<?php
session_start();

// Leer productos desde el archivo actualizado
$productos = [];

if (file_exists('almacen.txt')) {
    $lineas = file('almacen.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lineas as $linea) {
        list($id, $nombre, $precio, $stock) = explode(';', $linea);
        if ((int)$stock > 0) {
            $productos[] = [
                'id' => trim($id),
                'nombre' => trim($nombre),
                'precio' => floatval($precio),
                'stock' => intval($stock)
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <!-- Catálogo actualizado con selección de cantidad y envío al carrito -->
    <div class="container">
        <h1>Catálogo de Productos</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <p><strong><?php echo htmlspecialchars($_SESSION['mensaje']); ?></strong></p>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <?php if (count($productos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><?php echo $producto['stock']; ?></td>
                            <td>
                                <form action="addCart.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                    <input type="hidden" name="nombre" value="<?php echo $producto['nombre']; ?>">
                                    <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                                    <input type="number" name="cantidad" min="1" max="<?php echo $producto['stock']; ?>" value="1" required>
                            </td>
                            <td>
                                    <button type="submit" class="btn" title="Añadir al carrito">🛒 Añadir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>

        <p><a href="viewCart.php" class="btn">Ver Carrito</a></p>
    </div>
</body>
</html>
