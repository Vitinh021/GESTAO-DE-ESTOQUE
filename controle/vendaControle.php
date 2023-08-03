<?php
session_start();
if($_SESSION['id'] == NULL){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/controle/autenticar.php';
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/Venda.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/VendaDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ItemDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ProdutoDAO.php';

//switch


switch ($_REQUEST['metodo']) {
    case 'salvar':
        VendaControle::salvar();
        break;
    case 'atualizar':
        VendaControle::atualizar();
        break;
    case 'deletar':
        VendaControle::deletar();
        break;
}

class VendaControle{

    public static function salvar(){
        try {
            $obj = new Venda();
            $obj->setTotal((int) 0);
            $obj->setData(NULL);
            $obj->setDesconto((int) 0);
            session_start();
            $obj->setUsuario($_SESSION['id']);
            $idVenda = VendaDAO::getInstancia()->inserir($obj);
            header("location: /empresa/itemListar.php?id=".$idVenda);
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }

    public static function atualizar(){
        date_default_timezone_set('America/Sao_Paulo');
        try {
            $obj = new Venda();
            $obj->setId((int) $_REQUEST['idVenda']);
            $obj->setTotal((float) $_REQUEST['total']);
            $obj->setDesconto((float) $_REQUEST['desconto']);
            $obj->setData(date("Y-m-d H:i:s"));
            session_start();
            $obj->setUsuario($_SESSION['id']);
            VendaDAO::getInstancia()->atualizar($obj);
            header("location: /empresa/vendaListar.php");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }        
    }

    public static function deletar(){
        try {
            $itens = ItemDAO::getInstancia()->listarTodos($_REQUEST['id']);//pegar a lista de itens
            foreach ($itens as $item) {
                $produto = ProdutoDAO::getInstancia()->getById($item['idProduto']);
                $produto->setQtd((int) $produto->getQtd() + (int) $item['qtd']);//adicionara a qtd do produto
                ProdutoDAO::getInstancia()->atualizar($produto);//atualizar o produto
            }
            VendaDAO::getInstancia()->deletar($_REQUEST['id']);//deletar todos os itens da venda e a venda
            header("location: /empresa/vendaListar.php?");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }
}
?>