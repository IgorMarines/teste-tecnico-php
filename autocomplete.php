<?php
header('Content-Type: application/json');

$pdo = new PDO('mysql:host=localhost;dbname=sistema', 'root', '12345678');
$termo = $_GET['q'] ?? '';

$stmt = $pdo->prepare("SELECT id, nome FROM produtos WHERE nome LIKE :termo LIMIT 10");
$stmt->execute([':termo' => "%$termo%"]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
