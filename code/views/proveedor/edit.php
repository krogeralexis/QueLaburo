<?php
// views/proveedor/edit.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Proveedor</title>
</head>
<body>
    <h1>Editar Proveedor</h1>
    <form method="post" action="index.php?controller=proveedor&action=update">
        <input type="hidden" name="id" value="<?= $proveedor['id_proveedor'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($proveedor['nombre']) ?>" required><br>
        <input type="email" name="correo" value="<?= htmlspecialchars($proveedor['correo']) ?>" required><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($proveedor['telefono']) ?>" required><br>
        <input type="text" name="referencias" value="<?= htmlspecialchars($proveedor['referencias']) ?>"><br>
        <input type="number" step="0.1" name="calificacion" value="<?= htmlspecialchars($proveedor['calificacion']) ?>" min="0" max="5"><br>
        <input type="number" name="cantidad_ventas" value="<?= htmlspecialchars($proveedor['cantidad_ventas']) ?>" min="0"><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>