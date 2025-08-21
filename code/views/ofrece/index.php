<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Ofrece</title></head>
<body>
<h1>Lista de Ofrece</h1>
<a href="index.php?controller=ofrece&action=create">Crear Nuevo Registro</a>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID Proveedor</th><th>ID Servicio</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['id_proveedor']) ?></td>
            <td><?= htmlspecialchars($d['id_servicio']) ?></td>
            <td>
                <a href="index.php?controller=ofrece&action=delete&id_proveedor=<?= $d['id_proveedor'] ?>&id_servicio=<?= $d['id_servicio'] ?>" onclick="return confirm('¿Eliminar este registro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
