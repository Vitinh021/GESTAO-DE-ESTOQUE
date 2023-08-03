<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/BDPDO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/Produto.php';

class ProdutoDAO {

    public static $instancia;
    public static function getInstancia() {
        if (!isset(self::$instancia)){
            self::$instancia = new ProdutoDAO();
        }
        return self::$instancia;
    }
   
    public function inserir(Produto $produto) {
        try {
            $sql = "INSERT INTO produto(descricao, preco, qtd, visibilidade) VALUES (:descricao, :preco, :qtd, :visibilidade)";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":descricao", $produto->getDescricao());
            $p_sql->bindValue(":preco", (float) $produto->getPreco());
            $p_sql->bindValue(":qtd", (float) $produto->getQtd());
            $p_sql->bindValue(":visibilidade", $produto->getVisibilidade());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de salvar" . $e->getMessage();
        }
    
    }

    public function atualizar(Produto $produto) {
        try {
            $sql = "UPDATE produto SET descricao=:descricao, preco=:preco, qtd=:qtd WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":descricao", $produto->getDescricao());
            $p_sql->bindValue(":preco", $produto->getPreco());
            $p_sql->bindValue(":qtd", $produto->getQtd());
            $p_sql->bindValue(":id", $produto->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function atualizarEstoque($id, $qtd) {
        try {
            $sql = "UPDATE produto SET qtd=:qtd WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":qtd", $qtd);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function alterarVisibilidade($id) {
        try {
            $sql = "UPDATE produto SET visibilidade=:visibilidade WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":visibilidade", 0);//perderá o acesso ao produto
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de deletar" . $e->getMessage();
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT * FROM produto WHERE id = :id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->criarObj($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Erro ao executar a função de getById" . $e->getMessage();
        }
    }

    public function listarTodos() {
        try {
            $sql = "SELECT * FROM produto WHERE visibilidade = 1";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->execute();
            $lista = array();
            $linha = $p_sql->fetch(PDO::FETCH_ASSOC);
            while ($linha) {
                $lista[] = $this->criarObj($linha);
                $linha = $p_sql->fetch(PDO::FETCH_ASSOC);
            } 
            return $lista;
        } catch (Exception $e) {
            print "Erro ao executar a função de listarTodos" . $e->getMessage();
        }
    }

    private function criarObj($linha) {

        $obj = new produto();
        $obj->setId($linha['id']);
        $obj->setDescricao($linha['descricao']);
        $obj->setPreco($linha['preco']);
        $obj->setQtd($linha['qtd']);
        return $obj;
    }
}

?>