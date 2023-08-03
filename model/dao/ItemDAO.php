<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/BDPDO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/Item.php';

class ItemDAO {

    public static $instancia;

    public static function getInstancia() {
        if (!isset(self::$instancia)){
            self::$instancia = new ItemDAO();
        }
        return self::$instancia;
    }

    public function inserir(Item $item) {
        try {
            $sql = "INSERT INTO item_venda(qtd, id_venda, id_produto) VALUES (:qtd, :id_venda, :id_produto)";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":qtd", $item->getQtd());
            $p_sql->bindValue(":id_venda", (int) $item->getVenda());
            $p_sql->bindValue(":id_produto", (float) $item->getProduto());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de salvar" . $e->getMessage();
        }
    }

    public function atualizar(Item $item) {
        try {
            $sql = "UPDATE item_venda SET qtd=:qtd, id_venda=:id_venda, id_produto=:id_produto WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":qtd", $item->getQtd());
            $p_sql->bindValue(":id_venda", $item->getVenda());
            $p_sql->bindValue(":id_produto", $item->getProduto());
            $p_sql->bindValue(":id", $item->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function deletar($id) {
        try {
            $sql = "DELETE FROM item_venda WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de deletar" . $e->getMessage();
        }
    }

    public function listarTodos($idVenda) {
        try {
            $sql = "SELECT iv.id, p.descricao, p.preco, iv.qtd, (iv.qtd * p.preco) AS subtotal, p.id AS idProduto
                    FROM item_venda AS iv
                    JOIN produto AS p ON iv.id_produto = p.id
                    WHERE iv.id_venda = :idVenda";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":idVenda", $idVenda);    
            $p_sql->execute();
            $linha = $p_sql->fetch(PDO::FETCH_ASSOC);
            $lista = array();
            while ($linha) {
                $lista[] = $linha;
                $linha = $p_sql->fetch(PDO::FETCH_ASSOC);
            } 
            return $lista;
        } catch (Exception $e) {
            print "Erro ao executar a função de listarTodos" . $e->getMessage();
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT iv.id_venda AS venda, p.id AS produto, p.descricao, p.preco, iv.qtd
                    FROM item_venda AS iv
                    JOIN produto AS p ON iv.id_produto = p.id
                    WHERE iv.id = :id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":id", $id);    
            $p_sql->execute();
            return $p_sql->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Erro ao executar a função de listarTodos" . $e->getMessage();
        }
    }

}

?>