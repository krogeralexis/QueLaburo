<?php
// views/usuario/edit.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="post" action="index.php?controller=usuario&action=update">
        <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br>
        <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>