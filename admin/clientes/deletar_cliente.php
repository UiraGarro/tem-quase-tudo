<?php
require_once __DIR__ . '/../config.inc.php';

$id = $_GET['id'] ?? null;

if (empty($id) || !ctype_digit((string)$id)) {
    header('Location: listar_cliente.php?error=invalid_id');
    exit;
}

$id = (int) $id;

$sql = "DELETE FROM clientes WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
if (!$stmt) {
    header('Location: listar_cliente.php?error=db_prepare');
    exit;
}

mysqli_stmt_bind_param($stmt, 'i', $id);
$exec = mysqli_stmt_execute($stmt);

if ($exec) {
    mysqli_stmt_close($stmt);
    header('Location: listar_cliente.php?msg=deleted');
    exit;
} else {
    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    header('Location: listar_cliente.php?error=' . urlencode($err));
    exit;
}

?>
