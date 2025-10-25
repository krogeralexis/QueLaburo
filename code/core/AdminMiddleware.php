<?php
namespace Core;

class AdminMiddleware 
{
    public static function handle() 
    {
        session_start();
        if (!isset($_SESSION['admin_id'])) 
        {
            // Redirige al login de admin si no está logeado
            header('Location: /admin');
            exit;
        }
    }
}
