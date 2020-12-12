<?php

date_default_timezone_set('America/Sao_Paulo');

class Comentario
{   
    private $pdo;
    public $msgErro = "";

    //conexão
    public function conectar($host,$user,$passwd,$db)
    {
        $host = 'database-crud.czb9kmerijgk.us-east-1.rds.amazonaws.com';
        $user = 'admin';
        $passwd = '941380187';
        $db = 'cadastro';
    
        global $pdo;
    
        try {
            $pdo = new PDO("mysql:dbname=".$db.";host=".$host, $user,$passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
            
        }
    }

    //função pra trazer os comentários do banco e exibir na tela.
    public function buscarComentarios()
    {
        $host = 'database-crud.czb9kmerijgk.us-east-1.rds.amazonaws.com';
        $user = 'admin';
        $passwd = '941380187';
        $db = 'cadastro';

        global $pdo;
        try {
            $pdo = new PDO("mysql:dbname=".$db.";host=".$host, $user,$passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        
        }
       
        $sql = $pdo->prepare("SELECT *,(SELECT nome FROM usuarios  WHERE id_usuario = 
        pk_id_usuario ) as nome_pessoa FROM comentarios ORDER BY dia DESC");
        $sql->execute();
        $dados = $sql->fetchAll(PDO:: FETCH_ASSOC);
        return $dados;
    }


    //função para excluir comentários
    public function excluirComentario($id_coment, $id_user)
    {
        $host = 'database-crud.czb9kmerijgk.us-east-1.rds.amazonaws.com';
        $user = 'admin';
        $passwd = '941380187';
        $db = 'cadastro';

        global $pdo;
        try {
            $pdo = new PDO("mysql:dbname=".$db.";host=".$host, $user,$passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        
        }

        if($id_user== 1)//adimistrador
        {
            $sql = $pdo->prepare("DELETE FROM comentarios WHERE id_comentario = :id_c");
            $sql->bindValue(":id_c",$id_coment);
            $sql->execute();
        }
       else
        {
           $sql = $pdo->prepare("DELETE FROM comentarios WHERE id_comentario = :id_c AND pk_id_usuario = :id_user");
            $sql->bindValue(":id_c",$id_coment);
           $sql->bindValue(":id_user",$id_user);
           $sql->execute(); 
        }

    }

    //fução para cadastrar comentários no banco
    public function inserirComentario($id_pessoa, $comentario)
    {
        $host = 'database-crud.czb9kmerijgk.us-east-1.rds.amazonaws.com';
        $user = 'admin';
        $passwd = '941380187';
        $db = 'cadastro';

        global $pdo;
        try {
            $pdo = new PDO("mysql:dbname=".$db.";host=".$host, $user,$passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();
        
        }
        
        $sql = $pdo->prepare("INSERT INTO  comentarios (comentario,dia,hora,pk_id_usuario) VALUES (:c, :d, :h, :pk)");
        $sql->bindValue(":c",$comentario);
        $sql->bindValue(":d",date('Y-m-d'));
        $sql->bindValue(":h",date('H:i'));
        $sql->bindValue(":pk",$id_pessoa);
        $sql->execute();
    
    }
}

?>