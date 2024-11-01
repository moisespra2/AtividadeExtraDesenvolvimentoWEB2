<?php
session_start(); // Inicia a sessão

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo'); // Ajuste para o seu fuso horário

// Verifica se o usuário está logado
$nivelAcesso = isset($_SESSION['nivelacesso']) ? $_SESSION['nivelacesso'] : 'Visitante';

// Obtém a data e hora atual
$dataHoraAtual = date('d/m/Y H:i:s');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>TechStore</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
    body {
        background-image: url('img/background.jpg'); /* Imagem de fundo local */
        background-size: cover; /* Ajusta a imagem para cobrir a tela */
        background-attachment: fixed; /* Fundo fixo ao rolar a página */
        color: #333;
        font-family: 'Roboto', sans-serif;
    }

    h1, h2 {
        color: #007bff;
    }

    .container {
        background-color: rgba(255, 255, 255, 0.9); /* Fundo branco semi-transparente */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .alert {
        border: 1px solid #dc3545;
        background-color: #f8d7da;
        color: #721c24;
    }

    button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        padding: 10px 0;
        background-color: rgba(255, 255, 255, 0.9);
        border-top: 1px solid #ddd;
    }

    .data-hora {
        font-size: 0.9em;
        color: #555;
        margin-top: 10px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">TechStore</h1>
        <h2>Bem-vindo, <?= htmlspecialchars($nivelAcesso) ?>!</h2>
        
        <?php if ($nivelAcesso === 'Visitante'): ?>
            <p><a href="login.php">Fazer login</a> ou <a href="CadastrarUsuario.php">Criar conta</a></p>
        <?php else: ?>
            <p><a href="ListaProdutos.php">Ver Produtos</a></p>
        <?php endif; ?>

        <!-- Exibição da data e hora -->
        <div class="data-hora">
            <strong>Data e Hora Atual:</strong> <?= htmlspecialchars($dataHoraAtual) ?>
        </div>

        <!-- Formulário de Login -->
        <?php if ($nivelAcesso === 'Visitante'): ?>
            <div class="mt-4">
                <h3>Login</h3>
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
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p><a href="clientes.php">Conheça nossos clientes</a></p>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
