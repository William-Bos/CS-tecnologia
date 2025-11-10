<?php
session_start();
require '../conexão.php';

// Verifica se usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: ../login/index.html");
    exit;
}

// Busca os dados da instituição logada
$email = $_SESSION['email'];
$sql = "SELECT * FROM instituicao WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Usuário não encontrado!";
    exit;
}

$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Painel - Update/Deletar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="update.css">
</head>

<body class="p-5">

    <h2>Painel da Instituição</h2>

    <form action="delete.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

        <div class="mb-3">
            <label>Instituição:</label>
            <input type="text" name="instituicao" class="form-control" value="<?= $usuario['instituicao'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Endereço:</label>
            <input type="text" name="endereco" class="form-control" value="<?= $usuario['endereco'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Link do Google Maps:</label>
            <input type="url" name="maps_link" class="form-control"
                value="<?= htmlspecialchars($usuario['link']) ?>"
                placeholder="Cole aqui o link do Google Maps">
        </div>

        <div class="mb-3">
            <label>CNPJ:</label>
            <input type="text" name="cnpj" class="form-control" value="<?= $usuario['cnpj'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Número:</label>
            <input type="text" name="numero" class="form-control" value="<?= $usuario['numero'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label>CEP:</label>
            <input type="text" name="cep" class="form-control" value="<?= $usuario['cep'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Senha (deixe em branco para não alterar):</label>
            <input type="password" name="senha" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto:</label>
            <input type="file" name="foto" class="form-control">
            <?php if (!empty($usuario['imagem_instituicao'])): ?>
                <img src="<?= $usuario['imagem_instituicao'] ?>" width="100" class="mt-2">
            <?php endif; ?>
        </div>

        <button type="submit" name="acao" value="update" class="btn btn-primary">Atualizar</button>
        <button type="submit" name="acao" value="delete" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</button>
    </form>

</body>

</html>