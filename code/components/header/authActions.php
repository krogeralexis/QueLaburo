<?php
// Detectamos si es un móvil por el user agent (simplificado)
$isMobile = preg_match('/(android|iphone|ipad|ipod|mobile)/i', $_SERVER['HTTP_USER_AGENT']);

?>

<div class="auth-actions">
    <?php if (!$isMobile): ?>
        <a href="#" class="btn" id="btnLogin">Iniciar sesión</a>
    <?php endif; ?>
    <a href="#" class="btn btn-primary" id="btnRegister">Únete</a>
</div>
