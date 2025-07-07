<?php
header('Content-Type: application/json');

$pdo = new PDO('mysql:host=localhost;dbname=sistema', 'root', '12345678');
$page = (int) ($_GET['page'] ?? 1);
$limit = (int) ($_GET['limit'] ?? 50);
$filtro = $_GET['filtro'] ?? '';
$ordem = $_GET['ordem'] === 'desc' ? 'DESC' : 'ASC';

$offset = ($page - 1) * $limit;

$sql = "SELECT id, nome, preco FROM produtos";
$params = [];

if ($filtro) {
    $sql .= " WHERE nome LIKE :filtro";
    $params[':filtro'] = "%$filtro%";
}

$sql .= " ORDER BY nome $ordem LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produtos);