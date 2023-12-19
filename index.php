<?php 
require("./crud/clases/class.usuario.php");
require_once("./crud/constantes.php");
session_start(); 
?>

<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>

    <!--- basic page needs
   ================================================== -->
    <meta charset="utf-8">
    <title>VERIS</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
   ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
   ================================================== -->
    <link rel="stylesheet" href="./Recursos_HomePage/css/base.css">
    <link rel="stylesheet" href="./Recursos_HomePage/css/vendor.css">
    <link rel="stylesheet" href="./Recursos_HomePage/css/main.css">

    <!-- script
   ================================================== -->
    <script src="./Recursos_HomePage/js/modernizr.js"></script>
    <script src="./Recursos_HomePage/js/pace.min.js"></script>

    <!-- favicons
	================================================== -->
    <link rel="shortcut icon" href="./Recursos_HomePage/favicon.ico" type="image/x-icon">
    <link rel="icon" href="./Recursos_HomePage/images/favicon.ico" type="image/x-icon">

</head>

<body id="top">

    <!-- header 
   ================================================== -->
    <header>

        <div class="header-logo">
        </div>

    </header> <!-- end header -->


    <!-- home
   ================================================== -->
    <section id="home">

        <div class="overlay"></div>

        <div class="home-content-table">
            <div class="home-content-tablecell">
                <div class="row">
                    <div class="col-twelve">

                        <h5 class="" style="color:white">UNIVERSIDAD DE LAS FUERZAS ARAMDAS "ESPE"<br>
                            <!-- <br>Sebastian Falconi -->
                            <!-- <br>Emilio Ñacato -->
							</h3>
                            <h3>VERIS<br></h3>
                                <div class="more animate-intro">
                                    <a class="button stroke" href="./loginPaciente.php">
                                        PACIENTES
                                    </a>
                                    <a class="button stroke" href="./loginMedico.php">
                                        MEDICOS
                                    </a>
                                    <a class="button stroke" href="./loginAdmin.php">
                                        ADMIN
                                    </a>
                                </div>

                    </div> <!-- end col-twelve -->
                </div> <!-- end row -->
            </div> <!-- end home-content-tablecell -->
        </div> <!-- end home-content-table -->

        <ul class="home-social-list">
            <li class="animate-intro">
                <a href="https://www.facebook.com/ESPE.U"><i class="fa fa-facebook-square"></i></a>
            </li>
            <li class="animate-intro">
                <a href="https://twitter.com/espeu?lang=es"><i class="fa fa-twitter"></i></a>
            </li>
            <li class="animate-intro">
                <a href="https://www.instagram.com/espe.u/"><i class="fa fa-instagram"></i></a>
            </li>

        </ul> <!-- end home-social-list -->

        <div class="scrolldown">
            <a href="#" class="scroll-icon smoothscroll">
                Michael Chicaiza - Marco Espín
            </a>
        </div>

    </section> <!-- end home -->

    <?php

    $cn = conectar();

    $users = new usuario($cn);
    $listaUsers = $users->get_usuarios();

    // echo "<pre>";
	// 	print_r($listaUsers);
	// echo "</pre>";

	$_SESSION['listaUser']=$listaUsers;

	function conectar(){
		//echo "<br> CONEXION A LA BASE DE DATOS<br>";
		$c = new mysqli(SERVER,USER,PASS,BD);
		
		if($c->connect_errno) {
			die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
		}else{
			//echo "La conexión tuvo éxito .......<br><br>";
		}
		
		$c->set_charset("utf8");
		return $c;
	}

	?>

    <div id="preloader">
        <div id="loader"></div>
    </div>

    <!-- Java Script
   ================================================== -->
    <script src="./Recursos_HomePage/js/jquery-2.1.3.min.js"></script>
    <script src="./Recursos_HomePage/js/plugins.js"></script>
    <script src="./Recursos_HomePage/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
    <!-- SCROOLL REVEAL SCRIPT -->
    <script>
        window.sr = ScrollReveal();

        sr.reveal('.home-content-tablecell', {
            duration: 2000,
            origin: 'bottom',
            distance: '300px'
        });



        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>


</body>

</html>
