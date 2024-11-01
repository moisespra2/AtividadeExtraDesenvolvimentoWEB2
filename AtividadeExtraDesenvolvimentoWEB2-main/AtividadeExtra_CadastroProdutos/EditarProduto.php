<?php
session_start();
require_once 'Conexao.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['nivel_acesso'] !== 'Administrador') {
    header("Location: AdminDashboard.php");
    exit;
}

// Obtém o ID do produto
$id = $_GET['id'];
$produto = $conn->prepare("SELECT * FROM tb_produtos WHERE id = ?");
$produto->execute([$id]);
$produto = $produto->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $imagemNova = $_FILES['imagem'] ?? null;

    // Armazena o nome da imagem nova
    $nomeImagemNova = null;

    // Remove a imagem antiga, se existir
    if (!empty($produto['imagem']) && file_exists("uploads/" . $produto['imagem'])) {
        unlink("uploads/" . $produto['imagem']);
    }

    // Verifica se o campo de imagem foi enviado e se não há erros
    if ($imagemNova && $imagemNova['error'] === UPLOAD_ERR_OK) {
        // Verifica o tipo de arquivo
        $extensao = strtolower(pathinfo($imagemNova['name'], PATHINFO_EXTENSION));
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extensao, $tiposPermitidos)) {
            echo "Formato de arquivo não permitido. Utilize JPG, JPEG, PNG ou GIF.";
            exit;
        }

        $nomeImagemNova = uniqid() . "-" . $imagemNova['name'];
        // Mova o arquivo para a pasta uploads
        if (!move_uploaded_file($imagemNova['tmp_name'], "uploads/$nomeImagemNova")) {
            echo "Erro ao mover o arquivo para o diretório de upload.";
            exit;
        }
    }

    try {
        // Atualiza o banco de dados
        if ($nomeImagemNova) {
            $stmt = $conn->prepare("UPDATE tb_produtos SET nome = ?, descricao = ?, preco = ?, quantidade = ?, imagem = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $quantidade, $nomeImagemNova, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE tb_produtos SET nome = ?, descricao = ?, preco = ?, quantidade = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $preco, $quantidade, $id]);
        }
        header("Location: ListaProdutos.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao atualizar produto: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Produto: <?= htmlspecialchars($produto['nome']) ?></h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" class="form-control" name="preco" step="0.01" value="<?= htmlspecialchars($produto['preco']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" name="quantidade" value="<?= htmlspecialchars($produto['quantidade']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem do Produto (deixe em branco se não quiser alterar)</label>
            <input type="file" class="form-control" name="imagem" accept=".jpg,.jpeg,.png,.gif">
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
    <a href="ListaProdutos.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
