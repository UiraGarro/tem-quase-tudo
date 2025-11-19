<?php
ob_start();
require_once __DIR__ . '/../config.inc.php';
ob_end_clean();

$errors = [];
$nome = '';
$email = '';
$telefone = '';
$endereco = '';
$cidade = '';
$senha = '';
 $senha_confirm = '';

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

	if ($senha === '') {
		$errors[] = 'O campo Senha é obrigatório.';
	} elseif (strlen($senha) < 6) {
		$errors[] = 'A senha deve ter ao menos 6 caracteres.';
	}
	if ($senha !== $senha_confirm) {
		$errors[] = 'A confirmação de senha não confere.';
	}

	if (empty($errors)) {
		if (!isset($conexao) || !$conexao) {
			$errors[] = 'Conexão com o banco não disponível.';
		} else {
			$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

			$sql = "INSERT INTO clientes (nome, email, senha, telefone, endereco, cidade) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = mysqli_prepare($conexao, $sql);
			if ($stmt) {
				mysqli_stmt_bind_param($stmt, 'ssssss', $nome, $email, $senha_hash, $telefone, $endereco, $cidade);
				$exec = mysqli_stmt_execute($stmt);
				if ($exec) {
					mysqli_stmt_close($stmt);
					header('Location: index.php?msg=sucesso');
					exit;
				} else {
					$errors[] = 'Falha ao inserir no banco: ' . mysqli_stmt_error($stmt);
					mysqli_stmt_close($stmt);
				}
			} else {
				$errors[] = 'Erro ao preparar a query: ' . mysqli_error($conexao);
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<title>Cadastrar Cliente</title>
</head>
<body>

<h1>Cadastrar Cliente</h1>

<?php if (!empty($errors)): ?>
	<div>
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

	<label for="senha">Senha *</label>
	<input type="password" name="senha" id="senha" value="">

	<label for="senha_confirm">Confirme a senha *</label>
	<input type="password" name="senha_confirm" id="senha_confirm" value="">

	<div style="margin-top:12px">
		<button type="submit">Cadastrar</button>
		<a href="index.php" style="margin-left:10px">Voltar</a>
	</div>
</form>
</body>
</html>

