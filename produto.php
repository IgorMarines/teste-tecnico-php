<?php

$produtos = [
    123 => [
        'nome' => 'Mouse Gamer RGB',
        'preco' => 199.90,
        'descricao' => 'Mouse com 7 botões programáveis e iluminação RGB.',
        'imagens' => [
            'mouse1.jpg',
            'mouse2.jpg',
        ]
    ],
];

$id = $_GET['id'] ?? null;
$produto = $produtos[$id] ?? null;

if (!$produto) {
    http_response_code(404);
    echo "<h1>Produto não encontrado</h1>";
    exit;
}

function esc($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title><?= esc($produto['nome']) ?> | Minha Loja</title>

  <!--  Metatags para SEO -->
  <meta name="description" content="<?= esc($produto['descricao']) ?>">
  <meta property="og:title" content="<?= esc($produto['nome']) ?>">
  <meta property="og:description" content="<?= esc($produto['descricao']) ?>">
  <meta property="og:type" content="product">
  <meta property="og:image" content="/images/<?= esc($produto['imagens'][0]) ?>">

  <!--  Performance: preload imagem principal -->
  <link rel="preload" as="image" href="/images/<?= esc($produto['imagens'][0]) ?>">

  <style>
    body { font-family: sans-serif; margin: 2rem; }
    .produto-img { max-width: 100%; height: auto; border-radius: 8px; }
    .preco { font-size: 1.5rem; color: green; margin-top: 0.5rem; }
  </style>
</head>
<body>
  <main>
    <h1><?= esc($produto['nome']) ?></h1>
    <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>

    <!-- Acessibilidade com alt e semântica -->
    <section aria-label="Galeria de imagens do produto">
      <?php foreach ($produto['imagens'] as $img): ?>
        <img src="/images/<?= esc($img) ?>" alt="Imagem de <?= esc($produto['nome']) ?>" class="produto-img" />
      <?php endforeach; ?>
    </section>

    <section>
      <h2>Descrição</h2>
      <p><?= esc($produto['descricao']) ?></p>
    </section>
  </main>
</body>
</html>
