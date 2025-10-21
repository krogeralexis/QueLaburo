<!-- components/modal-login.php -->
<div id="authModal" class="auth-modal">
    <div class="auth-modal-content">
        <span class="auth-close">&times;</span>

        <!-- Contenedor Login -->
        <div id="loginContainer">
            <p class="title">Welcome back</p>
            <form class="form" id="emailLoginForm" action="/login" method="POST">
                <input type="email" class="input" placeholder="Email" name="email" required>
                <input type="password" class="input" placeholder="Password" name="password" required>
                <p class="page-link">
                    <span class="page-link-label">Forgot Password?</span>
                </p>
                <button class="form-btn" type="submit">Log in</button>
            </form>
            <p class="sign-up-label">
                Don't have an account?<span class="sign-up-link" id="switchToRegister">Sign up</span>
            </p>
            <div class="buttons-container">
                <div class="apple-login-button">
                    <!-- SVG Apple -->
                    <span>Log in with Apple</span>
                </div>
                <div class="google-login-button">
                    <!-- SVG Google o Facebook -->
                    <span>Log in with Google</span>
                </div>
            </div>
        </div>

        <!-- Contenedor Registro -->
        <div id="registerContainer" style="display:none;">
            <p class="title">Create account</p>
            <form class="form" id="registerForm" action="/register" method="POST">
                <input type="text" class="input" placeholder="Name" name="name" required>
                <input type="email" class="input" placeholder="Email" name="email" required>
                <input type="password" class="input" placeholder="Password" name="password" required>
                <button class="form-btn" type="submit">Register</button>
            </form>
            <p class="sign-up-label">
                Already have an account? <span class="sign-up-link" id="switchToLogin">Log in</span>
            </p>
        </div>

    </div>
</div>
