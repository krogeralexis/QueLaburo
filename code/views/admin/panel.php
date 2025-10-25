<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="/css/main.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fafafa;
      margin: 0;
      padding: 0;
    }
    header {
      background: #21272A;
      color: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    main {
      padding: 2rem;
    }
    a {
      color: #fff;
      text-decoration: none;
      background: #e74c3c;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      transition: background 0.3s;
    }
    a:hover {
      background: #c0392b;
    }
  </style>
</head>
<body>
  <header>
    <h1>Bienvenido, Administrador #<?= htmlspecialchars($admin_id) ?></h1>
    <a href="index.php?controller=adminAuth&action=logout">Cerrar sesión</a>
  </header>

  <main>
    <p>Este es el panel administrativo. Aquí podrás gestionar usuarios, servicios y más.</p>
  </main>
</body>
</html>
