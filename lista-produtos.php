<?php

$produtos = [
  ['nome' => 'Mouse Gamer', 'categoria' => 'perifericos', 'preco' => 199],
  ['nome' => 'Teclado Mecânico', 'categoria' => 'perifericos', 'preco' => 299],
  ['nome' => 'Monitor 24"', 'categoria' => 'monitores', 'preco' => 899],
  ['nome' => 'Notebook i5', 'categoria' => 'notebooks', 'preco' => 3499],
];

// Filtros via GET
$categoria = $_GET['categoria'] ?? '';
$precoMax = $_GET['preco_max'] ?? null;

// Filtragem
$resultado = array_filter($produtos, function ($produto) use ($categoria, $precoMax) {
  if ($categoria && $produto['categoria'] !== $categoria) return false;
  if ($precoMax && $produto['preco'] > (float)$precoMax) return false;
  return true;
});

// Função segura para exibir strings
function esc($v) {
  return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Produtos | Minha Loja</title>
  <meta name="description" content="Lista de produtos filtrável em tempo real">
</head>
<body>
  <h1>Produtos</h1>

  <form method="GET">
    <label>
      Categoria:
      <select name="categoria">
        <option value="">Todas</option>
        <option value="perifericos" <?= $categoria === 'perifericos' ? 'selected' : '' ?>>Periféricos</option>
        <option value="monitores" <?= $categoria === 'monitores' ? 'selected' : '' ?>>Monitores</option>
        <option value="notebooks" <?= $categoria === 'notebooks' ? 'selected' : '' ?>>Notebooks</option>
      </select>
    </label>
    <label>
      Preço máximo:
      <input type="number" name="preco_max" value="<?= esc($precoMax) ?>" />
    </label>
    <button type="submit">Filtrar</button>
  </form>

  <ul>
    <?php foreach ($resultado as $p): ?>
      <li>
        <strong><?= esc($p['nome']) ?></strong><br>
        Categoria: <?= esc($p['categoria']) ?> - R$ <?= number_format($p['preco'], 2, ',', '.') ?>
      </li>
    <?php endforeach; ?>
  </ul>

  <?php if (empty($resultado)): ?>
    <p>Nenhum produto encontrado.</p>
  <?php endif; ?>
</body>
</html>
