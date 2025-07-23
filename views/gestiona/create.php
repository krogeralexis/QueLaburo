<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Crear Gestiona</title></head>
<body>
<h1>Crear Gestiona</h1>
<form method="post" action="index.php?controller=gestiona&action=store">
    <input type="number" name="id_usuario" placeholder="ID Usuario" required><br>
    <input type="number" name="id_administrador" placeholder="ID Administrador" required><br>
    <input type="datetime-local" name="fecha_gestion" placeholder="Fecha Gestión"><br>
    <textarea name="descripcion" placeholder="Descripción"></textarea><br>
    <button type="submit">Guardar</button>
</form>
</body>
</html>
