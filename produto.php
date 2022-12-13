<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['uid'];

if (!isset($user_id)) {
    header('location:login.php');
}
$mensagem = null;
function add_carrinho_f()
{
    @include 'config.php';
    $user_id = $_SESSION['uid'];
    $pid = $_GET['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM `produtos` WHERE id = ?";
    $result = $conexao->prepare($sql);
    $result->execute([$pid]);
    if ($result->rowCount() > 0) {
        $produtos = $result->fetch(PDO::FETCH_ASSOC);
    }
    $p_nome = $produtos['nome'];
    $p_nome = filter_var($p_nome, FILTER_SANITIZE_STRING);
    $p_preco = $produtos['preco'];
    $p_preco = filter_var($p_preco, FILTER_SANITIZE_STRING);
    $p_foto = $produtos['foto'];
    $p_foto = filter_var($p_foto, FILTER_SANITIZE_STRING);
    $p_qtd = $_POST['p_qtd'];
    $p_qtd = filter_var($p_qtd, FILTER_SANITIZE_STRING);

    $check_carrinho = $conexao->prepare("SELECT * FROM `carrinho` WHERE nome = ? AND uid = ?");
    $check_carrinho->execute([$p_nome, $user_id]);

    if ($check_carrinho->rowCount() > 0) {
        $mensagem = 'Este item já está no carrinho!';
    } else {
        $insere_carrinho = $conexao->prepare("INSERT INTO `carrinho`(uid, pid, nome, preco, quantidade, foto) VALUES(?,?,?,?,?,?)");
        $insere_carrinho->execute([$user_id, $pid, $p_nome, $p_preco, $p_qtd, $p_foto]);
        $mensagem = 'Adicionado no carrinho!';
    }
    return $mensagem;
}
if (isset($_POST['comprar'])) {
    $mensagem = add_carrinho_f();
    header('location:carrinho.php');
}

if (isset($_POST['add_carrinho'])) {
    $mensagem = add_carrinho_f();
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
        </ol>
    </div>
    <div class="area-principal">
        <h2>Detalhes do Produto</h2>

        <?php
        $pid = $_GET['pid'];
        $sql = "SELECT * FROM `produtos` WHERE id = ?";
        $result = $conexao->prepare($sql);
        $result->execute([$pid]);
        if ($result->rowCount() > 0) {
            while ($produtos = $result->fetch(PDO::FETCH_ASSOC)) {
                echo
                    '<div class="produto-sel">
            <div>
                <img class="img-postagem" src="img/' . $produtos['foto'] . '">
            </div>
            <h2><a>' . $produtos['nome'] . '</a></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum
                quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste,
                pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?
                <li>ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum
                    quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam
                    iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam
                    laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque
                    ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?
                </li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam
                    laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque
                    ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?
                </li>
                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam
                    laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque
                    ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?
                </li>
            </p>
            <ins>R$ ' . $produtos['preco'] . '</ins>
            <form action="" class="box" method="POST">
            <div class="produto-add">
            <a>Quantidade: </a><input type="number" min="1" value="1" name="p_qtd" class="qtd">
            </div>
            <div class="produto-add">
                <input type="submit" class="add-botao" value="Adicionar ao carrinho" name="add_carrinho">
            </div>
            <div class="produto-add">
                <input type="submit" class="add-botao" value="Comprar Agora" name="comprar">
            </div>
            </form>';
                if ($mensagem == null) {
                } else {
                    echo '<a class="mensagem">' . $mensagem . '</a>';
                }
                '</div>';
            }
        } else {
            echo '<p class="empty">Produto não encontrado!</p>';
        }
        ?>
    </div>
</body>


</html>