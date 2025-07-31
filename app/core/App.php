<?php
namespace App\Core;

class App {
    public function __construct() {
        $page = $_REQUEST['page'] ?? 'auth';
        $action = $_REQUEST['action'] ?? 'login';
        // Proteção para páginas que exigem login
        $publicPages = ['auth'];      
        if (!in_array($page, $publicPages) && empty($_SESSION['token'])) {
            header('Location: ?page=auth&action=login');
            exit;
        }

        $class = 'App\\Controllers\\' . ucfirst($page) . 'Controller';
        if (class_exists($class)) {
            $ctrl = new $class;
            if (method_exists($ctrl, $action)) {
                $ctrl->{$action}();
            } else {
                die("Ação '$action' não encontrada.");
            }
        } else {
            die("Página '$page' não encontrada.");
        }
    }
}
?>
