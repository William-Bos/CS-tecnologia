<?php

require '../conexão.php';

$instituicao = trim($_POST['instituicao'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cnpj = trim($_POST['cnpj'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$email = trim($_POST['email'] ?? '');
$cep = trim($_POST['cep'] ?? '');
$senha = $_POST['senha'] ?? '';
$foto = $_FILES['foto'] ?? null;

if (
    empty($instituicao) ||
    empty($endereco) ||
    empty($cnpj) ||
    empty($numero) ||
    empty($email) ||
    empty($cep) ||
    empty($senha) ||
    empty($foto['name'])
) {
    echo "<script>alert('Preencha todos os campos antes de continuar!'); history.back();</script>";
    exit;
}


$pasta = "../Assets/uploads/";

$nomeDoArquivo = uniqid() . "-" . $foto['name'];

$caminho = $pasta . $nomeDoArquivo;

move_uploaded_file($foto['tmp_name'], $caminho);


$sql = "INSERT INTO instituicao (instituicao, endereco, cnpj, numero, email, cep, senha, imagem_instituicao) VALUES (?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $instituicao, $endereco, $cnpj, $numero, $email, $cep, $senha, $caminho);
if ($stmt->execute()) {
    echo "Cadastro feito com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}


