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
								<div class="chit-chat-heading">
									Documentos Registrados
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

											$sql = "SELECT * FROM documentos ORDER BY id DESC";
											$result = mysqli_query($conn, $sql);
											$total_pages = mysqli_num_rows($result);
											$cont_page = 0;
											if ($_GET["page"] == "") {
												$cont_page = 1;
											} else {
												$cont_page = $_GET["page"];
											}
											if($_GET["pageDoc"] != ""){
												$cont_page = $total_pages - $_GET["pageDoc"];
											}
											$num_rows = 0;											
											if (mysqli_num_rows($result) > 0) {
												// output data of each row
												while ($row = mysqli_fetch_assoc($result)) {
													$num_rows++;
													if ($num_rows < $cont_page) {
														continue;
													}
													if ($num_rows >= ($cont_page + 100)) {
														break;
													}
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
												// echo "0 results";
											}

											mysqli_close($conn);
											?>
										</tbody>
									</table>
									<div class="btn-group">
										<?php
										$proximo = $anterior = 1;
										if (($cont_page + 100) > $total_pages) {
											$proximo = 0;
										}
										if (($cont_page - 100) <= 0) {
											$anterior = 0;
										}
										if ($anterior == 0) {
											echo '<a href="listaDocumentos.php?page=' . 0 . '" class="btn btn-default"><i class="fa fa-angle-left"></i></a>';
										} else {
											echo '<a href="listaDocumentos.php?page=' . ($cont_page - 100) . '" class="btn btn-default"><i class="fa fa-angle-left"></i></a>';
										}
										if ($proximo == 0) {
											echo '<a href="listaDocumentos.php?page=' . $total_pages . '" class="btn btn-default"><i class="fa fa-angle-right"></i></a>';
										} else {
											echo '<a href="listaDocumentos.php?page=' . ($cont_page + 100) . '" class="btn btn-default"><i class="fa fa-angle-right"></i></a>';
										}
										?>
									</div>
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