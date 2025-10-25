<?php
// views/administrador/edit.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
</head>
<body>
    <h1>Editar Administrador</h1>
    <form method="post" action="index.php?controller=administrador&action=update">
        <input type="hidden" name="id" value="<?= $admin['id_administrador'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($admin['nombre']) ?>" required><br>
        <input type="email" name="correo" value="<?= htmlspecialchars($admin['correo']) ?>" required><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($admin['telefono']) ?>" required><br>
        <input type="text" name="especialidad" value="<?= htmlspecialchars($admin['especialidad']) ?>"><br>
        <input type="text" name="estado" value="<?= htmlspecialchars($admin['estado']) ?>"><br>
        <input type="number" name="cantrep_resuelto" value="<?= htmlspecialchars($admin['cantrep_resuelto']) ?>" min="0"><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>