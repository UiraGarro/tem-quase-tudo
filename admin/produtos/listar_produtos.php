<?php
    require_once("../config.inc.php");

    $query = "SELECT * FROM produtos";
    $resultado = mysqli_query($conexao, $query);

    $produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Produtos</title>
</head>
<body>

<h1>Produtos</h1>

<a href="cadastrar_produto.php"> Adicionar Produto</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Produto</th>
        <th>Preço</th>
        <th>Desconto (%)</th>
        <th>Preço Final</th>
        <th>Estoque</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($produtos as $p): ?>
        <?php 
            $precoFinal = $p['preco'] - ($p['preco'] * ($p['desconto'] / 100));
        ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['produto'] ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td><?= $p['desconto'] ?>%</td>
            <td>R$ <?= number_format($precoFinal, 2, ',', '.') ?></td>
            <td><?= $p['estoque'] ?></td>
            <td>
                <a href="atualizar_produtos.php?id=<?= $p['id'] ?>">Editar</a> | 
                <a href="deletar_produtos.php?id=<?= $p['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="index.php">Voltar</a>

</body>
</html>