<?php
@include 'config.php';
session_start();

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $senha = md5($_POST['senha']);
    $senha = filter_var($senha, FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM `usuarios` WHERE email = ? AND senha = ?";
    $result = $conexao->prepare($sql);
    $result->execute([$email, $senha]);
    $rowCount = $result->rowCount();

    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($rowCount > 0) {
        if ($row['tipo_usuario'] == 'cliente') {
            $_SESSION['uid'] = $row['id'];
            header('location:index.php');
        } else {
            $mensagem[] = 'Usuário não encontrado!';
        }
    } else {
        $mensagem[] = 'Combinação email e/ou senha incorreta!';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilo.css" />
    <title>TecShop - A melhor loja de eletrônicos</title>
</head>

<body>
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
    <section>
        <section class="form-container">
            <form action="" enctype="multipart/form-data" method="POST">
                <h3>Entrar</h3>
                <input type="email" name="email" class="box" placeholder="preencha seu email" required>
                <input type="password" name="senha" class="box" placeholder="preencha sua senha" required>
                <input type="submit" value="Entrar" class="btn" name="entrar">
                <p>Não tem uma conta? <a href="registro.php">Registre-se aqui</a></p>
            </form>
        </section>
</body>

</html>