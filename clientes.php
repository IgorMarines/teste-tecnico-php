<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Configurações
$jwtSecret = 'sua-chave-secreta';

function autenticar() {
    global $jwtSecret;

    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['erro' => 'Token ausente']);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    try {
        $decoded = JWT::decode($token, new Key($jwtSecret, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['erro' => 'Token inválido']);
        exit;
    }
}

// Rate Limit
function verificarRateLimit($chave, $limite = 100, $janela = 60) {
    $arquivo = __DIR__ . "/limite_$chave.json";
    $agora = time();
    $dados = ['count' => 1, 'inicio' => $agora];

    if (file_exists($arquivo)) {
        $dados = json_decode(file_get_contents($arquivo), true);
        if ($agora - $dados['inicio'] < $janela) {
            $dados['count']++;
        } else {
            $dados = ['count' => 1, 'inicio' => $agora];
        }
    }

    file_put_contents($arquivo, json_encode($dados));

    if ($dados['count'] > $limite) {
        http_response_code(429);
        echo json_encode(['erro' => 'Muitas requisições, tente novamente mais tarde.']);
        exit;
    }
}

// Começo da execução real
header('Content-Type: application/json');
$usuario = autenticar(); // Autentica
$ip = $_SERVER['REMOTE_ADDR']; //  Identifica o cliente
verificarRateLimit($ip);       //  Aplica rate limit por IP

$usuario = autenticar();
$ip = $_SERVER['REMOTE_ADDR'];
verificarRateLimit($ip);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=sistema', 'root', 'senha');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT id, nome, email FROM clientes WHERE ativo = 1");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro no servidor']);
}