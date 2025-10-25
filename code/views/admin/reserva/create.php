<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/estilos.css" />

<head>
    <meta charset="UTF-8" />
    <title>Registrar Reserva</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
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
        form textarea,
        form select {
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
        form textarea:focus,
        form select:focus {
            border-color: #28a745;
            outline: none;
        }
        form textarea {
            resize: vertical;
            min-height: 80px;
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
        <h1>Registrar Nueva Reserva</h1>
        <form action="index.php?controller=reserva&action=store" method="post">
            <label for="id_cliente">ID Cliente</label>
            <input type="text" id="id_cliente" name="id_cliente" required>

            <label for="id_proveedor">ID Proveedor</label>
            <input type="text" id="id_proveedor" name="id_proveedor" required>

            <label for="id_servicio">ID Servicio</label>
            <input type="text" id="id_servicio" name="id_servicio" required>

            <label for="recordatorio">Recordatorio</label>
            <input type="text" id="recordatorio" name="recordatorio">

            <label for="resena">Reseña</label>
            <textarea id="resena" name="reseña" placeholder="Escribe una reseña..."></textarea>

            <label for="fecha_reserva">Fecha de Reserva</label>
            <input type="datetime-local" id="fecha_reserva" name="fecha_reserva" required>

            <div class="button-group">
                <button type="submit">Guardar Reserva</button>
            </div>
        </form>
        <a href="index.php?controller=reserva&action=index" class="back-link">← Volver a la lista de reservas</a>
    </div>
</body>
</html>
