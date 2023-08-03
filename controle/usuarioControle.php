<?php
session_start();
if($_SESSION['id'] == NULL){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/controle/autenticar.php';
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/vo/usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/usuarioDAO.php';

//switch

switch ($_REQUEST['metodo']) {
    case 'salvar':
        usuarioControle::salvar();
        break;
    case 'atualizar':
        usuarioControle::atualizar();
        break;
    case 'deletar':
        usuarioControle::deletar();
        break;
}

class usuarioControle{
    //FEITO
    public static function salvar(){
        try {
            $user = new usuario();
            $user->setNome($_REQUEST['nome']);
            $user->setSenha($_REQUEST['senha']);
            $user->setVisibiliade(1);
            usuarioDAO::getInstancia()->inserir($user);
            header("location: /empresa/usuarioListar.php");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }
    //FEITO
    public static function atualizar(){
        try {
            $user = new usuario();
            $user->setId($_REQUEST['id']);
            $user->setNome($_REQUEST['nome']);
            $user->setSenha($_REQUEST['senha']);
            usuarioDAO::getInstancia()->atualizar($user);
            header("location: /empresa/usuarioListar.php");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }        
    }
    //FEITO
    public static function deletar(){
        try {
            usuarioDAO::getInstancia()->alterarVisibilidade($_REQUEST['id']);
            header("location: /empresa/usuarioListar.php");
        } catch (Exception $e) {
            print "Erro" . $e->getMessage();
            header("location: /empresa/erro.php");
        }
    }
}
?>