<?php
// views/servicio/edit.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Servicio</title>
</head>
<body>
    <h1>Editar Servicio</h1>
    <form method="post" action="index.php?controller=servicio&action=update">
        <input type="hidden" name="id" value="<?= $servicio['id_servicio'] ?>">
        <input type="text" name="titulo" value="<?= htmlspecialchars($servicio['titulo']) ?>" required><br>
        <input type="text" name="categoria" value="<?= htmlspecialchars($servicio['categoria']) ?>"><br>
        <input type="text" name="disponibilidad" value="<?= htmlspecialchars($servicio['disponibilidad']) ?>"><br>
        <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($servicio['precio']) ?>" required><br>
        <textarea name="descripcion"><?= htmlspecialchars($servicio['descripcion']) ?></textarea><br>
        <input type="text" name="imagen" value="<?= htmlspecialchars($servicio['imagen']) ?>"><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>