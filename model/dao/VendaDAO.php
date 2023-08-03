<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/BDPDO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/Venda.php';

class VendaDAO {

    public static $instancia;

    public static function getInstancia() {
        if (!isset(self::$instancia)){
            self::$instancia = new VendaDAO();
        }
        return self::$instancia;
    }
    
    public function inserir(Venda $venda) {

        try {
            $sql = "INSERT INTO venda(total, datac, desconto, id_usuario) VALUES (:total, :datac, :desconto, :id_usuario)";

            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":total", $venda->getTotal());
            $p_sql->bindValue(":datac", $venda->getData());
            $p_sql->bindValue(":desconto", $venda->getDesconto());
            $p_sql->bindValue(":id_usuario", $venda->getUsuario());
            if ($p_sql->execute()) {
                $idVenda = BDPDO::getInstancia()->lastInsertId();
                return $idVenda;
            }
        } catch (Exception $e) {
            print "Erro ao executar a função de salvar: " . $e->getMessage();
        }
    }

    public function pegarTotalDesconto($venda) {
        try {
            $sql = "SELECT SUM((iv.qtd * p.preco)) AS total, v.desconto
                    FROM item_venda AS iv
                    JOIN venda AS v ON iv.id_venda = v.id
                    JOIN produto AS p ON iv.id_produto = p.id
                    WHERE iv.id_venda = :venda;";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":venda", $venda);
            if ($p_sql->execute()) {
                $valores = $p_sql->fetch(PDO::FETCH_ASSOC);
                return $valores;
            } 
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function listarTodos() {
        try {
            $sql = "SELECT * FROM venda ORDER BY id DESC";
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

    //FEITO
    public function atualizar(Venda $venda) {
        try {
            $sql = "UPDATE venda SET total=:total, datac=:datac, desconto=:desconto, id_usuario=:id_usuario WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":total", $venda->getTotal());
            $p_sql->bindValue(":datac", $venda->getData());
            $p_sql->bindValue(":desconto", $venda->getDesconto());
            $p_sql->bindValue(":id_usuario", $venda->getUsuario());
            $p_sql->bindValue(":id", $venda->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizar" . $e->getMessage();
        }
    }

    public function deletar($id) {
        try {
            BDPDO::getInstancia()->beginTransaction();
            // Primeira instrução DELETE
            $stmt1 = BDPDO::getInstancia()->prepare("DELETE FROM item_venda WHERE id_venda = :id_venda");
            $stmt1->bindParam(':id_venda', $id, PDO::PARAM_INT);
            $stmt1->execute();
            // Segunda instrução DELETE
            $stmt2 = BDPDO::getInstancia()->prepare("DELETE FROM venda WHERE id = :id");
            $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt2->execute();
            BDPDO::getInstancia()->commit();
        } catch (Exception $e) {
            BDPDO::getInstancia()->rollback();
            print "Erro ao executar a função de deletar" . $e->getMessage();
        }
    }

    public function atualizarTotal($venda) {
        try {
            $sql = "UPDATE venda SET total= (
                                            SELECT SUM(iv.qtd * p.preco)
                                            FROM item_venda AS iv 
                                            JOIN venda AS v ON iv.id_venda = v.id
                                            JOIN produto AS p ON iv.id_produto = p.id
                                            WHERE v.id =:id)
                    WHERE id=:id";
            $p_sql = BDPDO::getInstancia()->prepare($sql);
            $p_sql->bindValue(":id", $venda);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao executar a função de atualizarTotal" . $e->getMessage();
        }
    }

    private function criarObj($linha) {
        $obj = new Venda();
        $obj->setId($linha['id']);
        $obj->setTotal($linha['total']);
        $obj->setData($linha['datac']);
        $obj->setDesconto($linha['desconto']);
        $obj->setUsuario($linha['id_usuario']);
        return $obj;
    }
}

?>