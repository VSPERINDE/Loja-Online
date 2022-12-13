<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['uid'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['enviar'])) {
    if (mail('02080300@aluno.canoas.ifrs.edu.br', $_REQUEST['assunto'], $_REQUEST['msg'], $_REQUEST['email'])) {
        $mensagem = 'E-Mail enviado com sucesso!<br>';
        echo $mensagem;
    } else {
        $mensagem = 'Erro no envio do e-mail.<br>';
        echo $mensagem;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <title>TecShop - A melhor loja de eletrônicos</title>
</head>

<body>
    <div id="nav">
        <div class="logo">
            <h1><span style="color: red;">TecShop</span> - A melhor loja de eletrônicos</h1>
        </div>
        <ol class="menu">
            <li><a href="index.php">Página Inicial</a></li>
            <li> <a href="produtos.php">Produtos</a>
                <ol>
                    <li><a href="produtos.php?categoria=games">Vídeo Games</a></li>
                    <li><a href="produtos.php?categoria=celulares">Celulares</a></li>
                    <li>Eletrodomésticos</li>
                    <li>Informática</li>
                </ol>
            </li>
            <li><a href="#">Minha Conta</a>
                <ol>
                    <li><a href="logout.php">Logout</a></li>
                </ol>
            </li>
            <li><a href="carrinho.php">Carrinho</a></li>
            <li><a href="contato.php">Contato</a></li>
        </ol>
    </div>
    <div class="area-principal">
        <h2>Envie-nos sua mensagem</h2>
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>Preencha abaixo</h3>
            <input type="email" name="email" class="contato" placeholder="preencha seu email" required>
            <input type="text" name="assunto" class="contato" placeholder="preencha o assunto da mensagem" required>
            <textarea name="mensagem" class="contato" placeholder="preencha sua mensagem" cols="10" rows="5"
                required></textarea>
            <input type="submit" value="Enviar" class="btn" name="enviar">
        </form>
        <?php

        if (isset($mensagem)) {
            foreach ($mensagem as $mensagem) {
                echo '
      <div class="mensagem">
         <span>' . $mensagem . '</span>
         <i onclick="this.parentElement.remove();"></i>
      </div>
      ';
            }
        }
        ?>
    </div>
</body>


</html>