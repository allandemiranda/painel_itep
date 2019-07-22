<!DOCTYPE HTML>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php include 'head.php'; ?>

<body>
	<div class="page-container">
		<div class="left-content">
			<div class="mother-grid-inner">
				<?php include 'nav.php'; ?>
				<!--inner block start here-->
				<div class="inner-block">
					<div class="error-404">
						<div class="error-page-left">
							<img src="images/404.png" alt="">
						</div>
						<div class="error-right">
							<h2>Oops! Page não aberta</h2>
							<h4>Não existe nada aqui!!</h4>
							<a href="/">Voltar</a>
						</div>
					</div>
				</div>
				<!--inner block end here-->
				<?php include 'footer.php'; ?>
			</div>
		</div>
		<?php include 'menu.php'; ?>
		<div class="clearfix"> </div>
	</div>
</body>

</html>