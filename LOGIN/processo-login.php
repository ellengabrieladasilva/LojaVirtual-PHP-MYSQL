<?php

require_once 'CLASSES/usuarios.php';
$u = new Usuario;

if(isset($_POST['email']))

{
    $email =addslashes($_POST['email']);
    $senha =addslashes($_POST['senha']);

    //verificar se todos os campos estão preenchidos
    if(!empty($email) && !empty($senha))
    {
        $u->conectar('database-crud.czb9kmerijgk.us-east-1.rds.amazonaws.com','admin', '94138087','cadastro' );
            if($u->msgErro == "")
            {
                if($u->logar($email,$senha))
                {
                   header("location: ../index.php");
                }
                else
                {
                    ?>
                    <script type="text/javascript">
                        alert('Email e/ou senha estão incorretos!');
                    </script>
                    <?php
                }
            }
            else
            {
                echo " Erro:".$u->msgErro;
            }
    }
    else
    {
        ?>
        <script type="text/javascript">
            alert('Preencha todos os campos!');
        </script>
        <?php
    }
}