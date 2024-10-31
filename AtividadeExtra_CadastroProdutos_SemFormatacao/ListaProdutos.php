<?php
include 'Conexao.php'; // Corrigido para usar 'Conexao.php'
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit;
}

// Verifica se o nível de acesso do usuário é 'Comum' ou 'Administrador'
$nivelAcesso = $_SESSION['nivel_acesso'];
if ($nivelAcesso !== 'Comum' && $nivelAcesso !== 'Administrador') {
    header("Location: index.php"); // Redireciona para a página inicial se o acesso não for permitido
    exit;
}

$produtos = $conn->query("SELECT * FROM tb_produtos")->fetchAll(PDO::FETCH_ASSOC); // Alterado para a tabela de produtos
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Lista de Produtos</h1>
    <a href="CadastrarProduto.php" class="btn btn-success mb-3">Cadastrar Produto</a> <!-- Alterado para o arquivo correto -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th> <!-- Adicionado para mostrar a descrição -->
                <th>Preço</th> <!-- Adicionado para mostrar o preço -->
                <th>Quantidade</th> <!-- Adicionado para mostrar a quantidade -->
                <th>Imagem</th> <!-- Adicionado para mostrar a imagem -->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= htmlspecialchars($produto['descricao']) ?></td> <!-- Exibindo a descrição do produto -->
                <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td> <!-- Exibindo o preço formatado -->
                <td><?= htmlspecialchars($produto['quantidade']) ?></td> <!-- Exibindo a quantidade -->
                <td>
                    <?php if (!empty($produto['imagem'])): ?>
                        <img src="uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" width="100"> <!-- Exibindo a imagem do produto -->
                    <?php else: ?>
                        Não disponível
                    <?php endif; ?>
                </td>
                <td>
                    <a href="EditarProduto.php?id=<?= $produto['id'] ?>" class="btn btn-warning">Editar</a> <!-- Alterado para o arquivo correto -->
                    <a href="ExcluirProduto.php?id=<?= $produto['id'] ?>" class="btn btn-danger" onclick="return confirm('A exclusão será permanente! Tem certeza disso?')">Excluir</a> <!-- Alterado para o arquivo correto -->
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
