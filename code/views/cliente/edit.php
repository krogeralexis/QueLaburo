<?php
// views/cliente/edit.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <form method="post" action="index.php?controller=cliente&action=update">
        <input type="hidden" name="id" value="<?= $cliente['id_cliente'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required><br>
        <input type="email" name="correo" value="<?= htmlspecialchars($cliente['correo']) ?>" required><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required><br>
        <input type="number" name="calificaciones" value="<?= htmlspecialchars($cliente['calificaciones']) ?>" min="0" max="5"><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>