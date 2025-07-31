<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require '../app/core/Model.php';
require '../config/config.php';

$c=require '../config/config.php';
$secret = $c['jwt_secret'];
$exp = $c['jwt_exp'];
$path = $_GET['resource'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

function auth() {;
  global $secret;
  $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
  if (!$hdr || !preg_match('/Bearer\s(\S+)/',$hdr,$m)) {
    http_response_code(401);echo json_encode(['message'=>'Não autorizado']);exit;
  }
  try { JWT::decode($m[1], new Key($secret,'HS256')); }
  catch(Exception $e){ http_response_code(401);echo json_encode(['message'=>'Token inválido']);exit;}
}

if ($path === 'login' && $method === 'POST') {
    // Adicionar headers necessários
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    
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
            [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
        );

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
/*        echo json_encode($user); 
        echo json_encode(password_verify($data['senha'], $user['senha'])); exit;*/
        if ($user && password_verify($data['senha'], $user['senha'])) {
            $payload = [
                "iat" => time(),
                "exp" => time() + $exp,
                "data" => ["id" => $user['id'], "email" => $user['email']]
            ];
            $token = JWT::encode($payload, $secret, 'HS256');
            
            // Resposta estruturada para Swagger
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
    exit;
}
elseif ($path === 'clientes') {
  require '../app/models/Cliente.php'; $model = new \App\Models\Cliente();
  if ($method === 'GET') {
    echo json_encode($model->all());
  } 
  elseif ($method === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    echo json_encode($model->create($d));
  }
  elseif ($method === 'PUT') {
    parse_str($_SERVER['QUERY_STRING'], $q);
    $d = json_decode(file_get_contents('php://input'), true);
    echo json_encode($model->update($q['id'], $d));
  }
  elseif ($method === 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $q);
    echo json_encode($model->delete($q['id']));
  }
  exit;
}
elseif ($path === 'produtos') {
  require '../app/models/Produto.php'; $model = new \App\Models\Produto();
  if ($method === 'GET') {
    echo json_encode($model->all());
  } 
  elseif ($method === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    echo json_encode($model->create($d));
  }
  elseif ($method === 'PUT') {
    parse_str($_SERVER['QUERY_STRING'], $q);
    $d = json_decode(file_get_contents('php://input'), true);
    echo json_encode($model->update($q['id'], $d));
  }
  elseif ($method === 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $q);
    echo json_encode($model->delete($q['id']));
  }
  exit;
}
elseif ($path === 'ordens') {
  require '../app/models/Ordem.php'; $model = new \App\Models\Ordem();
  if ($method === 'GET') {
    echo json_encode($model->all());
  } 
  elseif ($method === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    echo json_encode($model->create($d));
  }
  elseif ($method === 'PUT') {
    parse_str($_SERVER['QUERY_STRING'], $q);
    $d = json_decode(file_get_contents('php://input'), true);
    echo json_encode($model->update($q['id_ordem'], $d));
  }
  elseif ($method === 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $q);
    echo json_encode($model->delete($q['id_ordem']));
  }
  exit;
}