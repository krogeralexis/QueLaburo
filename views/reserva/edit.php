<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Editar Reserva</title></head>
<body>
<h1>Editar Reserva</h1>
<form method="post" action="index.php?controller=reserva&action=update">
    <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">
    <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($reserva['id_cliente']) ?>">
    <input type="hidden" name="id_proveedor" value="<?= htmlspecialchars($reserva['id_proveedor']) ?>">
    <input type="hidden" name="id_servicio" value="<?= htmlspecialchars($reserva['id_servicio']) ?>">

    <input type="text" name="recordatorio" value="<?= htmlspecialchars($reserva['recordatorio']) ?>" placeholder="Recordatorio"><br>
    <textarea name="resena" placeholder="Reseña"><?= htmlspecialchars($reserva['reseña']) ?></textarea><br>
    <input type="date" name="fecha_reserva" value="<?= htmlspecialchars($reserva['fecha_reserva']) ?>" placeholder="Fecha de reserva"><br>
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
