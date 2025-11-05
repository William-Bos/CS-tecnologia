<?php

require 'conexão.php';

$instituicao = $_POST['instituicao'] ;
$nome = $_POST['nome'] ;
$cpf = $_POST['cpf'];
$contato = $_POST['contato'];
$email = $_POST['email'];
$cep = $_POST['cep'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);



