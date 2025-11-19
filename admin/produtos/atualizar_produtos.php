<?php
require_once("../config.inc.php");

if (isset($_POST['salvar'])) {

    $id         = intval($_GET['id']);
    $produto = $_POST['produto'];
    $descricao   = $_POST['descricao'];
    $preco       = $_POST['preco'];
    $estoque     = $_POST['estoque'];
    $desconto    = $_POST['desconto'];

    $update = "UPDATE produtos 
               SET produto='$produto', descricao='$descricao', preco='$preco',
                   estoque='$estoque', desconto='$desconto'
               WHERE id = $id";

    if (mysqli_query($conexao, $update)) {
        echo "Produto atualizado com sucesso!";
        echo '<br><a href="index.php">Voltar</a>';
        exit;
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erro: nenhum ID foi passado na URL.");
}

$id = intval($_GET['id']);

$query = "SELECT * FROM produtos WHERE id = $id";
$resultado = mysqli_query($conexao, $query);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Erro: produto não encontrado.");
}

$produto = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
</head>
<body>
<h1>Editar Produto</h1>

<form method="post">
    Produto: <br>
    <input type="text" name="produto" value="<?= $produto['produto'] ?>" required><br><br>

    Descrição: <br>
    <textarea name="descricao"><?= $produto['descricao'] ?></textarea><br><br>

    Preço: <br>
    <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required><br><br>

    Estoque: <br>
    <input type="number" name="estoque" value="<?= $produto['estoque'] ?>" required><br><br>

    Desconto (%): <br>
    <input type="number" step="0.01" name="desconto" value="<?= $produto['desconto'] ?>"><br><br>
    
    <button type="submit" name="salvar">Salvar</button>
</form>
<a href="index.php">Voltar</a>
</body>
</html>