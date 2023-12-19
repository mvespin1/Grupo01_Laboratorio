<?php
require_once("./crud/constantes.php");
include_once("./crud/clases/class.usuario.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['usuario']) && isset($_POST['clave'])) {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        $cn = conectar();
        $users = new Usuario($cn);

        if ($users->validarUsuario($usuario, $clave)) {
            $redirectPage = $users->getRedirectPage();
            header("location:$redirectPage?op=$usuario");
            exit();
        } else {
            header("location:ErrorAutentificacion.php");
            exit();
        }
    } else {
        header("location:ErrorAutentificacion.php");
        exit();
    }
}

function conectar(){
    $c = new mysqli(SERVER, USER, PASS, BD);

    if ($c->connect_errno) {
        die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
    }

    $c->set_charset("utf8");
    return $c;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>VERIS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="./Recursos_LOGIN/css/style.css">
</head>

<body class="img js-fullheight" style="background-image: url(./Recursos_LOGIN/images/fondo2.svg);">

    <?php
    $users = $_SESSION['listaUser'];

    $html = '
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">VERIS - Medicos</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Por favor llenar los siguientes campos:</h3>
                        <form action="" method="POST" class="signin-form">
                            <div class="form-group">
                                <select class="form-control btn btn-secondary submit px-3" style="background-color: rgb(82, 82, 82);" name="usuario">
                                    <option disabled selected>  Escoje un usuario....  </option>';
    foreach ($users as $n) {
        if ($n->getRol() == 2) {
            $html .= "<option value=" . $n->getNombre() . ">" . $n->getNombre() . "</option>";
        }
    }
    $html .= '   </select>
                            </div> 
                            <div class="form-group">
                                <input id="pass" name="clave" type="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-secondary submit px-3" style="background-color: rgb(82, 82, 82);" value="LOGIN"><br>
                            </div>
                            <div class="form-group">
                                <a href="cerrar.php" class="form-control btn btn-secondary submit px-3" style="background-color: rgb(82, 82, 82);" value="CERRAR">CERRAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>';

    echo $html;
    ?>

    <script src="./Recursos_LOGIN/js/jquery.min.js"></script>
    <script src="./Recursos_LOGIN/js/popper.js"></script>
    <script src="./Recursos_LOGIN/js/bootstrap.min.js"></script>
    <script src="./Recursos_LOGIN/js/main.js"></script>

</body>

</html>
