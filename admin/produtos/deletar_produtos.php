<?php
    require_once("../config.inc.php");

    $query = "DELETE FROM produtos WHERE id = " . $_GET['id'];
    if (mysqli_query($conexao, $query)) {
        echo "Produto deletado com sucesso!";
    } else {
        echo "Erro ao deletar produto: " . mysqli_error($conexao);
    }
?>
<br><a href="index.php">Voltar</a>