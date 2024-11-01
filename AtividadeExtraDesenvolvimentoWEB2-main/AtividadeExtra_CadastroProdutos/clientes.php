<?php
session_start(); // Inicia a sessão
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nossos Clientes - TechStore</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> <!-- Importação da fonte Roboto -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            margin-top: 20px;
            text-align: center;
        }
        .row {
            display: flex;
            justify-content: center; /* Centraliza as colunas na linha */
            flex-wrap: wrap; /* Permite que as colunas quebrem em múltiplas linhas */
        }
        .cliente-img {
            width: 150px; /* Ajuste o tamanho conforme necessário */
            margin: 10px;
            border-radius: 8px;
        }
        h1 {
            color: #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nossos Clientes</h1>
        <div class="row">
            <?php
            // Diretório onde estão as imagens dos clientes
            $clientesDir = 'imagem/';
            $clientes = [
                ['imagem' => 'imagem/kabum.jpg', 'link' => 'https://www.kabum.com.br/?awc=17729_1730394890_c5e5c82ae75dcd5852dacae74ad67d17&utm_source=AWIN&utm_medium=AFILIADOS&utm_campaign=fevereiro24&utm_content=gx2-br-awin-kabum-sd-gczc&utm_term=141629'],
                ['imagem' => 'imagem/terabyte.jpg', 'link' => 'https://www.terabyteshop.com.br/?gad_source=1&gclid=Cj0KCQjw1Yy5BhD-ARIsAI0RbXb63I83pu8AxN6jxr7e_KlHTVo01i7N7YIdiiRBs-Tm4JbMW4sJH_AaAurgEALw_wcB'],
                ['imagem' => 'imagem/pichau.jpg', 'link' => 'https://www.pichau.com.br/?gad_source=1&gclid=Cj0KCQjw1Yy5BhD-ARIsAI0RbXaeULD7qIg6AP5nht1uYVrEh6X6VXTgta1ItJWj0ajvNGLZ52UnE6EaAlCfEALw_wcB']
            ];

            foreach ($clientes as $cliente) {
                echo '<div class="col-md-3 text-center">';
                echo '<a href="' . htmlspecialchars($cliente['link']) . '" target="_blank">'; // Link para a imagem
                echo '<img src="' . htmlspecialchars($cliente['imagem']) . '" alt="Cliente" class="cliente-img">';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>&copy; 2024 TechStore. Todos os direitos reservados.</p>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
