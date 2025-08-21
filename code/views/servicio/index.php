<?php
// views/servicio/index.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Servicios</title>
</head>
<body>
    <h1>Lista de Servicios</h1>
    <a href="index.php?controller=servicio&action=create">Crear Nuevo Servicio</a>
    <ul>
        <?php foreach ($servicios as $servicio): ?>
            <li>
                <?= htmlspecialchars($servicio['titulo']) ?> - $<?= htmlspecialchars($servicio['precio']) ?> - <?= htmlspecialchars($servicio['categoria']) ?> - <?= htmlspecialchars($servicio['disponibilidad']) ?>
                <a href="index.php?controller=servicio&action=edit&id=<?= $servicio['id_servicio'] ?>">Editar</a>
                <a href="index.php?controller=servicio&action=delete&id=<?= $servicio['id_servicio'] ?>" onclick="return confirm('¿Eliminar este servicio?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>