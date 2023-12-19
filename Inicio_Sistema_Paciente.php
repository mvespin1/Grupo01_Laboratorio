<?php
    require_once("./crud/constantes.php");
    require_once("./crud/clases/class.usuario.php");
    require_once("./crud/clases/class.paciente.php");

    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SISTEMA DE PACIENTES</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./Recursos_InicioSistema/css/styles.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="./Recursos_InicioSistema/css/main.css">
</head>

<body>

<?php

    $user = $_SESSION['listaUser'];
    if (isset($_POST['op']))
        $op = $_POST['op'];
    else
				if (isset($_GET['op']))
        $dato = $_GET['op'];
    $tmp = explode("/", $dato);
    // echo "<br>VARIABLE TEMP <br>";
    // echo "<pre>";
    // 	print_r($tmp);
    // echo "</pre>";
    $op = $tmp[0];
    $obj = $user[$op];

    $html = '';
  
    $html.='<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="#!">SISTEMA DE PACIENTES</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <h2 class="navbar-brand">Hola: <span>' . $obj->getNombre() . '</span></h2>
            <a class="navbar-brand" href="cerrar.php">CERRAR SESION</a>

            </ul>
        </div>
    </div>
    </nav>
    <!-- Content section-->
    <section class="py-5">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-10 ml-auto col-xl-12 mr-auto">
                    <!-- Nav tabs -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#consultas" role="tab">
                                        <i>Consultas</i> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#recetas" role="tab">
                                        <i>Recetas</i> 
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content text-center">
                                <div class="tab-pane active" id="consultas" role="tabpanel">
                                    <iframe src="./crud/CONSULTAS/index.php?op='.$obj->getNombre().'" style="width: 95%; height: 890px; border: none;"></iframe>
                                </div>
                                <div class="tab-pane" id="recetas" role="tabpanel">
                                    <iframe src="./crud/RECETAS/index.php?op='.$obj->getNombre().'" style="width: 95%; height: 890px; border: none;"></iframe>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>';

    echo $html;

    ?>

    <!-- Script para manejar los tabs -->
    <script>
        $(document).ready(function () {
            $('.nav-tabs a').click(function () {
                $(this).tab('show');
            });
        });
    </script>

    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="./Recursos_InicioSistema/js/scripts.js"></script>
</body>

</html>