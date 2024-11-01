<?php
session_start(); // Certifique-se de iniciar a sessão
include 'Conexao.php'; // Corrigido para usar 'Conexao.php'
$id = $_GET['id'];

// Prepara e executa a consulta para buscar a imagem do produto
$produto = $conn->prepare("SELECT imagem FROM tb_produtos WHERE id = ?");
$produto->execute([$id]);
$produto = $produto->fetch(PDO::FETCH_ASSOC);

// Verifica se o produto foi encontrado
if ($produto) {
    // Exclui a imagem do produto do servidor
    $caminhoImagem = "uploads/" . $produto['imagem']; // Verifique se o diretório está correto
    if (file_exists($caminhoImagem)) {
        if (unlink($caminhoImagem)) {
            // Mensagem de sucesso ao excluir a imagem
            $_SESSION['mensagem'] = 'Imagem excluída com sucesso!';
        } else {
            // Mensagem de erro se falhar ao excluir a imagem
            $_SESSION['erro'] = 'Erro ao excluir a imagem do produto.';
        }
    } else {
        // Mensagem se a imagem não existir
        $_SESSION['erro'] = 'Imagem não encontrada.';
    }
    
    // Exclui o produto do banco de dados
    $stmt = $conn->prepare("DELETE FROM tb_produtos WHERE id = ?");
    $stmt->execute([$id]);

    // Mensagem de sucesso ao excluir o produto
    $_SESSION['mensagem'] = 'O produto foi excluído com sucesso!';
} else {
    $_SESSION['erro'] = 'Produto não encontrado.';
}

// Redireciona para a lista de produtos
header("Location: ListaProdutos.php");
exit;
?>
