<?php
session_start();
require '../conexão.php'; // Conexão com o banco

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senhaDigitada = $_POST['senha'] ?? '';

    if (empty($email) || empty($senhaDigitada)) {
        echo "<script>alert('Preencha email e senha!'); history.back();</script>";
        exit;
    }

    // Busca o usuário no banco
    $sql = "SELECT * FROM instituicao WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verifica a senha usando password_verify
        if (password_verify($senhaDigitada, $usuario['senha'])) {
            $_SESSION['instituicao'] = $usuario['instituicao'];
            $_SESSION['email'] = $usuario['email'];

            header("Location: ../update-delete/update.php"); // Redireciona para painel
            exit;
        } else {
            echo "<script>alert('Senha incorreta!'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Email não encontrado!'); history.back();</script>";
    }
}
?>