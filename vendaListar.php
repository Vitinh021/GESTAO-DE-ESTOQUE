<?php
session_start();
if($_SESSION['id'] == NULL){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/controle/autenticar.php';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Vendas</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php require_once "controle/menu.php"?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="card shadow mt-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">VENDAS</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <form action="controle/vendaControle.php" method="POST">
                                        <input type="hidden" name="metodo" value="salvar">
                                        <button type="submit" class="btn btn-success btn-icon-split mb-2">
                                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                                            <span class="text">Nova venda</span>
                                        </button>
                                    </form>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>TOTAL</th>
                                            <th>DATA/HORA</th>
                                            <th>DESCONTO</th>
                                            <th>USUARIO</th>
                                            <th>AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/VendaDAO.php';
                                            require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/UsuarioDAO.php';
                                            $vendas = VendaDAO::getInstancia()->listarTodos();
                                            foreach ($vendas as $venda) {
                                                    echo '<tr>';
                                                    echo '<td>' . $venda->getId() . "</td>";
                                                    $total = $venda->getTotal() == NULL ? '0' : $venda->getTotal();
                                                    echo '<td>' . $total . "</td>";
                                                    if($venda->getData() == NULL){
                                                        echo "<td>Venda em aberto</td>";
                                                    }else{
                                                        $data = new DateTime($venda->getData());
                                                        $dataFormatada = $data->format("d/m/Y H:i:s");
                                                        echo '<td>' . $dataFormatada . "</td>";
                                                    }
                                                    $desconto = $venda->getDesconto() == NULL ? '0' : $venda->getDesconto();
                                                    echo '<td>' . $desconto . "</td>";
                                                    $usuario = UsuarioDAO::getInstancia()->getById($venda->getUsuario());
                                                    echo '<td>' . $usuario->getNome() . "</td>";
                                                    echo "<td> ";
                                                    
                                                    echo "<a href=itemListar.php?id=".$venda->getId()." class='btn btn-warning btn-icon-split'>
                                                            <span class='icon text-white-50'>
                                                                <i class='fas fa-pen'></i>
                                                            </span>
                                                            <span class=text>Itens</span>
                                                        </a>";
                                                    echo "<a onclick=confirmar(".$venda->getId().") class='btn btn-danger btn-icon-split ml-2'>
                                                            <span class='icon text-white-50'>
                                                                <i class='fas fa-trash'></i>
                                                            </span>
                                                            <span class=text>Remover</span>
                                                        </a>";

                                                    if($venda->getData() == NULL){
                                                        echo "<a href='itemCadastrar.php?id=". $venda->getId() . "' class='btn btn-primary btn-icon-split ml-2'>
                                                            <span class='icon text-white-50'>
                                                                <i class='fas fa-check'></i>
                                                            </span>
                                                            <span class=text>Finalizar</span>
                                                        </a>";
                                                    }
                                                    echo "</td>";
                                                    
                                                    echo '</tr>';
                                            }
                                            ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MEU SCRIPT-->
    <script>
    function confirmar(id) {
        if (confirm("Exucutar essa ação? Dados serão apagados!")) {
            window.location.href = "controle/vendaControle.php?id=" + id + "&metodo=deletar";
        }
    }
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>