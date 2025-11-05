<?php
$host = 'localhost';
$dbname = 'cs_tecnologia';
$username = 'root';
$password = '';

try {
    // Cria a conexão com o banco (MySQL)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Ativa o modo de erro (lança exceções quando algo dá errado)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define o modo de retorno padrão como array associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se der erro, mostra a mensagem e encerra o script
    die("Erro na conexão: " . $e->getMessage());
}
?>
