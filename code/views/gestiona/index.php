<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Gestiona</title></head>
<body>
<h1>Lista de Gestiona</h1>
<a href="index.php?controller=gestiona&action=create">Crear Nuevo</a>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID Usuario</th><th>ID Administrador</th><th>Fecha Gestión</th><th>Descripción</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d['id_usuario']) ?></td>
            <td><?= htmlspecialchars($d['id_administrador']) ?></td>
            <td><?= htmlspecialchars($d['fecha_gestion']) ?></td>
            <td><?= htmlspecialchars($d['descripcion']) ?></td>
            <td>
                <a href="index.php?controller=gestiona&action=edit&id_usuario=<?= $d['id_usuario'] ?>&id_administrador=<?= $d['id_administrador'] ?>">Editar</a> |
                <a href="index.php?controller=gestiona&action=delete&id_usuario=<?= $d['id_usuario'] ?>&id_administrador=<?= $d['id_administrador'] ?>" onclick="return confirm('¿Eliminar este registro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
