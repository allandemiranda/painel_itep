<!DOCTYPE HTML>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$nome = $sobreNome = $matricula = $cargo = $usuario = $senha = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nome = test_input($_POST["nome"]);
	$sobreNome = test_input($_POST["sobre_nome"]);
	$matricula = test_input($_POST["matricula"]);
	$cargo = test_input($_POST["cargo"]);
	$usuario = test_input($_POST["usuario"]);
	$senha = test_input($_POST["senha"]);

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

	$sql = "INSERT INTO usuarios (nome, sobre_nome, matricula, cargo, usuario, senha) VALUES ('" . $nome . "', '" . $sobreNome . "', '" . $matricula . "', '" . $cargo . "', '" . $usuario . "', '" . $senha . "')";
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
					<div class="typography">
						<?php
						if ($_SERVER["REQUEST_METHOD"] == "POST") {
							if (mysqli_query($conn, $sql)) {
								echo '<div class="alert alert-success alert-dismissable">';
								echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
								echo 'Sucesso! Usuário ' . $nome . ' adicionado.';
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
						<h2>Novo Usuário</h2>
						<form action="novoUsuario.php" method="POST">
							<div class="clearfix"> </div>
							<div class="typo-buttons col-md-12 grid_4">
								<div class="col-md-12 well">
									<label class="col-md-4">Dados </label>
									<input name="nome" class="col-md-3" type="text" placeholder="Nome" maxlength="100" onChange="javascript:this.value=this.value.toUpperCase();" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
									<input name="sobre_nome" class="col-md-5" type="text" placeholder="Sobrenome" maxlength="100" onChange="javascript:this.value=this.value.toUpperCase();" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Matrícula </label>
									<input name="matricula" class="col-md-3" type="text" maxlength="50" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Cargo </label>
									<input name="cargo" class="col-md-8" type="text" maxlength="50" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Usuário </label>
									<input name="usuario" class="col-md-3" type="text" maxlength="50" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Senha </label>
									<input name="senha" class="col-md-3" type="password" maxlength="50" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
								</div>
								<div class="grid1">
									<button type="submit" class="btn btn-1 btn-success">Criar</button>
									<a href="/"><button type="button" class="btn btn-1 btn-danger">Cancelar</button></a>
								</div>
							</div>
						</form>
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