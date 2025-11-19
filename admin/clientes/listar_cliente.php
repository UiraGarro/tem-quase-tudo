<?php
require_once __DIR__ . '/../config.inc.php';

$query = "SELECT id, nome, email, telefone, endereco, cidade FROM clientes";
$resultado = mysqli_query($conexao, $query);

$clientes = [];
if ($resultado) {
    $clientes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
} else {
    $error_msg = 'Erro ao buscar clientes: ' . mysqli_error($conexao);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Lista de Clientes</title>
</head>
<body>

<h1>Clientes</h1>

<a href="cadastrar_cliente.php">Adicionar Cliente</a>
<br><br>

<?php if (!empty($error_msg)): ?>
    <div style="color:red"><strong><?= htmlspecialchars($error_msg) ?></strong></div>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Telefone</th>
        <th>Endereço</th>
        <th>Cidade</th>
        <th>Ações</th>
    </tr>

    <?php if (empty($clientes)): ?>
        <tr>
            <td colspan="7">Nenhum cliente cadastrado.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id']) ?></td>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['telefone']) ?></td>
                <td><?= htmlspecialchars($c['endereco']) ?></td>
                <td><?= htmlspecialchars($c['cidade']) ?></td>
                <td>
                    <a href="atualizar_cliente.php?id=<?= urlencode($c['id']) ?>">Editar</a> |
                    <a href="deletar_cliente.php?id=<?= urlencode($c['id']) ?>" onclick="return confirm('Confirma exclusão deste cliente?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<br>
<a href="index.php">Voltar</a>

</body>
</html>
