<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Editar Gestiona</title></head>
<body>
<h1>Editar Gestiona</h1>
<form method="post" action="index.php?controller=gestiona&action=update">
    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($dato['id_usuario']) ?>">
    <input type="hidden" name="id_administrador" value="<?= htmlspecialchars($dato['id_administrador']) ?>">
    <input type="datetime-local" name="fecha_gestion" value="<?= htmlspecialchars($dato['fecha_gestion']) ?>"><br>
    <textarea name="descripcion"><?= htmlspecialchars($dato['descripcion']) ?></textarea><br>
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
