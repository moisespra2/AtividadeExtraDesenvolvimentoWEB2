<?php
include 'Conexao.php'; // Corrigido para usar 'Conexao.php'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $imagem = $_FILES['imagem'];

    // Validação da imagem
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
    $extensaoImagem = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        // Verifica se a extensão é permitida
        if (in_array($extensaoImagem, $extensoesPermitidas)) {
            // Utilize o nome original da imagem
            $nomeImagem = $imagem['name'];

            // Se desejar, você pode adicionar um timestamp para evitar conflitos:
            // $nomeImagem = time() . '-' . $imagem['name'];
            
            move_uploaded_file($imagem['tmp_name'], "upload/$nomeImagem"); // Armazena na pasta 'upload'

            // Atualizando a inserção para a tabela tb_produtos
            $stmt = $conn->prepare("INSERT INTO tb_produtos (nome, descricao, preco, quantidade, imagem) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $descricao, $preco, $quantidade, $nomeImagem]);

            header("Location: ListaProdutos.php"); // Redirecionando para a lista de produtos
            exit;
        } else {
            $errorMessage = "Apenas arquivos de imagem (.jpg, .jpeg, .png, .gif) são permitidos.";
        }
    } else {
        $errorMessage = "Erro no upload da imagem.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Cadastro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="CadastrarUsuario.php">Cadastrar Usuário</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ExcluirUsuario.php">Excluir Usuário</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AlterarNivelAcesso.php">Alterar Nível de Acesso</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ListaUsuarios.php">Lista de Usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ListaProdutos.php">Lista de Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="mt-4">Cadastrar Produto</h1>
    
    <?php if (isset($errorMessage)): ?> <!-- Exibindo mensagem de erro -->
        <div class="alert alert-danger">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" name="descricao" required></textarea>
        </div>
        <div class="form-group">
            <label for="preco">Preço</label>
            <input type="number" class="form-control" name="preco" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="number" class="form-control" name="quantidade" required>
        </div>
        <div class="form-group">
            <label for="imagem">Imagem do Produto</label>
            <input type="file" class="form-control" name="imagem" accept=".jpg,.jpeg,.png,.gif" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
