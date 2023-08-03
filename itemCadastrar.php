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
    <title>Itens</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">
        <?php require_once "controle/menu.php"?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <div class="row w-50 ml-1">
                        <div class="card shadow mt-5 mr-1 w-25 col">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">ADICIONAR ITENS</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="controle/itemControle.php">
                                    <div class="row">
                                        <div class="col mb-3 w-25">
                                            <label for="produto" class="form-label"><strong>ID PRODUTO</strong></label>
                                            <input name='produto' type="text" class="form-control" id="produto" placeholder="Digite...">
                                        </div>
                                        <div class="col mb-3 w-25">
                                            <label for="qtd" class="form-label"><strong>QTD</strong></label>
                                            <input name="qtd" type="number" class="form-control" id="qtd">
                                        </div>
                                    </div>
                                    <input type="hidden" name="metodo" value=salvar>
                                    <?php echo "<input type='hidden' name='idVenda' value=" . $_REQUEST['id'] . ">" ?>
                                    
                                    <button type="submit" class="btn btn-success btn-icon-split mb-2">
                                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                                            <span class="text">Adicionar</span>
                                    </button>
                                    <?php 
                                        echo "<a href=itemListar.php?id=".$_REQUEST['id']." class='mb-2 btn btn-warning btn-icon-split'>
                                            <span class='icon text-white-50'>
                                                <i class='fas fa-pen'></i>
                                            </span><span class=text>Itens</span>
                                            </a>";
                                    ?>
                                </form>
                            </div>
                        </div>
                        <div class="card shadow mt-5 w-25 col">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">DETALHES DA VENDA</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" onsubmit="return confirmarEnvio()" action="controle/VendaControle.php">
                                    <div class="row">
                                        <?php
                                            
                                            echo "<div class='col mb-3 w-25'>";
                                            echo "    <label for='total' class='form-label'><strong>TOTAL</strong></label>";
                                                          require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/VendaDAO.php';
                                                          $valores = VendaDAO::getInstancia()->pegarTotalDesconto($_REQUEST['id']);
                                                          echo "<input name='label' type='text' value=". ($valores["total"]==NULL? 0 : $valores["total"]). " class='form-control' id='label' disabled>";
                                                          echo "<input type='hidden' name='total' value=" . ($valores["total"]==NULL? 0 :$valores["total"]). ">";
                                            echo "</div>";
                                            echo "<div class='col mb-3 w-25'>";
                                            echo "    <label for='desconto' class='form-label'><strong>DESCONTO</strong></label>";
                                            echo "    <input name='desconto' type='text' value=".  ($valores["desconto"]==NULL? 0 :$valores["desconto"]) ." placeholder='R$ 0,00' class='form-control' id='desconto'>";
                                            echo "</div>";
                                        ?>
                                    </div>
                                    <input type="hidden" name="metodo" value=atualizar>
                                    <?php echo "<input type='hidden' name='idVenda' value=" . $_REQUEST['id'] . ">";?>
                                    <button type="submit" class="btn btn-primary btn-icon-split mb-2">
                                            <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                            <span class="text">Finalizar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mt-2 w-50">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">LISTA DE PRODUTOS</h6>
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>PREÇO</th>
                                    <th>ESTOQUE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ProdutoDAO.php';
                                    $produtos = ProdutoDAO::getInstancia()->listarTodos();
                                    foreach ($produtos as $produto) {
                                        echo '<tr>';
                                        echo '<td>' . $produto->getId() . "</td>";
                                        echo '<td>' . $produto->getDescricao() . "</td>";
                                        echo '<td>' . $produto->getPreco() . "</td>";
                                        echo '<td>' . $produto->getQtd() . "</td>";
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

    <script>
        function confirmarEnvio() {
            return confirm("Deseja finalizar a venda?");
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