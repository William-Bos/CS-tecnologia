<?php
require 'conexão.php';

// Buscar todas as instituições cadastradas
$sql = "SELECT instituicao, endereco, cep, imagem_instituicao, link FROM instituicao";
$result = $conn->query($sql);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="header">
        <div class="elements">
            <div class="icon">
                <img src="/Assets/fenix.png" alt="">
            </div>
            <div class="title">CS Tecnológia</div>
        </div>
        <div class="sidebar">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" id="colorbtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>

            <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
                <div class="offcanvas-header" id="close">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body" id="body">

                    <div class="form-login">
                        <div class="img-perfil" id="pfp">
                            <img src="https://i.pinimg.com/originals/9f/16/72/9f1672710cba6bcb0dfd93201c6d4c00.jpg" alt="Usuário">
                        </div>

                        <label for="email" id="texte">E-mail:</label>
                        <input type="email" id="email" class="form-control">

                        <label for="senha" id="texts">Senha:</label>
                        <input type="password" id="senha" class="form-control">
                        <div class="botoes">
                            <button class="btn btn-light mt-3" id="log">Acessar</button>
                            <button class="btn btn-outline-light mt-2" id="cadas">Cadastre-se</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="center">
        <div class="menu">
            <div class="sub1">Sobre Nós</div>
            <div class="div"></div>
            <div class="sub1">Consulta</div>
            <div class="div"></div>
            <div class="sub1">Avaliações</div>
        </div>
    </div>


    <div class="banner">
        <img src="/Assets/banner.png" alt="">
    </div>

    <div class="search">
        <div class="btn1">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </div>
        </div>
        <div class="input"><input type="text" placeholder="Seu endereço"></div>
    </div>

    <div class="consulta">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="box">
                    <div class="img">
                        <img src="<?= !empty($row['imagem_instituicao']) ? htmlspecialchars(str_replace('../', '', $row['imagem_instituicao'])) : '/Assets/default_instituicao.jpg' ?>" alt="">
                    </div>
                    <div class="infos">
                        <div class="title"><?= htmlspecialchars($row['instituicao']) ?></div>
                        <div class="city"><?= htmlspecialchars($row['endereco']) ?></div>
                        <div class="cep">CEP: <?= htmlspecialchars($row['cep']) ?></div>
                        <div class="distancia">
                            <div class="text">Distância:</div>
                            <div class="km">2km</div>
                        </div>
                    </div>
                    <div class="button">
                        <div class="text"> <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">
                                Abrir no Maps
                            </a></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhuma instituição cadastrada.</p>
        <?php endif; ?>

    </div>


    <div class="conteudodois">
        <div class="title">Sobre nós</div>
        <div class="box1">
            <div class="row">
                <div class="title2">Consulta de instituições</div>
                <div class="exempled">
                    <div class="desc">Após o cadastro, você poderá vincular os postos sob sua responsabilidade e, por meio de uma interface em tabela, atualizar você mesmo os preços e os tipos de combustíveis oferecidos.</div>
                </div>
            </div>
            <div class="img"><img src="https://vestibulares.estrategia.com/portal/wp-content/uploads/2022/11/azzedine-rouichi-1afBUZcesB8-unsplash.jpg" alt=""></div>
        </div>

        <div class="box2">
            <div class="row">
                <div class="title2">Integração ao CRAS</div>
                <div class="exempled">
                    <div class="desc">Com filtros inteligentes, você seleciona o tipo de combustível e visualiza facilmente os preços e a localização dos postos.</div>
                </div>
            </div>
            <div class="img"><img src="https://tubarao.sc.gov.br/uploads/sites/265/2025/08/WhatsApp-Image-2025-08-29-at-10.24.51.jpeg" alt=""></div>
        </div>
    </div>
    </div>

</body>

</html>