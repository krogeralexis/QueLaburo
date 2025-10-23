<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/database.php';

class FacebookAuthController
{
    private $usuarioModel;
    private $fb;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
        $this->fb = new \Facebook\Facebook([
            'app_id' => 'TU_APP_ID',
            'app_secret' => 'TU_APP_SECRET',
            'default_graph_version' => 'v19.0',
        ]);
    }

    public function login()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $callbackUrl = 'http://localhost/QueLaburo/index.php?controller=facebookAuth&action=callback';
        $loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);
        header('Location: ' . $loginUrl);
        exit;
    }

    public function callback()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }

        if (!isset($accessToken)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }

        $response = $this->fb->get('/me?fields=id,name,email,picture', $accessToken);
        $info = $response->getGraphUser();

        $correo = $info['email'];
        $nombre = $info['name'];
        $foto   = $info['picture']['url'];
        $id_oauth = $info['id'];

        $user = $this->usuarioModel->buscarPorCorreo($correo);
        if (!$user) {
            $this->usuarioModel->createOAuthUser($nombre, $correo, $foto, 'facebook', $id_oauth);
            $user = $this->usuarioModel->buscarPorCorreo($correo);
        }

        $_SESSION['usuario'] = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'correo' => $user['correo'],
            'foto' => $user['foto_perfil'],
            'es_cliente' => $user['es_cliente'] ?? false,
            'es_proveedor' => $user['es_proveedor'] ?? false
        ];

        header('Location: index.php?controller=usuario&action=index');
        exit;
    }
}
