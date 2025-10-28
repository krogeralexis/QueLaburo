<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/estilos.css" />

<head>
    <meta charset="UTF-8">
    <title>Usuarios Registrados</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    <a href="index.php?controller=usuario&action=index">Usuarios</a>
    <a href="index.php?controller=cliente&action=index">Clientes</a>
    <a href="index.php?controller=proveedor&action=indexA">Proveedores</a>
    <a href="index.php?controller=administrador&action=index">Administradores</a>
    <a href="index.php?controller=reserva&action=index">Reservas</a>
    <a href="index.php?controller=mensaje&action=index">Mensajes</a>
    <a href="index.php?controller=usuario&action=index">Inicio</a>
</div>
    <div class="container">
        <h1>Usuarios Registrados</h1>
        <a href="index.php?controller=usuario&action=create" class="button">Registrar nuevo usuario</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= $usuario['fecha_creacion'] ?></td>
                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                        <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                        <td>
                            <a href="index.php?controller=usuario&action=delete&id=<?= $usuario['id'] ?>" class="delete-link" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>