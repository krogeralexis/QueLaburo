<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .perfil-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 350px;
        }
        .perfil-img {
            width: 120px;
            height: 120px;
            background: url('css/storage/userThumb.svg') no-repeat center center/cover;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            border: 4px solid #00c6ff;
        }
        .perfil-card h2 {
            margin: 0;
            font-size: 1.6em;
            color: #333;
        }
        .perfil-info {
            margin: 15px 0;
            color: #555;
            font-size: 0.95em;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: 0.3s;
        }
        .btn-primary {
            background: #00c6ff;
            color: #fff;
        }
        .btn-primary:hover {
            background: #009bd6;
        }
        .btn-secondary {
            background: #f1f1f1;
            color: #333;
        }
        .btn-secondary:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
    <div class="perfil-card">
        <div class="perfil-img"></div>
        <h2><?= htmlspecialchars($usuario['nombre']) ?></h2>

        <div class="perfil-info">
            <p><b>Email:</b> <?= htmlspecialchars($usuario['correo']) ?></p>
            <p><b>Teléfono:</b> <?= htmlspecialchars($usuario['telefono']) ?></p>
            <p><b>Fecha creación:</b> <?= htmlspecialchars($usuario['fecha_creacion']) ?></p>
        </div>

        <!-- Botón a index -->
        <a href="index.php?controller=usuario&action=index">
            <button class="btn btn-primary">Volver al listado</button>
        </a>
        
        <!-- Extra: botón secundario (ejemplo marcador) -->
        <button class="btn btn-secondary">Guardar perfil</button>
    </div>
</body>
</html>
