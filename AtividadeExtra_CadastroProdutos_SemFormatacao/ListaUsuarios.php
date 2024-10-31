<?php
session_start();
require_once 'Conexao.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['nivel_acesso'] !== 'Administrador') {
    header("Location: AdminDashboard.php");
    exit;
}

// Consulta todos os usuários
$sql = "SELECT * FROM tb_usuarios"; // Use o nome correto da tabela
$stmt = $conn->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Lista de Usuários</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Nível de Acesso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['id']) ?></td>
                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= htmlspecialchars($usuario['nivelacesso']) ?></td> <!-- Corrigido para 'nivelacesso' -->
                <td>
                    <a href="EditarUsuario.php?id=<?= htmlspecialchars($usuario['id']) ?>" class="btn btn-warning">Editar</a>
                    <a href="ExcluirUsuario.php?id=<?= htmlspecialchars($usuario['id']) ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="AdminDashboard.php" class="btn btn-secondary">Voltar ao Painel de Administração</a> <!-- Botão para voltar ao painel -->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
