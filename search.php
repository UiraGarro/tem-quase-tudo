<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Busca — Tem Quase Tudo</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <main>
    <?php
    if ($q) {
        echo '<p>Você pesquisou isso: ' . htmlspecialchars($q) . '</p>';
    } else {
        echo '<p>A busca ainda não funciona, vou colocar depois.</p>';
    }
    ?>
  </main>
</body>
</html>
