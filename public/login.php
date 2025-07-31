<?php
// Inicia a sessão (se não já iniciada no App.php, pode remover aqui)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/core/Controller.php';
/*require_once __DIR__ . '/../app/models/Usuario.php';*/
require_once __DIR__ . '/../app/controllers/AuthController.php';

use App\Controllers\AuthController;
$auth = new AuthController();
$auth->login(); // Método faz a validação, define token e redireciona
