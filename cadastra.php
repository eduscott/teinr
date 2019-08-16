<?php
header('Content-type: text/html; charset=utf-8');

if (isset($_POST)):

    $nome    = (isset($_POST['nome']))? $_POST['nome']: '';
    $email   = (isset($_POST['email']))? $_POST['email']: '';
    $assunto = (isset($_POST['assunto']))? $_POST['assunto']: '';
    $msg     = (isset($_POST['mensagem']))? $_POST['mensagem']: '';

    // Valida se foram preenchidos todos os campos
    if (empty($nome) || empty($email) || empty($assunto) || empty($msg)):
        $array  = array('tipo' => 'alert alert-danger', 'mensagem' => 'Preencher todos os campos obrigatórios(*)!');
        echo json_encode($array);
    else:

        // Grava no banco de dados as informações do contato
        $opcoes = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');

        $pdo = new PDO('mysql:host=localhost;dbname=db_blog', 'root', '', $opcoes);

        $sql = "INSERT INTO contato (nome, email, assunto, mensagem)VALUES(?, ?, ?, ?)";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(1, $nome);
        $stm->bindValue(2, $email);
        $stm->bindValue(3, $assunto);
        $stm->bindValue(4, $msg);
        $stm->execute();

        if (empty($assunto)):
            $assunto = "Contato enviado pelo site " . SITE;
        endif;


    endif;
endif;

?>