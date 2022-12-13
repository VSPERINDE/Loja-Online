<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['uid'];

if (!isset($user_id)) {
    header('location:login.php');
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
        <h2>Destaques</h2>
        <?php
        $sql = "SELECT * FROM `produtos` WHERE destaque = '1'";
        $result = $conexao->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            while ($produtos = $result->fetch(PDO::FETCH_ASSOC)) {
                echo
                    '<div class="produto">
                    <img class="img-postagem" src="img/' . $produtos['foto'] . '">
                    <h2><a href="produto.html">' . $produtos['nome'] . '</a></h2>
                    <ins>R$ ' . $produtos['preco'] . '</ins>
                    <div class="produto-add">
                        <a type="submit" class="add-botao" href="produto.php?pid=' . $produtos['id'] . '">Adicionar ao carrinho</a>
                    </div>
                    <div class="produto-add">
                        <a class="add-botao" href="produto.php?pid=' . $produtos['id'] . '">Saber mais</a>
                    </div>
                    </div>';
            }
        } else
            echo '<p class="empty">Nenhum produto em destaque encontrado!</p>';
        ?>
    </div>
</body>


</html>