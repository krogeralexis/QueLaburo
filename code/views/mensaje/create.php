<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/estilos.css" />

<head>
    <meta charset="UTF-8" />
    <title>Registrar Mensaje</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 480px;
            margin: 40px auto;
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        form input[type="text"],
        form input[type="datetime-local"],
        form textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus,
        form input[type="datetime-local"]:focus,
        form textarea:focus {
            border-color: #28a745;
            outline: none;
        }
        form textarea {
            resize: vertical;
            min-height: 100px;
        }
        .button-group {
            text-align: center;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 28px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.25s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #555;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Mensaje</h1>
        <form action="index.php?controller=mensaje&action=store" method="post">
            <label for="id_usuario">ID Usuario</label>
            <input type="text" id="id_usuario" name="id_usuario" required>

            <label for="id_emisor">ID Emisor</label>
            <input type="text" id="id_emisor" name="id_emisor" required>

            <label for="id_receptor">ID Receptor</label>
            <input type="text" id="id_receptor" name="id_receptor" required>

            <label for="estado">Estado</label>
            <input type="text" id="estado" name="estado">

            <label for="notificacion">Notificación</label>
            <input type="text" id="notificacion" name="notificacion">

            <label for="fecha">Fecha</label>
            <input type="datetime-local" id="fecha" name="fecha" required>

            <div class="button-group">
                <button type="submit">Guardar Mensaje</button>
            </div>
        </form>
        <a href="index.php?controller=mensaje&action=index" class="back-link">← Volver a la lista de mensajes</a>
    </div>
</body>
</html>
