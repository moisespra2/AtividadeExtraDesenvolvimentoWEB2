<?php
$host = "localhost";
$dbname = "shopsystem"; // Nome do banco de dados atualizado
$username = "root";
$password = "fatec";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>