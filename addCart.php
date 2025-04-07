<?php
session_start();

// Recibe los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    // Cargar inventario
    $almacen = [];
    if (file_exists('almacen.txt')) {
        $lineas = file('almacen.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lineas as $linea) {
            list($pid, $pnombre, $pprecio, $pstock) = explode(';', $linea);
            $almacen[trim($pid)] = [
                'nombre' => trim($pnombre),
                'precio' => floatval($pprecio),
                'stock' => intval($pstock)
            ];
        }
    }

    // Verificar stock disponible
    if (!isset($almacen[$id]) || $almacen[$id]['stock'] < $cantidad) {
        $_SESSION['mensaje'] = "❌ No hay suficiente stock disponible.";
        header("Location: welcomen.php");
        exit;
    }

    // Agregar al carrito (aumentar si ya existe)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $cantidad;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $nombre,
            'price' => $precio,
            'quantity' => $cantidad
        ];
    }

    // Restar del inventario
    $almacen[$id]['stock'] -= $cantidad;

    // Guardar inventario actualizado
    $lineas_actualizadas = [];
    foreach ($almacen as $pid => $datos) {
        $lineas_actualizadas[] = "$pid;{$datos['nombre']};{$datos['precio']};{$datos['stock']}";
    }
    file_put_contents('almacen.txt', implode(PHP_EOL, $lineas_actualizadas));

    // Confirmación
    $_SESSION['mensaje'] = "✅ Producto agregado al carrito correctamente.";
    header("Location: welcomen.php");
    exit;
}
