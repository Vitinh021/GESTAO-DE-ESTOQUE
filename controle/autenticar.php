<?php
if(isset($_REQUEST['nome'], $_REQUEST['senha'])){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/usuarioDAO.php';
    $user=usuarioDAO::getInstancia()->autenticar($_REQUEST['nome'], $_REQUEST['senha']);
    session_start();
    if($user != NULL){
        $_SESSION['id'] = $user->getId();
        header("location: /empresa/index.php");
    } else{
        $_SESSION['id'] = NULL;
        header("location: /empresa/login.php?e=1");
    }
}
else{
    header("location: /empresa/login.php");
}   

