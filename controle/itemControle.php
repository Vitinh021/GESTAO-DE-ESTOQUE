<?php
session_start();
if($_SESSION['id'] == NULL){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/controle/autenticar.php';
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/Item.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ItemDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/VendaDAO.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ProdutoDAO.php';

//ROTAS
switch ($_REQUEST['metodo']) {
    case 'salvar':
        ItemControle::salvar();
        break;
    case 'atualizar':
        ItemControle::atualizar();
        break;
    case 'deletar':
        ItemControle::deletar();
        break;
}

class ItemControle{


    public static function salvar(){
        try {
            $item = new Item();
            $item->setVenda($_REQUEST['idVenda']);
            $item->setProduto($_REQUEST['produto']);
            $item->setQtd($_REQUEST['qtd']);
            ItemDAO::getInstancia()->inserir($item);
            //atualizar produto subtraindo esttoque dele
            $produto = ProdutoDAO::getInstancia()->getById($_REQUEST['produto']);
            $produto->setQtd((int) $produto->getQtd() - (int) $_REQUEST['qtd']);
            ProdutoDAO::getInstancia()->atualizar($produto);
            header("location: /empresa/itemCadastrar.php?id=".$_REQUEST['idVenda']);
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }

    public static function atualizar(){
        try {
            $obj = new Item();
            $obj->setId((int) $_REQUEST['id']);
            $obj->setVenda($_REQUEST['idVenda']);
            $obj->setProduto($_REQUEST['idProduto']);
            $obj->setQtd((int) $_REQUEST['qtd']);

            $item = ItemDAO::getInstancia()->getById($_REQUEST['id']);//busca item
            $produto = ProdutoDAO::getInstancia()->getById($_REQUEST['idProduto']);//busca produto
            if((int) $_REQUEST['qtd'] >= (int) $item['qtd']){//5 >= 12
                $diferenca = (int) $_REQUEST['qtd'] - (int) $item['qtd'];//12-5=7
                $produto->setQtd((int) $produto->getQtd() - $diferenca);
                //diminuir do produto
            }else{
                $diferenca = (int) $item['qtd'] - (int) $_REQUEST['qtd'];//12-5=7
                $produto->setQtd((int) $produto->getQtd() + $diferenca);
                //adcionar ao produto
            }
            ProdutoDAO::getInstancia()->atualizar($produto);
            ItemDAO::getInstancia()->atualizar($obj);
            VendaDAO::getInstancia()->atualizarTotal($_REQUEST['idVenda']);
            header("location: /empresa/ItemListar.php?id=".$_REQUEST['idVenda']);
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }        
    }

    public static function deletar(){
        try {
            $item = ItemDAO::getInstancia()->getById($_REQUEST['id']);//busca item
            $produto = ProdutoDAO::getInstancia()->getById($item['produto']);//busca produto
            $produto->setQtd((int) $produto->getQtd() + (int) $item['qtd']);//adicionara a qtd do produto
            ProdutoDAO::getInstancia()->atualizar($produto);//atualizar o produto
            ItemDAO::getInstancia()->deletar($_REQUEST['id']);//remover o item
            VendaDAO::getInstancia()->atualizarTotal($_REQUEST['venda']);//atualizar o total da venda
            header("location: /empresa/ItemListar.php?id=".$_REQUEST['venda']);
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }
}
?>