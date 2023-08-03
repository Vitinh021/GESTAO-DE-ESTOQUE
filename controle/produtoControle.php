<?php
session_start();
if($_SESSION['id'] == NULL){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/controle/autenticar.php';
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/produto.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ProdutoDAO.php';

//switch

switch ($_REQUEST['metodo']) {
    case 'salvar':
        ProdutoControle::salvar();
        break;
    case 'atualizar':
        ProdutoControle::atualizar();
        break;
    case 'deletar':
        ProdutoControle::deletar();
        break;
}

class ProdutoControle{
    //FEITO
    public static function salvar(){
        try {
            $obj = new Produto();
            $obj->setDescricao($_REQUEST['descricao']);
            $obj->setPreco($_REQUEST['preco']);
            $obj->setQtd($_REQUEST['qtd']);
            $obj->setVisibilidade(1);
            ProdutoDAO::getInstancia()->inserir($obj);
            header("location: /empresa/produtoListar.php");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }
    //FEITO
    public static function atualizar(){
        try {
            $obj = new Produto();
            $obj->setId((int) $_REQUEST['id']);
            $obj->setDescricao($_REQUEST['descricao']);
            $obj->setPreco((float) $_REQUEST['preco']);
            $obj->setQtd((int) $_REQUEST['qtd']);
            ProdutoDAO::getInstancia()->atualizar($obj);
            header("location: /empresa/produtoListar.php");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }        
    }
    //FEITO
    public static function deletar(){
        try {
            ProdutoDAO::getInstancia()->alterarVisibilidade($_REQUEST['id']);
            header("location: /empresa/produtoListar.php");
            //colocar mensagem voltando
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }
}
?>