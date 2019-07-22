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

$perito = $numero_nic = $data_entrada = $cadaver_informacao = $data_fato = $procedencia_bairro = $procedencia_cidade = $procedencia_uf = $cadaver_situacao = $numero_guia = $causa_morte = $destino_exame = $numero_sei = $status_coleta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$perito = test_input($_SESSION['usuarioNome']);
	$numero_nic = test_input($_POST["numero_nic"]);
	$data_entrada = test_input($_POST["data_entrada"]);
	$cadaver_informacao = test_input($_POST["cadaver_informacao"]);
	$data_fato = test_input($_POST["data_fato"]);
	$procedencia_bairro = test_input($_POST["procedencia_bairro"]);
	$procedencia_cidade = test_input($_POST["procedencia_cidade"]);
	$procedencia_uf = test_input($_POST["procedencia_uf"]);
	$cadaver_situacao = test_input($_POST["cadaver_situacao"]);
	$numero_guia = test_input($_POST["numero_guia"]);
	$causa_morte = test_input($_POST["causa_morte"]);
	$destino_exame = test_input($_POST["destino_exame"]);
	$numero_sei = test_input($_POST["numero_sei"]);
	$status_coleta = test_input($_POST["status_coleta"]);
	$data_formulario = test_input(date("Y-m-d"));

	if ($status_coleta == "on") {
		$status_coleta = 1;
	} else {
		$status_coleta = 0;
	}

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

	$sql = "INSERT INTO `documentos`(`perito`, `numero_nic`, `data_entrada`, `cadaver_informacao`, `data_fato`, `procedencia_bairro`, `procedencia_cidade`, `procedencia_uf`, `cadaver_situacao`, `numero_guia`, `causa_morte`, `destino_exame`, `numero_sei`, `status_coleta`, `data_formulario`) VALUES ('" . $perito . "','" . $numero_nic . "','" . $data_entrada . "','" . $cadaver_informacao . "','" . $data_fato . "','" . $procedencia_bairro . "','" . $procedencia_cidade . "','" . $procedencia_uf . "','" . $cadaver_situacao . "','" . $numero_guia . "','" . $causa_morte . "','" . $destino_exame . "','" . $numero_sei . "','" . $status_coleta . "','" . $data_formulario . "')";
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
								$data_entrada_ex = explode("-", $data_entrada);
								$protocolo_ano = $data_entrada_ex[0];
								echo 'Sucesso! Documento <b>PROTOCOLO ' . str_pad(mysqli_insert_id($conn), 4, '0', STR_PAD_LEFT) . '/' . $protocolo_ano . '</b> adicionado.';
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
						<h2>Formulário de Registro</h2>
						<form action="novoRegistro.php" method="POST">
							<div class="clearfix"> </div>
							<div class="typo-buttons col-md-12 grid_4">
								<div class="col-md-12 well">
									<label class="col-md-4">Nº NIC </label>
									<input name="numero_nic" class="col-md-4" type="text" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Data de Entrada </label>
									<input name="data_entrada" class="col-md-2" type="date" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Informações Cadáver </label>
									<input name="cadaver_informacao" class="col-md-8" type="text" onChange="javascript:this.value=this.value.toUpperCase();" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Data do Fato </label>
									<input name="data_fato" class="col-md-2" type="date" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Procedente </label>
									<input name="procedencia_bairro" class="col-md-4" type="text" placeholder="Bairro ou Hospital" onChange="javascript:this.value=this.value.toUpperCase();" required>
									<input name="procedencia_cidade" class="col-md-3" type="text" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" required>
									<input name="procedencia_uf" class="col-md-1" type="text" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Situação do Cadáver </label>
									<input name="cadaver_situacao" class="col-md-8" type="text" onChange="javascript:this.value=this.value.toUpperCase();" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Nº da Guia de Solicitação </label>
									<input name="numero_guia" class="col-md-4" type="text" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Causa Morte </label>
									<input name="causa_morte" class="col-md-8" type="text" onChange="javascript:this.value=this.value.toUpperCase();" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Destino do Exame </label>
									<input name="destino_exame" class="col-md-8" type="text" onChange="javascript:this.value=this.value.toUpperCase();" required>
								</div>
								<div class="col-md-12 well">
									<label class="col-md-4">Protocolo SEI </label>
									<input name="numero_sei" class="col-md-4" type="text" onkeyup="this.value=this.value.replace(/[' ']/g,'')" required>
								</div>
								<div class="col-md-12 well">
									<input name="status_coleta" class="col-md-1" type="checkbox">
									<label class="col-md-11">Não apresenta condições de coleta de Impressões Digitais</label>
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