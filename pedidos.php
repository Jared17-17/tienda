<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido Finalizado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

    <div class="container">
        <h1>¡Gracias por tu Compra! 🧾</h1>

        <p>Tu pedido ha sido registrado exitosamente.</p>
        <p>En breve recibirás un correo con los detalles de tu compra.</p>

        <div style="margin-top: 2rem;">
            <a href="welcomen.php" class="btn">Volver al Inicio</a>
        </div>
    </div>
</body>
</html>
