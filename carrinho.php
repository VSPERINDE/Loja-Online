<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['uid'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_item = $conexao->prepare("DELETE FROM `carrinho` WHERE pid = ?");
    $delete_item->execute([$delete_id]);
    header('location:carrinho.php');
}

if (isset($_GET['delete_tudo'])) {
    $delete_tudo = $conexao->prepare("DELETE FROM `carrinho` WHERE uid = ?");
    $delete_tudo->execute([$user_id]);
    header('location:carrinho.php');
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
        <h2>Meu Carrinho</h2>
        <?php
        $sql = "SELECT * FROM `carrinho` WHERE uid = ?";
        $result = $conexao->prepare($sql);
        $result->execute([$user_id]);
        if ($result->rowCount() > 0) {
            while ($produtos = $result->fetch(PDO::FETCH_ASSOC)) {
                echo
                    '<div class="produto">
            <img class="img-postagem" src="img/' . $produtos['foto'] . '">
            <h2><a id="iphone" href="produto.html">' . $produtos['nome'] . '</a></h2>
            <ins>R$ ' . $produtos['preco'] . '</ins>
            <div class="produto-add">
                <a>Quantidade</a>
                <span>
                    <span>
                        <input type="number" class="quantidade" value="' . $produtos['quantidade'] . '" />
                    </span>
                </span>
            </div>
            <div class="produto-add">
                <a class="add-botao" href="carrinho.php?delete=' . $produtos['pid'] . '">Remover</a>
            </div>
        </div>';
            }
        } else
            echo '<p class="empty">Nenhum produto em destaque encontrado!</p>';
        ?>
    </div>
    <table id="TabelaCarrinho">
        <tr>
            <th class="produto-cart">Produto</th>
            <th class="preco">Preço</th>
        </tr>
        <?php
        $sql = "SELECT * FROM `carrinho` WHERE uid = ?";
        $sql_sum = "SELECT SUM(preco) AS soma FROM `carrinho` WHERE uid = ?";
        $result = $conexao->prepare($sql);
        $result_sum = $conexao->prepare($sql_sum);
        $result->execute([$user_id]);
        $result_sum->execute([$user_id]);
        $produtos_sum = $result_sum->fetch(PDO::FETCH_ASSOC);
        if ($result->rowCount() > 0) {
            while ($produtos = $result->fetch(PDO::FETCH_ASSOC)) {
                echo
                    '<tr>
            <td class="produto-cart">' . $produtos['nome'] . '</td>
            <td class="preco">R$ ' . $produtos['preco'] . '</td>
        </tr>';
            }
            echo '<tr class="carrinhoTotal">
            <td>&nbsp;</td>
            <td>Total: R$ ' . $produtos_sum['soma'] . '</td>
        </tr>';
        }
        ?>
    </table>
    <div class="produto-add">
        <a class="botao-confirma" href="#">Continuar para pagamento</a>
    </div>
    <div class="produto-add">
        <a class="add-botao" href="carrinho.php?delete_tudo">Limpar carrinho</a>
    </div>
</body>

</html>