<?php
//Variáveis globais
$email = '02080300@aluno.canoas.ifrs.edu.br';
$telefone = '(51) 5555-5555';
$whatsapp = '(51) 99301-6670';

$nome_loja = '';
$endereço_loja = 'Rua Capão da Canoa 356, Canoas - RS';

$url_loja = 'localhost/loja';


//variáveis do banco
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = "mysql:host=localhost;dbname=loja";

$conexao = new PDO($banco, $usuario, $senha);



?>