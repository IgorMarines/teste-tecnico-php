<?php
session_start();
header('Content-Type: application/json');

$token = $_GET['token'] ?? '';

if (!isset($_SESSION['access_token']) || $token !== $_SESSION['access_token']) {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado.']);
    exit;
}

if (time() > $_SESSION['token_expiry']) {
    http_response_code(403);
    echo json_encode(['erro' => 'Token expirado.']);
    exit;
}

// Aqui retorna os dados reais
echo json_encode(['data' => 'Conteúdo seguro']);
