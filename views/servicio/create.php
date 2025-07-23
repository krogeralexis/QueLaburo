<?php
// views/servicio/create.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear Servicio</title>
</head>
<body>
    <h1>Crear Servicio</h1>
    <form method="post" action="index.php?controller=servicio&action=store">
        <input type="text" name="titulo" placeholder="Título" required><br>
        <input type="text" name="categoria" placeholder="Categoría"><br>
        <input type="text" name="disponibilidad" placeholder="Disponibilidad"><br>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required><br>
        <textarea name="descripcion" placeholder="Descripción"></textarea><br>
        <input type="text" name="imagen" placeholder="URL Imagen"><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>