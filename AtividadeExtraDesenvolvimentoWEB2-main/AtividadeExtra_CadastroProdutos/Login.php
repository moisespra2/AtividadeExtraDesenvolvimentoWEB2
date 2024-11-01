<?php
session_start();
require 'Conexao.php'; // Arquivo onde está a conexão PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificando se o email existe no banco de dados
    $stmt = $conn->prepare("SELECT id, nome, senha, nivelacesso FROM tb_usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido, armazenando informações na sessão
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['nome_usuario'] = $usuario['nome'];
        $_SESSION['nivel_acesso'] = $usuario['nivelacesso']; 
        
        // Redirecionar com base no nível de acesso
        switch ($usuario['nivelacesso']) {
            case 'Administrador':
                header('Location: AdminDashboard.php');
                break;
            case 'Comum':
                header('Location: ListaProdutos.php');
                break;

            case 'Visitante': // Novo caso para visitantes
                header('Location: ListaProdutosVisitante.php');
                break;

            default:
                header('Location: CadastrarProduto.php');
                break;
        }
        exit;
    } else {
        // Falha no login, redireciona de volta para o login
        $_SESSION['erro_login'] = 'Email ou senha inválidos.';
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center">Login</h2>
            <?php if (isset($_SESSION['erro_login'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['erro_login']) ?></div>
                <?php unset($_SESSION['erro_login']); ?>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="mt-3">
                <p>Ainda não tem uma conta? <a href="CadastrarUsuario.php">Cadastre-se aqui</a></p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
