<?php
// Ativa exibição de erros (remova em produção)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload do Composer (para JWT etc.)
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

// Core do sistema
require_once __DIR__ . '/../app/core/App.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';

use App\Controllers\AuthController;
use App\Core\App;

// Verifica autenticação com JWT
$auth = new AuthController();

if (!$auth->verificarToken()) {
    require_once __DIR__ . '/../app/views/auth/login.php';
    exit;
}

// Inicia a aplicação normalmente
$app = new App();