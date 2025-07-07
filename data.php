<?php
header('Content-Type: application/json');

if (!isset($_GET['token']) || empty($_GET['token'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Parâmetro "token" ausente.']);
    exit;
}

echo json_encode([
    'content' => 'Dados carregados com sucesso!'
]);