
<?php
session_start();
if($_SESSION['id'] == NULL){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/controle/autenticar.php';
}

$item = NULL;
if(isset($_REQUEST['id'])){
    require_once $_SERVER['DOCUMENT_ROOT'] . '/empresa/model/dao/ItemDAO.php';
    $item=ItemDAO::getInstancia()->getById($_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Item</title>
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
                    <div class="card shadow mt-5 w-25">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">EDITAR ITEM</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="controle/itemControle.php">
                                <div class="mb-3">
                                    <label for="produto" class="form-label"><strong>Produto</strong></label>
                                    <input name='produto' type="text" class="form-control" id="produto"
                                        value="<?php echo $item["descricao"]?>" disabled>
                                </div>
                                <div class="mb-3 w-25">
                                    <label for="preco" class="form-label"><strong>Preço</strong></label>
                                    <input name='preco' type="text" step="0.01" class="form-control" id="preco"
                                        value="<?php echo $item["preco"]?>" disabled>
                                </div>
                                <div class="mb-3 w-25">
                                    <label for="qtd" class="form-label"><strong>Qtd</strong></label>
                                    <input name='qtd' type="number" class="form-control" id="qtd" value="<?php echo $item["qtd"]?>">
                                </div>
                                <input type="hidden" name="metodo" value="atualizar">
                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']?>">
                                <input type="hidden" name="idProduto" value="<?php echo $item["produto"]?>">
                                <input type="hidden" name="idVenda" value="<?php echo $item["venda"]?>">

                                <button type="submit" class="btn btn-primary btn-icon-split mb-2">
                                        <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                        <span class="text">Atualizar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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