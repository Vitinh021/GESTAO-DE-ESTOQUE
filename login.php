<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet" >

</head>

<body class="bg-gradient-primary">
    <br><br><br><br><br><br><br><br><br><br><br>
    <div class="container d-flex justify-content-center align-items-center">

        <div class="card border-0 shadow-lg my-5">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-black-900 mb-4">FAZER LOGIN</h1>
                    </div>
                    <form class="user" method="POST" action="controle/autenticar.php">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" name="nome" class="form-control form-control-user" id="nome" placeholder="Nome">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="senha" class="form-control form-control-user" id="senha" placeholder="Senha">
                            </div>
                        </div>
                        <input class="btn btn-success btn-user btn-block" type="submit" value="Autenticar"/>
                    </form>
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

</body>

</html>