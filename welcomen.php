<?php
// welcomen.php - Página de bienvenida
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Nuestra Tienda</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Función para alternar clases de accesibilidad en el body
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
        <h1>Bienvenido a Nuestra Tienda</h1>
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
    </div>
    <div class="footer">
    </div>
</body>
</html>
