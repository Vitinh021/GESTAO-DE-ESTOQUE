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

    <title>Produtos</title>
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
                            <h6 class="m-0 font-weight-bold text-primary">PRODUTOS</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <a href='produtoCadastrar.php' class='btn btn-success btn-icon-split mb-2'>
                                        <span class='icon text-white-50'> <i class="fas fa-solid fa-plus"></i> </span>
                                        <span class=text>Adicionar</span>
                                    </a>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>DESCRICAO</th>
                                            <th>PRECO</th>
                                            <th>QTD</th>
                                            <th>AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ProdutoDAO.php';
                                            $produtos = ProdutoDAO::getInstancia()->listarTodos();
                                            foreach ($produtos as $obj) {
                                                    echo '<tr>';
                                                    echo '<td>' . $obj->getId() . "</td>";
                                                    echo '<td>' . $obj->getDescricao() . "</td>";
                                                    echo '<td>' . $obj->getPreco() . "</td>";
                                                    echo '<td>' . $obj->getQtd() . "</td>";
                                                    echo "<td> ";
                                                    
                                                    echo "<a href='produtoCadastrar.php?id=".$obj->getId()."' class='btn btn-warning btn-icon-split'>
                                                            <span class='icon text-white-50'>
                                                                <i class='fas fa-pen'></i>
                                                            </span>
                                                            <span class=text>Editar</span>
                                                        </a>";
                                                    echo "<a onclick=confirmar(".$obj->getId().") class='btn btn-danger btn-icon-split ml-2'>
                                                            <span class='icon text-white-50'>
                                                                <i class='fas fa-trash'></i>
                                                            </span>
                                                            <span class=text>Remover</span>
                                                        </a>";
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
            window.location.href = "controle/produtoControle.php?id=" + id + "&metodo=deletar";
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