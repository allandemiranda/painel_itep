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
					<div class="market-updates">
						<div class="col-md-4 market-update-gd">
							<div class="market-update-block clr-block-1">
								<div class="col-md-8 market-update-left">
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

									$sql = "SELECT id FROM documentos";
									$result = mysqli_query($conn, $sql);

									?>
									<h3>
										<?php
										echo mysqli_num_rows($result);
										mysqli_close($conn);
										?>
									</h3>
									<h4>Doc. Registrados</h4>
									<p>Emiditos por este setor</p>
								</div>
								<div class="col-md-4 market-update-right">
									<i class="fa fa-file-text-o"> </i>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div class="col-md-4 market-update-gd">
							<div class="market-update-block clr-block-2">
								<div class="col-md-8 market-update-left">
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

									$sql = "SELECT id FROM documentos WHERE perito='" . $_SESSION['usuarioNome'] . "'";
									$result = mysqli_query($conn, $sql);

									?>
									<h3>
										<?php
										echo mysqli_num_rows($result);
										mysqli_close($conn);
										?>
									</h3>
									<h4>Doc. Registrados</h4>
									<p>Emitidos por <?php echo $_SESSION['usuarioNome']; ?></p>
								</div>
								<div class="col-md-4 market-update-right">
									<i class="fa fa-eye"> </i>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div class="col-md-4 market-update-gd">
							<div class="market-update-block clr-block-3">
								<div class="col-md-8 market-update-left">
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

									$sql = "SELECT id FROM usuarios";
									$result = mysqli_query($conn, $sql);

									?>
									<h3>
										<?php
										echo mysqli_num_rows($result);
										mysqli_close($conn);
										?>
									</h3>
									<h4>Usuários</h4>
									<p>Membros do setor</p>
								</div>
								<div class="col-md-4 market-update-right">
									<i class="fa fa-user"> </i>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
					<!--market updates end here-->
					<!--mainpage chit-chating-->
					<div class="chit-chat-layer1">
						<div class="col-md-12 chit-chat-layer1-left">
							<div class="work-progres">
								<div class="chit-chat-heading">
									Entradas Recentes
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
											$sql = "SELECT * FROM documentos WHERE perito='" . $_SESSION['usuarioNome'] . "' ORDER BY id DESC";
											$result = mysqli_query($conn, $sql);
											$cont_index = 1;
											if (mysqli_num_rows($result) > 0) {
												// output data of each row
												while ($row = mysqli_fetch_assoc($result)) {
													if ($cont_index == 11) {
														break;
													} else {
														$cont_index++;
													}
													echo "<tr>";
													$data_entrada_ex = explode("-", $row["data_entrada"]);
													echo "<td><a href='perfilDocumento.php?protocolo=".$row["id"]."'>" . str_pad($row["id"], 4, '0', STR_PAD_LEFT) . "/" . $data_entrada_ex[0] . "</a></td>";
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
												// echo "0 results";
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