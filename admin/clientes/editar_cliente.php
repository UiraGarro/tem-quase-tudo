<?php
require_once __DIR__ . '/../config.inc.php';

$errors = [];
$id = $_GET['id'] ?? null;

if (empty($id) || !ctype_digit((string)$id)) {
    header('Location: listar_cliente.php?error=invalid_id');
    exit;
}

$id = (int) $id;

$nome = '';
$email = '';
$telefone = '';
$endereco = '';
$cidade = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $senha_confirm = $_POST['senha_confirm'] ?? '';

    if ($nome === '') {
        $errors[] = 'O campo Nome é obrigatório.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Informe um e-mail válido.';
    }

    if ($senha !== '') {
        if (strlen($senha) < 6) {
            $errors[] = 'A senha deve ter ao menos 6 caracteres.';
        }
        if ($senha !== $senha_confirm) {
            $errors[] = 'A confirmação de senha não confere.';
        }
    }

    if (empty($errors)) {
        if ($senha !== '') {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE clientes SET nome = ?, email = ?, senha = ?, telefone = ?, endereco = ?, cidade = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssssssi', $nome, $email, $senha_hash, $telefone, $endereco, $cidade, $id);
            }
        } else {
            $sql = "UPDATE clientes SET nome = ?, email = ?, telefone = ?, endereco = ?, cidade = ? WHERE id = ?";
            $stmt = mysqli_prepare($conexao, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sssssi', $nome, $email, $telefone, $endereco, $cidade, $id);
            }
        }

        if (!isset($stmt) || !$stmt) {
            $errors[] = 'Erro ao preparar a query: ' . mysqli_error($conexao);
        } else {
            $exec = mysqli_stmt_execute($stmt);
            if ($exec) {
                mysqli_stmt_close($stmt);
                header('Location: listar_cliente.php?msg=updated');
                exit;
            } else {
                $errors[] = 'Falha ao atualizar: ' . mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }

} else {
    $sql = "SELECT id, nome, email, telefone, endereco, cidade FROM clientes WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
        if ($row) {
            $nome = $row['nome'];
            $email = $row['email'];
            $telefone = $row['telefone'];
            $endereco = $row['endereco'];
            $cidade = $row['cidade'];
        } else {
            header('Location: listar_cliente.php?error=not_found');
            exit;
        }
    } else {
        header('Location: listar_cliente.php?error=db_prepare');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Cliente</title>
</head>
<body>

<h1>Editar Cliente</h1>

<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <strong>Erros:</strong>
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="">
    <label for="nome">Nome *</label>
    <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($nome) ?>" required>

    <label for="email">E-mail *</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>

    <label for="telefone">Telefone</label>
    <input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($telefone) ?>">

    <label for="endereco">Endereço</label>
    <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($endereco) ?>">

    <label for="cidade">Cidade</label>
    <input type="text" name="cidade" id="cidade" value="<?= htmlspecialchars($cidade) ?>">

    <p>Deixe os campos de senha em branco para manter a senha atual.</p>
    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha" value="">

    <label for="senha_confirm">Confirme a senha</label>
    <input type="password" name="senha_confirm" id="senha_confirm" value="">

    <div style="margin-top:12px">
        <button type="submit">Salvar</button>
        <a href="listar_cliente.php" style="margin-left:10px">Cancelar</a>
    </div>
</form>

</body>
</html>
