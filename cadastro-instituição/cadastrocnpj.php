<?php

require '../conexão.php';

$instituicao = trim($_POST['instituicao'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cnpj = trim($_POST['cnpj'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$email = trim($_POST['email'] ?? '');
$cep = trim($_POST['cep'] ?? '');
$senha = $_POST['senha'] ?? '';
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$foto = $_FILES['foto'] ?? null;
$maps_link = $_POST['maps_link'] ?? '';

if (
    empty($instituicao) ||
    empty($endereco) ||
    empty($cnpj) ||
    empty($numero) ||
    empty($email) ||
    empty($cep) ||
    empty($senha) ||
    empty($maps_link) ||
    empty($foto['name'])
) {
    echo "<script>alert('Preencha todos os campos antes de continuar!'); history.back();</script>";
    exit;
}


$pasta = "../Assets/uploads/";

$nomeDoArquivo = uniqid() . "-" . $foto['name'];

$caminho = $pasta . $nomeDoArquivo;

move_uploaded_file($foto['tmp_name'], $caminho);


$sql = "INSERT INTO instituicao (instituicao, endereco, cnpj, numero, email, cep, senha, imagem_instituicao, link) VALUES (?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $instituicao, $endereco, $cnpj, $numero, $email, $cep, $senhaHash, $caminho, $maps_link);
if ($stmt->execute()) {
     header("Location: ../login/index.html");
    exit; // Sempre use exit após o header para evitar execução do restante do código
} else {
    echo "Erro: " . $stmt->error;
}


