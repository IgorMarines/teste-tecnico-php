<?php
header('Content-Type: application/json');

$frete = [
    'padrao' => 19.90,
    'expresso' => 39.90
];

echo json_encode($frete);