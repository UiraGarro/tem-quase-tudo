<?php
    $conexao = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($conexao, "tem_quase_tudo_db");

    if(($conexao) && ($db)){
        echo 'Conexão com banco de dados realizada com sucesso!';
    }else{
        echo "Conexão com banco de dados falhou!";
    }