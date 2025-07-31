<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once __DIR__ . '/../models/Usuario.php';
require '../config/config.php';
/*session_start();*/

class AuthController extends Controller
{
    private $secret = 'SECRETO123';    
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);             
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $payload = [
                    'iss' => 'http://ordemservico',
                    'aud' => 'http://ordemservico',
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'user' => $email
                ];

                $jwt = JWT::encode($payload, $this->secret, 'HS256');
                $_SESSION['token'] = $jwt;
                header('Location: index.php?page=ordem&action=index');
                exit;
            } else {
                $erro = "Email ou senha inválidos.";
                $this->view('auth/login', compact('erro'));
                return;
            }
        }
        
        // GET request → exibir formulário
        $this->view('auth/login');
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: ?page=auth&action=login');
        exit;
    }

    public function verificarToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }             
        if (empty($_SESSION['token'])) {
            return false;
        }

        try {
            $decoded = JWT::decode($_SESSION['token'], new Key($this->secret, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }    
}
