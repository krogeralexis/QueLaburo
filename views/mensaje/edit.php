<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Editar Mensaje</title></head>
<body>
<h1>Editar Mensaje</h1>
<form method="post" action="index.php?controller=mensaje&action=update">
    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($mensaje['id_usuario']) ?>">
    <input type="hidden" name="id_mensaje" value="<?= htmlspecialchars($mensaje['id_mensaje']) ?>">
    <input type="text" name="estado" value="<?= htmlspecialchars($mensaje['estado']) ?>" placeholder="Estado"><br>
    <input type="text" name="notificacion" value="<?= htmlspecialchars($mensaje['notificacion']) ?>" placeholder="Notificación"><br>
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
