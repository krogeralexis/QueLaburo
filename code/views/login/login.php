<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Estilo básico para el formulario de login */
        .form-container {
            text-align: center;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .input:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-btn {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-btn:hover {
            background-color: #0056b3;
        }

        .page-link, .sign-up-label {
            font-size: 14px;
            margin: 10px 0;
        }

        .page-link-label, .sign-up-link {
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }

        .page-link-label:hover, .sign-up-link:hover {
            color: #0056b3;
        }

        .form-error {
            font-size: 14px;
            text-align: center;
        }

        /* Responsive básico */
        @media (max-width: 600px) {
            .form-container {
                width: 95%;
                padding: 15px;
            }
            
            .input, .form-btn {
                width: 90%;
            }
        }
    </style>

<link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

        <?php include 'components/header-logins.php'; ?>



    <div class="form-container">
        <p class="title">Bienvenido</p>
        <form class="form" id="loginForm" method="POST" action="index.php?controller=login&action=authenticate">
            <input type="email" name="correo" class="input" placeholder="Email" required>
            <input type="password" name="password" class="input" placeholder="Contraseña" required>
            <p class="page-link"><span class="page-link-label">¿Olvidaste tu contraseña?</span></p>
            <button class="form-btn" type="submit">Iniciar Sesión</button>

            <?php if (!empty($error ?? '')): ?>
                <div class="form-error" style="color:red; margin-top:0.5em;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
        </form>

        <p class="sign-up-label">
            ¿No tenés una cuenta? <a class="sign-up-link" href="index.php?controller=login&action=register">Unirse</a>
        </p>
    </div>
 

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>
</body>
</html>