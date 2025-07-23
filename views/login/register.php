<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Crear Cuenta</title>
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
        .register-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 350px;
            display: flex;
            flex-direction: column;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: 600;
            text-align: left;
        }
        .input-wrapper {
            position: relative;
            width: 100%;
            margin-top: 5px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 40px 10px 12px; /* espacio para el icono */
            border: 1.8px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus {
            border-color: #28a745;
            outline: none;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: #666;
        }
        .toggle-password:hover {
            fill: #28a745;
        }
        button {
            width: 100%;
            background: #0077cc;
            color: white;
            border: none;
            padding: 12px 0;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background: #005fa3;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #0077cc;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #b00020;
            margin-top: 10px;
            font-weight: 600;
            text-align: center;
            display: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Crear Cuenta</h1>
        <form id="registerForm" action="index.php?controller=usuario&action=store" method="post" onsubmit="return validarContrasenas()">
            <label for="nombre">Nombre completo</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" id="correo" required>

            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" required>

            <label for="password">Contraseña</label>
            <div class="input-wrapper">
                <input type="password" name="password" id="password" required>
                <svg class="toggle-password" onclick="togglePassword('password', this)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 
                        5 2.239 5 5-2.239 5-5 5zm0-8c-1.657 0-3 1.343-3 3 
                        s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"/>
                </svg>
            </div>

            <label for="passwordConfirm">Repetir Contraseña</label>
            <div class="input-wrapper">
                <input type="password" name="passwordConfirm" id="passwordConfirm" required>
                <svg class="toggle-password" onclick="togglePassword('passwordConfirm', this)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 
                        5 2.239 5 5-2.239 5-5 5zm0-8c-1.657 0-3 1.343-3 3 
                        s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"/>
                </svg>
            </div>

            <div id="error" class="error-message">Las contraseñas no coinciden.</div>

            <button type="submit">Registrar</button>
        </form>

        <div class="link">
            ¿Ya tenés cuenta? <a href="index.php?controller=login&action=index">Iniciar sesión</a>
        </div>
    </div>

    <script>
        function validarContrasenas() {
            const pass1 = document.getElementById('password').value;
            const pass2 = document.getElementById('passwordConfirm').value;
            const errorDiv = document.getElementById('error');

            if (pass1 !== pass2) {
                errorDiv.style.display = 'block';
                return false;
            } else {
                errorDiv.style.display = 'none';
                return true;
            }
        }

        function togglePassword(fieldId, svg) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                svg.style.fill = '#28a745';
            } else {
                input.type = "password";
                svg.style.fill = '#666';
            }
        }
    </script>
</body>
</html>
