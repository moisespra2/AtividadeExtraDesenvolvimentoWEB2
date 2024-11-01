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

// Se um usuário específico foi selecionado para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tb_usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe
    if (!$usuario) {
        header("Location: ListaUsuarios.php");
        exit;
    }

    // Atualiza o usuário
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nivel_acesso = $_POST['nivel_acesso'];
        
        // Atualiza o nível de acesso do usuário no banco de dados
        $stmt = $conn->prepare("UPDATE tb_usuarios SET nivelacesso = ? WHERE id = ?");
        $stmt->execute([$nivel_acesso, $id]);
        
        // Redireciona de volta para a lista de usuários
        header("Location: ListaUsuarios.php");
        exit;
    }
} else {
    // Redireciona de volta se nenhum ID for passado
    header("Location: ListaUsuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Usuário: <?= htmlspecialchars($usuario['nome']) ?></h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="nivel_acesso" class="form-label">Nível de Acesso</label>
            <select name="nivel_acesso" id="nivel_acesso" class="form-select" required>
                <option value="Administrador" <?= $usuario['nivelacesso'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                <option value="Comum" <?= $usuario['nivelacesso'] === 'Comum' ? 'selected' : '' ?>>Comum</option>
                <option value="Visitante" <?= $usuario['nivelacesso'] === 'Visitante' ? 'selected' : '' ?>>Visitante</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
    <a href="ListaUsuarios.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
