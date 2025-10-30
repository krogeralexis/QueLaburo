<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Estilo básico para el formulario de register */
        
        .form-container {
            text-align: center;
            max-width: 400px;
            height: auto;
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

        .sign-up-label {
            font-size: 14px;
            margin: 10px 0;
        }

        .sign-up-link {
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }

        .sign-up-link:hover {
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
        <p class="title">Registro</p>
        <form class="form" id="registerForm" method="POST" action="index.php?controller=login&action=register">
            <input type="text" name="nombre" class="input" placeholder="Nombre completo" required>
            <input type="email" name="correo" class="input" placeholder="Correo electrónico" required>
            <input type="tel" name="telefono" class="input" placeholder="Teléfono" required pattern="[0-9]{8,15}" title="Solo números (8 a 15 dígitos)">
            <input type="password" name="password" class="input" placeholder="Contraseña" required minlength="6">
            <input type="password" name="confirm_password" class="input" placeholder="Confirmar contraseña" required minlength="6">

            <label style="font-size: 0.9em; margin-top: 0.5em; display:block;">
                <input type="checkbox" name="terms" required>
                Acepto los términos y condiciones
            </label>

            <button class="form-btn" type="submit" style="margin-top:1em;">Registrarse</button>

            <p class="sign-up-label" style="margin-top:0.5em; text-align:center;">
                ¿Ya tenés una cuenta? <a class="sign-up-link" href="index.php?controller=login&action=index">Ingresá aquí</a>
            </p>

            <!-- Mensajes de error -->
            <?php if (!empty($errors ?? [])): ?>
                <div class="form-error" style="color:red; margin-top:0.5em;">
                    <?php foreach($errors as $err): ?>
                        <div><?= htmlspecialchars($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>


    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

</body>
</html>