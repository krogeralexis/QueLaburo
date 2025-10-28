<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/estilos.css" />

<head>
    <meta charset="UTF-8" />
    <title>Reservas</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .navbar {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }
        .navbar a {
            padding: 10px 18px;
            background-color: #2e2e2e;
            color: #d4f8d4;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
        }
        .navbar a:hover {
            background-color: #3d3d3d;
        }
        .container {
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        a.button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .delete-link {
            color: #dc3545;
            text-decoration: none;
        }
        .delete-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <style>
    .navbar {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 30px;
        padding: 10px;
    }

    .navbar a {
        padding: 10px 18px;
        background-color: #2e2e2e; /* gris oscuro */
        color: #d4f8d4; /* verde suave */
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        font-family: 'Segoe UI', sans-serif;
        transition: all 0.2s ease-in-out;
        border: 1px solid #2e2e2e;
    }

    .navbar a:hover {
        background-color: #3d3d3d;
        color: #afffaf;
        border-color: #4d4d4d;
    }
</style>

<div class="navbar">
    <a href="index.php?controller=usuario&action=indexA">Usuarios</a>
    <a href="index.php?controller=cliente&action=index">Clientes</a>
    <a href="index.php?controller=proveedor&action=indexA">Proveedores</a>
    <a href="index.php?controller=administrador&action=index">Administradores</a>
    <a href="index.php?controller=reserva&action=index">Reservas</a>
    <a href="index.php?controller=mensaje&action=index">Mensajes</a>
    <a href="index.php?controller=usuario&action=index">Inicio</a>
</div>

    <div class="container">
        <h1>Lista de Reservas</h1>
        <a href="index.php?controller=reserva&action=create" class="button">Registrar nueva reserva</a>
        <table>
            <thead>
                <tr>
                    <th>ID Reserva</th>
                    <th>ID Cliente</th>
                    <th>ID Proveedor</th>
                    <th>ID Servicio</th>
                    <th>Recordatorio</th>
                    <th>Reseña</th>
                    <th>Fecha Reserva</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= $reserva['id_reserva'] ?></td>
                    <td><?= htmlspecialchars($reserva['id_cliente']) ?></td>
                    <td><?= htmlspecialchars($reserva['id_proveedor']) ?></td>
                    <td><?= htmlspecialchars($reserva['id_servicio']) ?></td>
                    <td><?= htmlspecialchars($reserva['recordatorio']) ?></td>
                    <td><?= htmlspecialchars($reserva['reseña']) ?></td>
                    <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                    <td>
                        <a href="index.php?controller=reserva&action=edit&id=<?= $reserva['id_reserva'] ?>">Editar</a> |
                        <a href="index.php?controller=reserva&action=delete&id=<?= $reserva['id_reserva'] ?>" class="delete-link" onclick="return confirm('¿Eliminar reserva?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($reservas)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">No hay reservas registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
