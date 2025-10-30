<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="css/estilos.css" />

<head>
    <meta charset="UTF-8" />
    <title>Registrar Proveedor</title>
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
        input, textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus {
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
    <h1>Registrar Servicio</h1>
    <form method="post" action="index.php?controller=servicio&action=store" enctype="multipart/form-data">
        <!-- id_servicio es autoincremental, no se muestra -->

        <!-- id_proveedor se obtiene desde la sesión -->
        <input type="hidden" name="id_proveedor" value="<?php echo $_SESSION['usuario']['id']; ?>">

        <!-- Disponibilidad predeterminada -->
        <input type="hidden" name="disponibilidad" value="Disponible">

        <!-- Categoría -->
        <input type="text" name="categoria" placeholder="Categoría del servicio" required>

        <!-- Título -->
        <input type="text" name="titulo" placeholder="Título del servicio" required>

        <!-- Descripción -->
        <textarea name="descripcion" placeholder="Descripción del servicio" required></textarea>

        <!-- Precio -->
        <input type="number" name="precio" placeholder="Precio (en USD)" min="0" step="0.01" required>

        <!-- Imagen (archivo subido) -->
        <label for="imagen">Imagen del servicio:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>

        <button type="submit">Registrar Servicio</button>
    </form>

    <a href="index.php?controller=servicio&action=index" class="back-link">← Volver a la lista de servicios</a>
</div>

</body>
</html>
