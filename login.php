<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if ($_GET["status"] == "off") {
		$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-info alert-dismissable">';
		$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
		$_SG['status-alert'] = $_SG['status-alert'] . ' Info! Entre com seu Usuário e Senha.';
		$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
	}
	if ($_GET["status"] == "erro") {
		$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissable">';
		$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
		$_SG['status-alert'] = $_SG['status-alert'] . ' Erro! Usuário ou Senha incorreto.';
		$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
	}
}
?>

<!DOCTYPE HTML>
<html>

<head>
	<?php include 'head.php'; ?>
</head>

<body class="">
	<div class="main-content">
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page login-page ">
				<h2 class="title1">Login</h2>
				<div class="widget-shadow">
					<div class="login-body">
						<?php
						echo $_SG['status-alert'];
						?>
						<form action="valida.php" method="POST">
							<input type="text" class="user" name="usuario_login" placeholder="Seu Usuário" required>
							<input type="password" minlength="5" class="lock" name="usuario_senha" placeholder="Senha" required>
							<div class="forgot-grid">
								<label class="checkbox"><input type="checkbox" checked=""><i></i>Lembre
									de mim</label>
								<div class="forgot">
									<a data-toggle="modal" data-target="#erroModal">Esqueceu a senha?</a>
								</div>
								<div class="clearfix"> </div>
							</div>
							<input type="submit" value="ENTRAR">
							<div class="registration">
								Você não tem uma conta ?
								<a class="" data-toggle="modal" data-target="#erroModal">
									Crie a sua conta aqui
								</a>
							</div>
							<br>
							<div class="col-md-12">
								<a href="painel.php"><button type="button" class="btn btn-success col-md-5">Painel Hall</button></a>
								<div class="col-md-1" style="width: 16%;"> </div>
								<a href="painelFicha.php"><button type="button" class="btn btn-info col-md-5">Painel Ficha</button></a>
							</div>
						</form>
						<!-- Modal -->
						<div class="modal fade" id="erroModal" tabindex="-1" role="dialog" aria-labelledby="erroLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h2 class="modal-title">Erro</h2>
									</div>
									<div class="modal-body">
										<p>
											Não foi possível processar sua solicitação. Entre
											em contato com o setor de Informática.
										</p>
									</div>
								</div>
							</div>
						</div>
						<!-- Fim Modal -->
					</div>
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