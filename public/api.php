<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require '../app/core/Model.php';
require '../config/config.php';

// Configurações iniciais
$c = require '../config/config.php';
$secret = $c['jwt_secret'];
$exp = $c['jwt_exp'];
$path = $_GET['resource'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// Headers para CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Função de autenticação JWT
function auth() {
    global $secret;
    $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$hdr || !preg_match('/Bearer\s(\S+)/', $hdr, $m)) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Não autorizado']);
        exit;
    }
    try {
        JWT::decode($m[1], new Key($secret, 'HS256'));
    } catch(Exception $e) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token inválido']);
        exit;
    }
}

// Rotas
switch ($path) {
    case 'login':
        if ($method === 'POST') {
            handleLogin();
        }
        break;
        
    case 'clientes':
        require '../app/models/Cliente.php';
        $model = new \App\Models\Cliente();
        handleCrud($model, ['nome', 'email', 'documento', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf', 'cep']);
        break;
        
    case 'produtos':
        require '../app/models/Produto.php';
        $model = new \App\Models\Produto();
        handleCrud($model, ['descricao', 'preco', 'dtgarantia', 'ativo']);
        break;
        
    case 'ordens':
        require '../app/models/Ordem.php';
        $model = new \App\Models\Ordem();
        handleCrud($model, ['cliente_id', 'produto_id', 'descricao', 'dtabertura'], 'id_ordem');
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Endpoint não encontrado']);
        break;
}

// Funções auxiliares
function handleLogin() {
    global $secret, $exp;
    
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['email']) || !isset($data['senha'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email e senha obrigatórios']);
        exit;
    }

    try {
        $pdo = new PDO(
            "mysql:host={$c['db_host']};dbname={$c['db_name']};charset=utf8",
            $c['db_user'], $c['db_pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['senha'], $user['senha'])) {
            $payload = [
                "iat" => time(),
                "exp" => time() + $exp,
                "data" => ["id" => $user['id'], "email" => $user['email']]
            ];
            $token = JWT::encode($payload, $secret, 'HS256');
            
            echo json_encode([
                'success' => true,
                'token' => $token,
                'expires_in' => $exp,
                'token_type' => 'Bearer'
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Login inválido']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
    }
}

function handleCrud($model, $requiredFields = [], $idField = 'id') {
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Verificar autenticação para todas as rotas exceto OPTIONS
    if ($method !== 'OPTIONS') {
        auth();
    }

    switch ($method) {
        case 'GET':
            if (isset($_GET[$idField])) {
                // GET por ID
                $result = $model->find($_GET[$idField]);
            } else {
                // GET all
                $result = $model->all();
            }
            echo json_encode($result);
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (validateData($data, $requiredFields)) {
                $result = $model->create($data);
                http_response_code(201);
                echo json_encode($result);
            }
            break;
            
        case 'PUT':
            parse_str($_SERVER['QUERY_STRING'], $query);
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($query[$idField]) && validateData($data, $requiredFields)) {
                $result = $model->update($query[$idField], $data);
                echo json_encode($result);
            }
            break;
            
        case 'DELETE':
            parse_str($_SERVER['QUERY_STRING'], $query);
            if (isset($query[$idField])) {
                $result = $model->delete($query[$idField]);
                http_response_code(204);
            }
            break;
            
        case 'OPTIONS':
            http_response_code(200);
            break;
            
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            break;
    }
}

function validateData($data, $requiredFields) {
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Campo $field é obrigatório"]);
            return false;
        }
    }
    return true;
}