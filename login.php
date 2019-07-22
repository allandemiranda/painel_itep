<!DOCTYPE HTML>
<html>

<head>
	<title>Sistema Necropapiloscopia</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Sistema, documentos" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
	<!-- Custom Theme files -->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!--js-->
	<script src="js/jquery-2.1.1.min.js"></script>
	<!--icons-css-->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!--Google Fonts-->
	<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
	<!--static chart-->
</head>

<body>
	<div class="login-page">
		<div class="login-main">
			<div class="login-head">
				<h1>Login</h1>
			</div>
			<div class="login-block">
				<?php
				if ($_GET["status"] == "erro") {
					echo '<div class="alert alert-danger alert-dismissable">';
					echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
					echo "Usuário ou Senha incorreto !";
					echo '</div>';
				}
				if ($_GET["status"] == "logout") {
					echo '<div class="alert alert-info alert-dismissable">';
					echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
					echo 'Entre com seu usuário e senha';
					echo '</div>';
				}
				?>
				<form method="post" action="valida.php">
					<input type="text" name="usuario" placeholder="Usuário" required="" maxlength="50">
					<input type="password" name="senha" class="lock" placeholder="Senha" maxlength="50">
					<div class="forgot-top-grids">
						<div class="clearfix"> </div>
					</div>
					<input type="submit" name="Entrar" value="Login">
				</form>
			</div>
		</div>
	</div>
	<!--inner block end here-->
	<?php include 'footer.php'; ?>

	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.js"> </script>
	<!-- mother grid end here-->
</body>

</html>