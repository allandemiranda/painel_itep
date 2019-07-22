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
					<div class="typography">
						<div class="col-md-12 chit-chat-layer1-left">
							<div class="work-progres">
								<div class="container-fluid">
									<?php
									if ($_GET["pesquisa"] == "") {
										echo '<form action="pesquisaDocumentos.php" method="POST">';
										echo '<div class="clearfix"> </div>';
										echo '<div class="typo-buttons col-md-12 grid_4">';
										echo '<div class="col-md-12 well">';
										echo '<label class="col-md-4">Data Inicial </label>';
										echo '<input name="protocoloPesquisa" class="col-md-4" type="text" placeholder="Protocolo" required>';
										echo '<input name="anoPesquisa" class="col-md-2" type="text" placeholder="Ano" required>';
										echo '</div>';
										echo '<div class="grid1">';
										echo '<button type="submit" class="btn btn-1 btn-success">Pesquisar por Protocolo</button>';
										echo '</div>';
										echo '<br>';
										echo '</form>';
										echo '<form action="pesquisaDocumentos.php" method="POST">';
										echo '<div class="col-md-12 well">';
										echo '<label class="col-md-4">Data Inicial </label>';
										echo '<input name="dataInicial" class="col-md-3" type="date" required>';
										echo '</div>';
										echo '<div class="col-md-12 well">';
										echo '<label class="col-md-4">Data Final </label>';
										echo '<input name="dataFinal" class="col-md-3" type="date" required>';
										echo '</div>';
										echo '<div class="grid1">';
										echo '<button type="submit" class="btn btn-1 btn-success">Pesquisar por data</button>';
										echo '</div>';
										echo '</div>';
										echo '</form>';
									}
									?>
								</div>
								<div class="chit-chat-heading">
									Documentos Pesquisados
								</div>
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Nº</th>
												<th>Nome</th>
												<th>Entrada</th>
												<th>Status</th>
												<th>Data Doc.</th>
												<th>Papiloscopista</th>
												<th>Imprimir</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (($_POST["protocoloPesquisa"] != "") or ($_POST["dataInicial"] != "")) {
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

												if ($_POST["dataInicial"] != "") {
													$sql = "SELECT * FROM documentos WHERE `data_entrada` BETWEEN '" . $_POST["dataInicial"] . "' AND '" . $_POST["dataFinal"] . "' ORDER BY id DESC";
												} else {
													if ($_POST["protocoloPesquisa"] != "") {
														$sql = "SELECT * FROM `documentos` WHERE `id`=" . $_POST["protocoloPesquisa"] . "";
													} else {
														$sql = "SELECT * FROM documentos ORDER BY id DESC";
													}
												}

												$result = mysqli_query($conn, $sql);

												if (mysqli_num_rows($result) > 0) {
													echo '<div class="alert alert-success alert-dismissable">';
													echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
													echo 'Sucesso! ' . mysqli_num_rows($result) . ' resultados encontrado.';
													echo '</div>';
													// output data of each row
													while ($row = mysqli_fetch_assoc($result)) {
														echo "<tr>";
														$data_entrada_ex = explode("-", $row["data_entrada"]);
														echo "<td><a href='perfilDocumento.php?protocolo=" . $row["id"] . "'>" . str_pad($row["id"], 4, '0', STR_PAD_LEFT) . "/" . $data_entrada_ex[0] . "</a></td>";
														if ($row["nome_completo"] == "") {
															echo "<td> - </td>";
														} else {
															echo "<td>" . $row["nome_completo"] . "</td>";
														}
														echo "<td>" . $data_entrada_ex[2] . "/" . $data_entrada_ex[1] . "/" . $data_entrada_ex[0] . "</td>";

														if ($row["status_coleta"] == 1) {
															echo '<td><span class="label label-danger">Sem Condiçoes de Coleta</span></td>';
															$data_entrada_ex = explode("-", $row["data_formulario"]);
															echo '<td>' . $data_entrada_ex[2] . "/" . $data_entrada_ex[1] . "/" . $data_entrada_ex[0] . '</td>';
															echo "<td>" . $row["perito"] . "</td>";
															echo '<td><a href="parecerInformativo.php?protocolo=' . $row["id"] . '" target="_blank"><i class="fa fa-print"></i></a></td>';
														} else {
															if ($row["nome_completo"] == "") {
																echo '<td><a href="adicionarIdentificacao.php?protocolo=' . $row["id"] . '" <span class="label label-warning">Sem Identificação</span></a></td>';
																$data_entrada_ex = explode("-", $row["data_formulario"]);
																echo '<td>' . $data_entrada_ex[2] . "/" . $data_entrada_ex[1] . "/" . $data_entrada_ex[0] . '</td>';
																echo "<td>" . $row["perito"] . "</td>";
																echo '<td><a href="parecerNegativo.php?protocolo=' . $row["id"] . '" target="_blank"><i class="fa fa-print"></i></a></td>';
															} else {
																echo '<td><span class="label label-success">Identificado</span></td>';
																$data_entrada_ex = explode("-", $row["data_formulario"]);
																echo '<td>' . $data_entrada_ex[2] . "/" . $data_entrada_ex[1] . "/" . $data_entrada_ex[0] . '</td>';
																echo "<td>" . $row["perito"] . "</td>";
																echo '<td><a href="parecerPositivo.php?protocolo=' . $row["id"] . '" target="_blank"><i class="fa fa-print"></i></a></td>';
															}
														}
														echo "</tr>";
													}
												} else {
													echo '<div class="alert alert-danger alert-dismissable">';
													echo '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
													echo 'Nenhum resultado encontrado.';
													echo '</div>';
												}
												mysqli_close($conn);
											}
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