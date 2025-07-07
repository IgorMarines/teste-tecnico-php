<?php
session_start();
$token = bin2hex(random_bytes(16));
$_SESSION['access_token'] = $token;
$_SESSION['token_expiry'] = time() + 30; // expira em 30 segundos

header('Content-Type: application/json');
echo json_encode(['token' => $token]);