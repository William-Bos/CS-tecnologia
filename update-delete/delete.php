<?php
session_start();
require '../conexão.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login/index.html");
    exit;
}

$id = $_POST['id'];
$acao = $_POST['acao'];

// UPDATE
if ($acao === 'update') {
    $instituicao = trim($_POST['instituicao']);
    $endereco = trim($_POST['endereco']);
    $cnpj = trim($_POST['cnpj']);
    $numero = trim($_POST['numero']);
    $email = trim($_POST['email']);
    $cep = trim($_POST['cep']);
    $senha = $_POST['senha'];
    $foto = $_FILES['foto'];
    $maps_link = $_POST['maps_link'] ?? '';
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    // Montar query base
    $query = "UPDATE instituicao 
              SET instituicao=?, endereco=?, cnpj=?, numero=?, email=?, cep=?, link=?, latitude=?, longitude=?";
    $params = [$instituicao, $endereco, $cnpj, $numero, $email, $cep, $maps_link, $latitude, $longitude];
    $types = "sssssssss";

    // Se enviou nova senha
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $query .= ", senha=?";
        $types .= "s";
        $params[] = $senhaHash;
    }

    // Se enviou nova imagem
    if (!empty($foto['name'])) {
        $pasta = "../Assets/uploads/";
        $nomeDoArquivo = uniqid() . "-" . basename($foto['name']);
        $caminho = $pasta . $nomeDoArquivo;

        if (move_uploaded_file($foto['tmp_name'], $caminho)) {
            $query .= ", imagem_instituicao=?";
            $types .= "s";
            $params[] = $caminho;
        }
    }

    // Finaliza query
    $query .= " WHERE id=?";
    $types .= "i";
    $params[] = $id;

    // Prepara e executa
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Dados atualizados com sucesso!'); window.location='update.php';</script>";
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
}

// DELETE
elseif ($acao === 'delete') {
    $stmt = $conn->prepare("DELETE FROM instituicao WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        session_destroy();
        echo "<script>alert('Conta deletada com sucesso!'); window.location='../login/index.html';</script>";
    } else {
        echo "Erro ao deletar: " . $stmt->error;
    }
}
?>
