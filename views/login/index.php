<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 320px;
            /* Quitar text-align: center para evitar desalinear inputs y labels */
            /* text-align: center; */
            display: flex;
            flex-direction: column;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center; /* Solo título centrado */
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            text-align: left;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        /* Estilo para el contenedor de contraseña con ojo */
        .password-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .password-wrapper input {
            width: 100%;
            padding: 10px 40px 10px 12px; /* espacio para el botón */
            font-size: 14px;
            border: 1.8px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .password-wrapper input:focus {
            border-color: #28a745;
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
        }

        .toggle-password svg {
            fill: #666;
            width: 100%;
            height: 100%;
        }

        .toggle-password:hover svg {
            fill: #28a745;
        }

        button[type="submit"] {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 0;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background: #218838;
        }

        .error {
            color: #b00020;
            margin-bottom: 15px;
            text-align: center;
        }

        .register-link {
            margin-top: 20px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="index.php?controller=login&action=authenticate" method="post" autocomplete="off" style="display: flex; flex-direction: column;">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required autofocus />

            <label for="password">Contraseña</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" required />
                <button type="button" class="toggle-password" aria-label="Mostrar contraseña">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" >
                        <path d="M12 5c-7 0-11 6.5-11 7s4 7 11 7 11-6.5 11-7-4-7-11-7zm0 12c-3.2 0-5.8-2.6-5.8-5.8S8.8 5.4 12 5.4s5.8 2.6 5.8 5.8-2.6 5.8-5.8 5.8zm0-9.8a4 4 0 1 0 0 7.998A4 4 0 0 0 12 7.2z"/>
                    </svg>
                </button>
            </div>

            <button type="submit">Entrar</button>
        </form>

        <div class="link">
        ¿No tenés cuenta? <a href="index.php?controller=login&action=register">Registrate acá</a>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.setAttribute('aria-label', 'Ocultar contraseña');
            } else {
                passwordInput.type = 'password';
                togglePassword.setAttribute('aria-label', 'Mostrar contraseña');
            }
        });
    </script>
 <script>
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.setAttribute('aria-label', 'Ocultar contraseña');
        } else {
            passwordInput.type = 'password';
            togglePassword.setAttribute('aria-label', 'Mostrar contraseña');
        }
    });

    // Detección básica de SQL Injection
    const form = document.querySelector('form');
    const correoInput = document.getElementById('correo');

    form.addEventListener('submit', function(e) {
        const suspiciousPatterns = [
            /(\bor\b|\band\b)\s+\d+=\d+/i,       // OR 1=1, AND 1=1
            /('|")\s*--/,                         // '-- o "-- para comentar
            /union\s+select/i,                    // UNION SELECT
            /drop\s+table/i,                      // DROP TABLE
            /insert\s+into/i,                     // INSERT INTO
            /delete\s+from/i,                     // DELETE FROM
            /--|;|#/                              // Comentarios y fin de sentencia
        ];

        const correo = correoInput.value;
        const password = passwordInput.value;

        for (const pattern of suspiciousPatterns) {
            if (pattern.test(correo) || pattern.test(password)) {
                e.preventDefault();
                document.body.style.background = "#ffdddd";
                alert("🚫 Intento de inyección SQL detectado. Por favor, ingresá datos válidos.");
                return;
            }
        }
    });
</script>
</body>
</html>
