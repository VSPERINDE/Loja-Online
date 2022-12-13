<?php

@include 'config.php';

if (isset($_POST['registrar'])) {

    $nome = $_POST['nome'];
    $nome = filter_var($nome, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $senha = md5($_POST['senha']);
    $senha = filter_var($senha, FILTER_SANITIZE_STRING);
    $conf_senha = md5($_POST['conf_senha']);
    $conf_senha = filter_var($conf_senha, FILTER_SANITIZE_STRING);
    $foto = $_FILES['foto']['name'];
    $foto = filter_var($foto, FILTER_SANITIZE_STRING);
    $foto_size = $_FILES['foto']['size'];
    $foto_tmp_nome = $_FILES['foto']['tmp_name'];
    $foto_folder = 'uploaded_img/' . $foto;

    $select = $conexao->prepare("SELECT * FROM `usuarios` WHERE email = ?");
    $select->execute([$email]);

    if ($select->rowCount() > 0) {
        $mensagem[] = 'E-mail de usuário já existe!';
    } else {
        if ($senha != $conf_senha) {
            $mensagem[] = 'Senhas não batem!';
        } else {
            if ($foto_size > 2000000) {
                $mensagem[] = 'Foto é muito grande!';
            } else {
                move_uploaded_file($foto_tmp_nome, $foto_folder);
                $insert = $conexao->prepare("INSERT INTO `usuarios`(nome, email, senha, foto) VALUES(?,?,?,?)");
                $insert->execute([$nome, $email, $senha, $foto]);
                $mensagem[] = 'Registrado com sucesso!';
                header('location:login.php');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
         <i class="" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }

    ?>

    <section>
        <section class="form-container">
            <form action="" enctype="multipart/form-data" method="POST">
                <h3>Registre-se</h3>
                <input type="text" name="nome" class="box" placeholder="preencha seu nome" required>
                <input type="email" name="email" class="box" placeholder="preencha seu email" required>
                <input type="password" name="senha" class="box" placeholder="preencha sua senha" required>
                <input type="password" name="conf_senha" class="box" placeholder="confirme sua senha" required>
                <p>Escolha uma foto de perfil:</p><input type="file" name="foto" class="box" required
                    accept="foto/jpg, foto/jpeg, foto/png">
                <input type="submit" value="Registrar" class="btn" name="registrar">
                <p>Já tem uma conta? <a href="login.php">Entre aqui</a></p>
            </form>
        </section>
</body>

</html>