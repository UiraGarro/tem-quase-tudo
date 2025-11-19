<?php
$q = isset($_GET['q']) ? trim(strip_tags($_GET['q'])) : '';

$results = [];
$productsFile = __DIR__ . '/../../includes/products.php';
if (file_exists($productsFile)) {
    include $productsFile;
    if ($q !== '' && !empty($products) && is_array($products)) {
        foreach ($products as $p) {
            $hay = ($p['name'] ?? '') . ' ' . ($p['description'] ?? '') . ' ' . ($p['category'] ?? '');
            if (mb_stripos($hay, $q) !== false) {
                $results[] = $p;
            }
        }
    }
}

?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin — Produtos (busca)</title>
  <style>
    body{font-family:Segoe UI,Arial,Helvetica,sans-serif;margin:18px;color:#222}
    .search{margin-bottom:12px}
    .card{background:#fff;padding:10px;border-radius:6px;margin:8px 0;box-shadow:0 0 0 1px rgba(0,0,0,0.03)}
    .row{display:flex;gap:12px;align-items:flex-start}
    .thumb{width:72px;height:72px;background:#f2f2f2;border:1px solid #e1e1e1;object-fit:cover}
    .meta{font-size:0.9rem;color:#555}
  </style>
</head>
<body>
  <h2>Admin — Busca de Produtos (mínima)</h2>
  <p class="meta">Página pequena para facilitar revisão do professor — foco: busca/visualização.</p>

  <form method="get" class="search">
    <input name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Pesquisar (ex: camiseta)" style="padding:8px;width:300px">
    <button type="submit">Buscar</button>
    <a href="../../index.php" style="margin-left:10px">Voltar ao site</a>
  </form>

  <div class="card">
    <?php if ($q === ''): ?>
      <p>Digite um termo e pressione Buscar.</p>
    <?php else: ?>
      <p class="meta">Foram encontrados <strong><?php echo count($results); ?></strong> produto(s) para "<?php echo htmlspecialchars($q); ?>".</p>

      <?php if (count($results) === 0): ?>
        <p>Nenhum produto encontrado.</p>
      <?php else: ?>
        <?php foreach ($results as $r): ?>
          <div class="card">
            <div class="row">
              <?php if (!empty($r['image']) && file_exists(__DIR__ . '/../../' . ltrim($r['image'], '/'))): ?>
                <img src="<?php echo htmlspecialchars('../../' . ltrim($r['image'], '/')); ?>" alt="<?php echo htmlspecialchars($r['name']); ?>" class="thumb">
              <?php else: ?>
                <div class="thumb" style="display:flex;align-items:center;justify-content:center;color:#888;font-size:0.85rem">sem foto</div>
              <?php endif; ?>

              <div>
                <strong><?php echo htmlspecialchars($r['name'] ?? ''); ?></strong><br>
                <div class="meta">Preço: R$ <?php echo number_format($r['price'] ?? 0, 2, ',', '.'); ?> — Categoria: <?php echo htmlspecialchars($r['category'] ?? '-'); ?></div>
                <div style="margin-top:6px"><?php echo htmlspecialchars($r['description'] ?? ''); ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    <?php endif; ?>
  </div>
  <footer style="margin-top:14px;color:#666;font-size:0.9rem">Atualizado em: <?php echo date('d/m/Y'); ?></footer>
</body>
</html>
