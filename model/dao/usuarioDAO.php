<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/BDPDO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/usuario.php';

class usuarioDAO {

    public static $instancia;


    

    public static function getInstancia() {
        if (!isset(self::$instancia)){
            self::$instancia = new usuarioDAO();
        }
        return self::$instancia;
    }
   
    public function inserir(usuario $user) {
        try {
            $sql = "INSERT INTO usuario(nome, senha, visibilidade) VALUES (:nome, :senha, :visibilidade)";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":nome", $user->getNome());
            $p_sql->bindValue(":senha", $user->getSenha());//critografar a senha
            $p_sql->bindValue(":visibilidade", $user->getVisibilidade());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de salvar" . $e->getMessage();
        }
    }
    
    public function atualizar(usuario $user) {
        try {
            $sql = "UPDATE usuario SET nome=:nome, senha=:senha WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":nome", $user->getNome());
            $p_sql->bindValue(":senha", $user->getSenha());
            $p_sql->bindValue(":id", $user->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }
    
    public function alterarVisibilidade($user) {
        try {
            $sql = "UPDATE usuario SET visibilidade=:visibilidade WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":visibilidade", 0);//perderá o acesso ao produto
            $p_sql->bindValue(":id", $user);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de deletar" . $e->getMessage();
        }
    }
   
    public function getById($user) {
        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":id", $user);
            $p_sql->execute();
            return $this->criaruser($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Erro ao executar a função de getById" . $e->getMessage();
        }
    }
   
    public function autenticar($nome, $senha) {
        try {
            $sql = "SELECT * FROM usuario WHERE nome = :nome AND senha = :senha AND visibilidade = 1";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":nome", $nome);
            $p_sql->bindValue(":senha", $senha);
            $p_sql->execute();
            $user = $p_sql->fetch(PDO::FETCH_ASSOC);
            if ($user != false) {
                return $this->criaruser($user);
            } else {
                return NULL;
            }
        } catch (Exception $e) {
            print "Erro ao executar a função de getById" . $e->getMessage();
        }
    }
  
    public function listarTodos() {
        try {
            $sql = "SELECT * FROM usuario WHERE visibilidade = 1 ORDER BY id DESC";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->execute();
            $lista = array();
            $linha = $p_sql->fetch(PDO::FETCH_ASSOC);
            while ($linha) {
                $lista[] = $this->criaruser($linha);
                $linha = $p_sql->fetch(PDO::FETCH_ASSOC);
            } 
            return $lista;
        } catch (Exception $e) {
            print "Erro ao executar a função de listarTodos" . $e->getMessage();
        }
    }

    private function criaruser($linha) {
        $user = new usuario();
        $user->setId($linha['id']);
        $user->setNome($linha['nome']);
        $user->setSenha($linha['senha']);
        return $user;
    }
}

?>