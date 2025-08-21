<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/estilos.css" />

<head>
    <meta charset="UTF-8" />
    <title>Registrar Administrador</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 380px;
        }
        h1 {
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }
        input, select {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            border-color: #2e2e2e;
            outline: none;
        }
        button {
            width: 100%;
            background-color: #2e2e2e;
            color: #d4f8d4;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 600;
        }
        button:hover {
            background-color: #3d3d3d;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #2e2e2e;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registrar Administrador</h1>
        <form method="post" action="index.php?controller=administrador&action=store">
            <input type="text" name="nombre" placeholder="Nombre completo" required />
            <input type="email" name="correo" placeholder="Correo electrónico" required />
            <input type="text" name="telefono" placeholder="Teléfono" required />
            <input type="number" name="cantrep_resuelto" placeholder="Cantidad reportes resueltos" min="0" />
            <input type="text" name="estado" placeholder="Estado" />
            <input type="text" name="especialidad" placeholder="Especialidad" />
            <button type="submit">Registrar</button>
        </form>
        <a href="index.php?controller=administrador&action=index" class="back-link">← Volver a la lista de administradores</a>
    </div>
</body>
</html>
