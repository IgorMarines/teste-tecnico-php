<?php
session_start();
header('Content-Type: application/json');

// Simulação de carrinho
$_SESSION['carrinho'] = $_SESSION['carrinho'] ?? [
    ['id' => 1, 'nome' => 'Notebook', 'preco' => 3499.99, 'quantidade' => 1],
    ['id' => 2, 'nome' => 'Mouse Gamer', 'preco' => 199.90, 'quantidade' => 2],
];

echo json_encode($_SESSION['carrinho']);
