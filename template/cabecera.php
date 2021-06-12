<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE">
	<title>Sitio web</title>

	<link rel="stylesheet" href="./css/bootstrap.min.css" />
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<ul class="nav navbar-nav" style="padding-left: 20px;">
			<li class="nav-item">
				<img width="50" src="img/imagen/gr-logo.png" class="mx-auto d-block" />
			</li>

			<li class="nav-item">
				<a class="nav-link" href="index.php">Inicio</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="cursos.php">Cursos</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="nosotros.php">Nosotros</a>
			</li>

			<?php 
				if (isset($_SESSION['usuario'])) {
					$url = './administrador/inicio.php';
				} else {
					$url = './administrador/index.php';
				}
				
				if (isset($_SESSION['usuario'])) {
					$usuario = $_SESSION['nombreUsuario'];
				} else {
					$usuario = 'Login';
				}
		    ?>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo $url; ?>"><?php echo $usuario; ?></a>
			</li>

			<?php if (!isset($_SESSION['usuario'])) {?>
				<li class="nav-item">
					<a class="nav-link" href="./administrador/seccion/registrar.php">Registrarse</a>
				</li>
			<?php } ?>
		</ul>
	</nav>

	<div class="container">
	<br/>
		<div class="row">