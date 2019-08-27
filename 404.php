<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
log_up("mail-enviado", "Usuário " . $_SESSION['usuarioNome'] . " acessou página " . $_SERVER['REQUEST_URI'] . " no ip " . $_SERVER["REMOTE_ADDR"]);
?>
<!DOCTYPE HTML>
<html>

<head>
	<?php include 'head.php'; ?>
</head>

<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php include 'menu.php'; ?>
		<?php include 'topBar.php'; ?>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<h3 class="title1">404 Error Page</h3>
				<div class="error-page">
					<div class="">
						<h2>404</h2>
					</div>
					<div class="">
						<h3><i class="fa fa-warning text-yellow"></i> Oops! Página não encontrada.</h3>
					</div>
					<p>Não foi possível encontrar a página que você estava procurando. Enquanto isso, você pode retornar
						ao painel.</p>
				</div>
			</div>
		</div>
		<!--footer-->
		<?php include 'footer.php'; ?>
		<!--//footer-->
	</div>
	<?php include 'scriptEnd.php'; ?>
</body>

</html>