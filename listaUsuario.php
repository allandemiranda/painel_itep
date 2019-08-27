<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
exigirAdmin();
log_up("mail-enviado", "Usuário " . $_SESSION['usuarioNome'] . " acessou página " . $_SERVER['REQUEST_URI'] . " no ip " . $_SERVER["REMOTE_ADDR"]);
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if ($_GET["requisicao"] == "setor") {
		$sql_lista_usuarios_nova_senha = "UPDATE `usuarios_tb` SET `usuario_setor_edit`='1' WHERE `usuario_id`='" . $_GET["usuarioID"] . "'";
		if (mysqli_query($_SG['link'], $sql_lista_usuarios_nova_senha)) {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário de ID ' . $_GET["usuarioID"] . ' com modificação de setor ativado.';
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
			log_up("criou", "Usuário " . $_SESSION['usuarioNome'] . " liberou mudança de setor para usuário de ID " . $_GET["usuarioID"] . " no ip " . $_SERVER["REMOTE_ADDR"]);
		} else {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		}
	}
	if ($_GET["requisicao"] == "senha") {
		$sql_lista_usuarios_nova_senha = "UPDATE `usuarios_tb` SET `usuario_senha`='" . md5('123456') . "' WHERE `usuario_id`='" . $_GET["usuarioID"] . "'";
		if (mysqli_query($_SG['link'], $sql_lista_usuarios_nova_senha)) {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário de ID ' . $_GET["usuarioID"] . ' com senha 123456.';
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
			log_up("criou", "Usuário " . $_SESSION['usuarioNome'] . " atualizou senha do usuário de ID " . $_GET["usuarioID"] . " para 123456 no ip " . $_SERVER["REMOTE_ADDR"]);
		} else {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		}
	}
	if ($_GET["requisicao"] == "deletar") {
		$sql_lista_usuarios_nova_deletar = "DELETE FROM `usuarios_tb` WHERE `usuario_id`='" . $_GET["usuarioID"] . "'";
		if (mysqli_query($_SG['link'], $sql_lista_usuarios_nova_deletar)) {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário de ID ' . $_GET["usuarioID"] . ' deletado.';
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
			log_up("primary", "Usuário " . $_SESSION['usuarioNome'] . " deletou usuário de ID " . $_GET["usuarioID"] . " no ip " . $_SERVER["REMOTE_ADDR"]);
		} else {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . " Error deleting record: " . mysqli_error($_SG['link']);
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		}
	}
}
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
			<?php
			echo $_SG['status-alert'];
			?>
			<div class="main-page">
				<div class="tables">
					<div class="bs-example widget-shadow" data-example-id="hoverable-table">
						<h4>Lista Usuários</h4>
						<table class="table table-hover">
							<thead>
								<tr>
									<th style="text-align: center;">#</th>
									<th style="text-align: center;">Nome</th>
									<th style="text-align: center;">Cargo</th>
									<th style="text-align: center;">Setor</th>
									<th style="text-align: center;">Usuário</th>
									<th style="text-align: center;">Senha</th>
									<th style="text-align: center;">Setor</th>
									<th style="text-align: center;">Excluir</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql_lista_usuarios = "SELECT `usuario_id`, `usuario_nome`, `usuario_cargo`, `usuario_setor_id`, `usuario_login` FROM `usuarios_tb`";
								$query_lista_usuarios = mysqli_query($_SG['link'], $sql_lista_usuarios);

								while ($row_lista_usuarios = mysqli_fetch_assoc($query_lista_usuarios)) {
									echo '<tr>';
									echo '<th scope="row" style="text-align: center;">' . $row_lista_usuarios["usuario_id"] . '</th>';
									echo '<td style="text-align: center;">' . $row_lista_usuarios["usuario_nome"] . '</td>';
									echo '<td style="text-align: center;">' . $row_lista_usuarios["usuario_cargo"] . '</td>';
									$sql_lista_setores = "SELECT `setor_id`, `setor_nome` FROM `setores_tb`";
									$query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
									while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
										if ($row_lista_usuarios["usuario_setor_id"] == $row_lista_setores["setor_id"]) {
											echo '<td style="text-align: center;">' . $row_lista_setores["setor_nome"] . '</td>';
										}
									}
									echo '<td style="text-align: center;">' . $row_lista_usuarios["usuario_login"] . '</td>';
									if ($row_lista_usuarios["usuario_id"] == $_SESSION['usuarioID']) {
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';
									} else {
										echo '<td style="text-align: center;"><a href="?requisicao=senha&usuarioID=' . $row_lista_usuarios["usuario_id"] . '"><i class="glyphicon glyphicon-info-sign"></i></td>';
										echo '<td style="text-align: center;"><a href="?requisicao=setor&usuarioID=' . $row_lista_usuarios["usuario_id"] . '"><i class="fa fa-coffee"></i></a></td>';
										echo '<td style="text-align: center;"><a href="?requisicao=deletar&usuarioID=' . $row_lista_usuarios["usuario_id"] . '"><i class="glyphicon glyphicon-remove-circle"></i></a></td>';
									}
									echo '</tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!--footer-->
		<?php include 'footer.php'; ?>
		<!--//footer-->
	</div>
	<?php include 'scriptEnd.php'; ?>
</body>

</html>