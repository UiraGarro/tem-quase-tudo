<?php
    require_once("../config.inc.php");

    if (isset($_POST['cadastrar'])) {
        $produto = $_POST['produto'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];
        $desconto = $_POST['desconto'];

        $query = "INSERT INTO produtos (produto, descricao, preco, estoque, desconto) 
                VALUES ('$produto', '$descricao', '$preco', '$estoque', '$desconto')";
        if (mysqli_query($conexao, $query)) {
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar produto: " . mysqli_error($conexao);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Produto</title>
</head>
<body>
<h1>Adicionar Produto</h1>
<form method="post">
    Produto: <br>
    <input type="text" name="produto" required><br><br>
    Descrição: <br>
    <textarea name="descricao"></textarea><br><br>
    Preço: <br>
    <input type="number" step="0.01" name="preco" required><br><br>
    Estoque: <br>
    <input type="number" name="estoque" required><br><br>
    Desconto (%): <br>
    <input type="number" step="0.01" name="desconto" value="0"><br><br>

    <button type="submit" name="cadastrar">Salvar</button>
</form>
<a href="index.php">Voltar</a>
</body>
</html>