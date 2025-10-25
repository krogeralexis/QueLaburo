<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/database.php';

class GoogleAuthController
{
    private $usuarioModel;
    private $client;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();

        $this->client = new Google_Client();
        $this->client->setClientId('TU_CLIENT_ID');
        $this->client->setClientSecret('TU_CLIENT_SECRET');
        $this->client->setRedirectUri('http://localhost/QueLaburo/index.php?controller=googleAuth&action=callback');
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    public function login()
    {
        $authUrl = $this->client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }

    public function callback()
    {
        if (isset($_GET['code'])) {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->client->setAccessToken($token);

            $oauth2 = new Google_Service_Oauth2($this->client);
            $info = $oauth2->userinfo->get();

            $correo = $info->email;
            $nombre = $info->name;
            $foto   = $info->picture;
            $id_oauth = $info->id;

            // Verificar si ya existe el usuario
            $user = $this->usuarioModel->buscarPorCorreo($correo);
            if (!$user) {
                // Registrar nuevo usuario sin contraseña
                $this->usuarioModel->createOAuthUser($nombre, $correo, $foto, 'google', $id_oauth);
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
}
