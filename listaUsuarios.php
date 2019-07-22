<!DOCTYPE HTML>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php
if ($_GET["editar"] != "") {
	$servername = $_SG['servidor'];
	$username = $_SG['usuario'];
	$password = $_SG['senha'];
	$dbname = $_SG['banco'];
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "UPDATE usuarios SET senha='123456' WHERE id=" . $_GET["editar"];
}
if ($_GET["excluir"] != "") {
	$servername = $_SG['servidor'];
	$username = $_SG['usuario'];
	$password = $_SG['senha'];
	$dbname = $_SG['banco'];
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "DELETE FROM `usuarios` WHERE id=" . $_GET['excluir'];
}
?>
<?php include 'head.php'; ?>

<body>
	<div class="page-container">
		<div class="left-content">
			<div class="mother-grid-inner">
				<?php include 'nav.php'; ?>
				<!--inner block start here-->
				<div class="inner-block">
					<?php
					if ($_GET["editar"] != "") {
						if (mysqli_query($conn, $sql)) {
							echo '<div class="alert alert-success alert-dismissable">';
							echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							echo 'Sucesso! Senha do usuário id ' . $_GET['editar'] . ' resetada.';
							echo '</div>';
						} else {
							echo '<div class="alert alert-danger alert-dismissable">';
							echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							echo '</div>';
						}
						mysqli_close($conn);
					}
					if ($_GET["excluir"] != "") {
						if (mysqli_query($conn, $sql)) {
							echo '<div class="alert alert-success alert-dismissable">';
							echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							echo 'Sucesso! Usuário id ' . $_GET['excluir'] . ' excluído.';
							echo '</div>';
						} else {
							echo '<div class="alert alert-danger alert-dismissable">';
							echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							echo '</div>';
						}
						mysqli_close($conn);
					}
					?>
					<div class="typography">
						<div class="col-md-12 chit-chat-layer1-left">
							<div class="work-progres">
								<div class="chit-chat-heading">
									Usuários do sistema
								</div>
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>#</th>
												<th>Nome</th>
												<th>Sobrenome</th>
												<th>Matrícula</th>
												<th>Usuário</th>
												<th>Senha</th>
												<th>Excluir</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$servername = $_SG['servidor'];
											$username = $_SG['usuario'];
											$password = $_SG['senha'];
											$dbname = $_SG['banco'];

											// Create connection
											$conn = mysqli_connect($servername, $username, $password, $dbname);
											// Check connection
											if (!$conn) {
												die("Connection failed: " . mysqli_connect_error());
											}

											$sql = "SELECT * FROM usuarios";
											$result = mysqli_query($conn, $sql);
											if (mysqli_num_rows($result) > 0) {
												// output data of each row
												while ($row = mysqli_fetch_assoc($result)) {
													echo "<tr>";
													echo "<td>" . $row["id"] . "</td>";
													echo "<td>" . $row["nome"] . "</td>";
													echo "<td>" . $row["sobre_nome"] . "</td>";
													echo "<td>" . $row["matricula"] . "</td>";
													echo "<td>" . $row["usuario"] . "</td>";
													if ($row["id"] == $_SESSION['usuarioID']) {
														echo '<td></td>';
														echo '<td></td>';
													} else {
														echo '<td><a href="?editar=' . $row["id"] . '"><i class="fa fa-edit"></a></td>';
														echo '<td><a href="?excluir=' . $row["id"] . '"><i class="fa fa-remove"></a></td>';
													}
													echo "</tr>";
												}
											} else {
												echo "0 results";
											}

											mysqli_close($conn);
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<!--inner block end here-->
				<?php include 'footer.php'; ?>
			</div>
		</div>
		<?php include 'menu.php'; ?>
		<div class="clearfix"> </div>
	</div>
	<!--slide bar menu end here-->

</body>

</html>