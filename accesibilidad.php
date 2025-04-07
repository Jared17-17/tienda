<!-- accesibilidad.php -->
<div class="accesibilidad-bar">
    <form method="post" style="display:inline;">
        <button type="submit" name="modo" value="toggle">
            <?php echo (isset($_COOKIE['modo']) && $_COOKIE['modo'] == 'oscuro') ? '☀️ Modo Claro' : '🌙 Modo Oscuro'; ?>
        </button>
    </form>

    <form method="post" style="display:inline;">
        <button type="submit" name="contraste" value="toggle">🔳 Alto Contraste</button>
    </form>

    <form method="post" style="display:inline;">
        <button type="submit" name="texto" value="toggle">🔠 Aumentar Texto</button>
    </form>

    <form method="post" style="display:inline;">
        <button type="submit" name="resetear" value="1">♻️ Resetear</button>
    </form>
</div>

<?php
// Lógica simple para guardar las preferencias en cookies
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modo']) && $_POST['modo'] == 'toggle') {
        $estado = ($_COOKIE['modo'] ?? 'claro') === 'oscuro' ? 'claro' : 'oscuro';
        setcookie('modo', $estado, time() + 3600, "/");
    }
    if (isset($_POST['contraste']) && $_POST['contraste'] == 'toggle') {
        $estado = ($_COOKIE['contraste'] ?? 'no') === 'si' ? 'no' : 'si';
        setcookie('contraste', $estado, time() + 3600, "/");
    }
    if (isset($_POST['texto']) && $_POST['texto'] == 'toggle') {
        $estado = ($_COOKIE['texto'] ?? 'normal') === 'grande' ? 'normal' : 'grande';
        setcookie('texto', $estado, time() + 3600, "/");
    }
    if (isset($_POST['resetear'])) {
        setcookie('modo', '', time() - 3600, "/");
        setcookie('contraste', '', time() - 3600, "/");
        setcookie('texto', '', time() - 3600, "/");
    }
    header("Refresh:0");
}
?>

<?php
// Aplicar clases al body según las cookies
echo "<style>";
if (isset($_COOKIE['modo']) && $_COOKIE['modo'] == 'oscuro') {
    echo "body { background-color: #1e1e1e; color: #e0e0e0; } .container { background-color: #2a2a2a; color: #e0e0e0; }";
}
if (isset($_COOKIE['contraste']) && $_COOKIE['contraste'] == 'si') {
    echo "body { background-color: #000000 !important; color: #FFD700 !important; }";
}
if (isset($_COOKIE['texto']) && $_COOKIE['texto'] == 'grande') {
    echo "body { font-size: 1.2em; }";
}
echo "</style>";
?>
