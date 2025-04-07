<?php
session_start();

// funciones del inventario
function readInventory($filename = 'almacen.txt') {
    $inventory = [];
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($id, $name, $price, $stock) = explode(';', $line);
            $inventory[trim($id)] = intval(trim($stock));
        }
    }
    return $inventory;
}

function writeInventory($inventory, $filename = 'almacen.txt') {
    $updatedLines = [];
    foreach ($inventory as $id => $stock) {
        // recupera el nombre y precio 
        $name = $_SESSION['nombres'][$id] ?? ucfirst($id);
        $price = $_SESSION['precios'][$id] ?? 0;
        $updatedLines[] = "$id;$name;$price;$stock";
    }
    file_put_contents($filename, implode(PHP_EOL, $updatedLines));
}

// procesa las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = $_POST['product_id'];

    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['mensaje'] = " Producto no encontrado.";
    } else {
        $inventory = readInventory();
        $oldQty = $_SESSION['cart'][$productId]['quantity'];

        if ($action === 'update') {
            $newQty = intval($_POST['quantity']);
            $diff = $newQty - $oldQty;

            if ($diff > 0) {
                if ($inventory[$productId] >= $diff) {
                    $_SESSION['cart'][$productId]['quantity'] = $newQty;
                    $inventory[$productId] -= $diff;
                    $_SESSION['mensaje'] = " Cantidad aumentada.";
                } else {
                    $_SESSION['mensaje'] = " Stock insuficiente.";
                }
            } else {
                $_SESSION['cart'][$productId]['quantity'] = $newQty;
                $inventory[$productId] += abs($diff);
                $_SESSION['mensaje'] = ($newQty > 0) ? " Cantidad reducida." : " Producto eliminado.";
                if ($newQty == 0) unset($_SESSION['cart'][$productId]);
            }

        } elseif ($action === 'delete') {
            $inventory[$productId] += $oldQty;
            unset($_SESSION['cart'][$productId]);
            $_SESSION['mensaje'] = " Producto eliminado.";
        }

        writeInventory($inventory);
    }

    //  redirecciona para aplicar los cambios
    header("Location: viewCart.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1>Tu Carrito de Compras</h1>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p><strong><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></strong></p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0;
                foreach ($_SESSION['cart'] as $id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $grandTotal += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <form action="viewCart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" required>
                                <input type="hidden" name="action" value="update">
                                <button type="submit"> Actualizar</button>
                            </form>
                        </td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form action="viewCart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit"> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total a pagar:</strong></td>
                    <td colspan="2"><strong>$<?php echo number_format($grandTotal, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>

    <p>
        <a href="welcomen.php" class="btn"> Seguir Comprando</a>
        <a href="pedidos.php" class="btn"> Finalizar Pedido</a>
    </p>
</div>

</body>
</html>
