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
				<div class="col_3">
					<div class="col-md-3 widget-shadow">
						<div class="r3_counter_box">
							<i class="pull-left fa fa-exclamation-triangle user1 icon-rounded"></i>
							<div class="stats">
								<?php
								$sql_index_widget_painel_nao_atendida = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_status`='não atendido'";
								$query_index_widget_painel_nao_atendida = mysqli_query($_SG['link'], $sql_index_widget_painel_nao_atendida);
								echo "<h5><strong>" . mysqli_num_rows($query_index_widget_painel_nao_atendida) . "</strong></h5>";
								?>
								<span>Não Atendidos</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 widget-shadow">
						<div class="r3_counter_box">
							<i class="pull-left fa fa-flag dollar1 icon-rounded"></i>
							<div class="stats">
								<?php
								$sql_index_widget_painel_encaminhado = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_status`='encaminhado'";
								$query_index_widget_painel_encaminhado = mysqli_query($_SG['link'], $sql_index_widget_painel_encaminhado);
								echo "<h5><strong>" . mysqli_num_rows($query_index_widget_painel_encaminhado) . "</strong></h5>";
								?>
								<span>Encaminhados</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 widget-shadow">
						<div class="r3_counter_box">
							<i class="pull-left fa fa-check-square-o user2 icon-rounded"></i>
							<div class="stats">
								<?php
								$sql_index_widget_painel_em_atendimento = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_status`='em atendimento'";
								$query_index_widget_painel_em_atendimento = mysqli_query($_SG['link'], $sql_index_widget_painel_em_atendimento);
								echo "<h5><strong>" . mysqli_num_rows($query_index_widget_painel_em_atendimento) . "</strong></h5>";
								?>
								<span>Atendimento</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 widget-shadow">
						<div class="r3_counter_box">
							<i class="pull-left fa fa-envelope dollar2 icon-rounded"></i>
							<div class="stats">
								<?php
								$sql_index_widget_painel_mail_aberto = "SELECT `mail_id` FROM `mails_tb` WHERE `mail_para_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') AND `mail_status_caixa_entrada`='1'";
								$query_index_widget_painel_mail_aberto = mysqli_query($_SG['link'], $sql_index_widget_painel_mail_aberto);
								echo "<h5><strong>" . mysqli_num_rows($query_index_widget_painel_mail_aberto) . "</strong></h5>";
								?>
								<span>Mail Aberto</span>
							</div>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
				<?php
				$sql_meu_hall = "SELECT `setor_hall` FROM `setores_tb` WHERE `setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
				$query_meu_hall = mysqli_query($_SG['link'], $sql_meu_hall);
				$row_meu_hall = mysqli_fetch_assoc($query_meu_hall);
				if ($row_meu_hall["setor_hall"] == "1") {
					?>
					<div class="tables">
						<div class="bs-example widget-shadow" data-example-id="hoverable-table">
							<h4>
								Painel Geral
								<button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#novaFichaModal">
									Nova Ficha
								</button>
							</h4>
							<!-- Modal -->
							<div class="modal fade" id="novaFichaModal" tabindex="-1" role="dialog" aria-labelledby="novaFichaModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="forms">
											<div class="form-grids row widget-shadow" data-example-id="basic-forms">
												<div class="form-title">
													<h4>Nova Ficha </h4>
												</div>
												<div class="form-body">
													<form target="_blank" action="imprimirFicha.php" method="POST">
														<div class="form-group">
															<label>Nome </label>
															<input name="ficha_nome" type="text" class="form-control" placeholder="Nome Completo" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
														</div>
														<div class="form-group">
															<label>Telefone</label>
															<input name="ficha_telefone" type="tel" class="form-control" value="" placeholder="(84) 00000-0000" required>
														</div>
														<div class="form-group">
															<label>Atendiemnto em</label>
															<select name="ficha_setor_id" class="form-control" type="text">
																<?php
																$sql_lista_setores = "SELECT `setor_id`, `setor_nome` FROM `setores_tb`";
																$query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
																while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
																	echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . '</option>';
																}
																?>
															</select>
														</div>
														<div class="checkbox">
															<label>
																<input name="ficha_preferencial" type="checkbox" class="checkbox" placeholder="Sala do Setor">
																Preferencial (idosos, gestantes e deficientes)
															</label>
														</div>
														<button type="submit" class="btn btn-success">Imprimir</button>
														<a href="/"><button type="button" class="btn btn-danger">Voltar</button></a>
													</form>
												</div>
											</div>
										</div>
										<div class="clearfix"> </div>
									</div>
								</div>
							</div>
							<!-- Fim Modal -->
							<table class="table table-hover">
								<thead>
									<tr>
										<th style="text-align: center;">#</th>
										<th style="text-align: center;">Nome</th>
										<th style="text-align: center;">Telefone</th>
										<th style="text-align: center;">Setor</th>
										<th style="text-align: center;">Status</th>
										<th style="text-align: center;">Data</th>
										<th style="text-align: center;">Preferencial</th>
										<th style="text-align: center;">Imprimir</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql_lista_fichas_geral = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`, `ficha_encaminhado_setor_id` FROM `fichas_tb` ORDER BY `ficha_id` DESC LIMIT 1000";
									$query_lista_fichas_geral = mysqli_query($_SG['link'], $sql_lista_fichas_geral);
									$cont_lista_fichas_geral = 0;
									while ($row_lista_fichas_geral = mysqli_fetch_assoc($query_lista_fichas_geral)) {
										echo '<tr>';
										$ultimos3id = substr($row_lista_fichas_geral["ficha_id"], -3);
										echo '<th scope="row" style="text-align: center;">' . str_pad($ultimos3id, 3, '0', STR_PAD_LEFT) . '</th>';
										echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_nome"] . '</td>';
										echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_telefone"] . '</td>';
										$sql_setor_painel = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_lista_fichas_geral["ficha_setor_id"] . "'";
										$query_setor_painel = mysqli_query($_SG['link'], $sql_setor_painel);
										$row_setor_painel = mysqli_fetch_assoc($query_setor_painel);
										echo '<td style="text-align: center;">' . $row_setor_painel["setor_nome"] . '</td>';
										if ($row_lista_fichas_geral["ficha_status"] == "não atendido") {
											echo '<td style="text-align: center;"><button type="button" class="btn btn-danger">Não atendido</button></td>';
										}
										if ($row_lista_fichas_geral["ficha_status"] == "encaminhado") {
											$sql_encaminhado_painel = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_lista_fichas_geral['ficha_encaminhado_setor_id'] . "'";
											$query_encaminhado_painel = mysqli_query($_SG['link'], $sql_encaminhado_painel);
											$row_encaminhado_painel = mysqli_fetch_assoc($query_encaminhado_painel);
											echo '<td style="text-align: center;"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="' . $row_encaminhado_painel["setor_nome"] . '" data-original-title="">Encaminhado</button></td>';
										}
										if ($row_lista_fichas_geral["ficha_status"] == "em atendimento") {
											echo '<td style="text-align: center;"><button type="button" class="btn btn-success">Em antendimento</button></td>';
										}
										if ($row_lista_fichas_geral["ficha_status"] == "atendido") {
											echo '<td style="text-align: center;"><button type="button" class="btn btn-info">Atendido</button></td>';
										}
										$data_quebrada = explode(" ", $row_lista_fichas_geral["ficha_data"]);
										$data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
										echo '<td style="text-align: center;">' . $data_final . " " . $data_quebrada[1] . '</td>';
										if ($row_lista_fichas_geral["ficha_preferencial"] == "1") {
											echo '<td style="text-align: center;"><span class="label label-warning">SIM</span></td>';
										} else {
											echo '<td style="text-align: center;"><span class="label label-success">NÃO</span></td>';
										}
										echo '<td style="text-align: center;"><a class="fa fa-print" href="imprimirFicha.php?fichaID=' . $row_lista_fichas_geral["ficha_id"] . '" target="_blank"></a></td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				<?php } ?>
				<div class="tool-tips widget-shadow">
					<h4 style="font-size: 1.4em; margin: 0 0 1em 0; color: #777777;">
						Painel do Setor:
						<a href=""><button type="button" class="btn btn-primary" style="float: right;">
								Chamar Próximo
							</button></a>
					</h4>
					<ul id="myTabs" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#naoAtendidos" id="naoAtendidos-tab" role="tab" data-toggle="tab" aria-controls="naoAtendidos" aria-expanded="true"><button type="button" class="btn btn-danger">Não
									atendido</button></a>
						</li>
						<li role="presentation" class=""><a href="#emAtendimento" id="emAtendimento-tab" role="tab" data-toggle="tab" aria-controls="emAtendimento" aria-expanded="false"><button type="button" class="btn btn-success">Em
									antendimento</button></a>
						</li>
						<li role="presentation" class=""><a href="#atendidos" id="atendidos-tab" role="tab" data-toggle="tab" aria-controls="atendidos" aria-expanded="fase"><button type="button" class="btn btn-info">Atendido</button></a>
						</li>
					</ul>
					<div id="myTabContent" class="tab-content scrollbar1">
						<div role="tabpanel" class="tab-pane fade active in" id="naoAtendidos" aria-labelledby="naoAtendidos-tab">
							<div class="tables">
								<div class="bs-example" data-example-id="hoverable-table">
									<table class="table table-hover">
										<thead>
											<tr>
												<th style="text-align: center;">#</th>
												<th style="text-align: center;">Nome</th>
												<th style="text-align: center;">Telefone</th>
												<th style="text-align: center;">Setor</th>
												<th style="text-align: center;">Status</th>
												<th style="text-align: center;">Data</th>
												<th style="text-align: center;">Preferencial</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="text-align: center;">1</th>
												<td style="text-align: center;">ALLAN DE MIRANDA</td>
												<td style="text-align: center;">(84)991151610</td>
												<td style="text-align: center;">R.H.</td>
												<td style="text-align: center;"><button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="SECRETARIA" data-original-title="">Encaminhado</button></td>
												<td style="text-align: center;">00/00/0000 00:00</td>
												<td style="text-align: center;"><span class="label label-warning">SIM</span></td>
											</tr>
											<tr>
												<th scope="row" style="text-align: center;">1</th>
												<td style="text-align: center;">ALLAN DE MIRANDA</td>
												<td style="text-align: center;">(84)991151610</td>
												<td style="text-align: center;">R.H.</td>
												<td style="text-align: center;"><button type="button" class="btn btn-danger">Não
														atendido</button></td>
												<td style="text-align: center;">00/00/0000 00:00</td>
												<td style="text-align: center;"><span class="label label-success">NÃO</span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="emAtendimento" aria-labelledby="emAtendimento-tab">
							<div class="tables">
								<div class="bs-example" data-example-id="hoverable-table">
									<table class="table table-hover">
										<thead>
											<tr>
												<th style="text-align: center;">#</th>
												<th style="text-align: center;">Nome</th>
												<th style="text-align: center;">Telefone</th>
												<th style="text-align: center;">Setor</th>
												<th style="text-align: center;">Status</th>
												<th style="text-align: center;">Data</th>
												<th style="text-align: center;">Preferencial</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="text-align: center;">1</th>
												<td style="text-align: center;">ALLAN DE MIRANDA</td>
												<td style="text-align: center;">(84)991151610</td>
												<td style="text-align: center;">R.H.</td>
												<td style="text-align: center;"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#emAtendimento1Modal">Em
														antendimento</button></td>
												<td style="text-align: center;">00/00/0000 00:00</td>
												<td style="text-align: center;"><span class="label label-success">NÃO</span></td>
											</tr>
											<tr>
												<th scope="row" style="text-align: center;">1</th>
												<td style="text-align: center;">ALLAN DE MIRANDA</td>
												<td style="text-align: center;">(84)991151610</td>
												<td style="text-align: center;">R.H.</td>
												<td style="text-align: center;"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#emAtendimento2Modal">Em
														antendimento</button></td>
												<td style="text-align: center;">00/00/0000 00:00</td>
												<td style="text-align: center;"><span class="label label-warning">SIM</span></td>
											</tr>
										</tbody>
										<!-- Modal -->
										<div class="modal fade" id="emAtendimento1Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="forms">
														<div class="form-grids row widget-shadow" data-example-id="basic-forms">
															<div class="form-title">
																<h4>Ficha </h4>
															</div>
															<div class="form-body">
																<form action="" method="">
																	<div class="form-group">
																		<label>Nome A </label>
																		<input name="setor_nome" type="text" class="form-control" placeholder="Nome Completo" onChange="javascript:this.value=this.value.toUpperCase();" value="" required disabled>
																	</div>
																	<div class="form-group">
																		<label>Telefone</label>
																		<input name="setor_sala" type="tel" class="form-control" value="" placeholder="(84) 00000-0000" required disabled>
																	</div>
																	<div class="form-group">
																		<label>Encaminhar para</label>
																		<select name="usuario_setor" class="form-control" type="text">
																			<option value="SETOR UM" selected>
																				SETOR UM</option>
																			<option value="SETOR DOIS">SETOR
																				DOIS</option>
																			<option value="SETOR TRÊS">SETOR
																				TRÊS</option>
																		</select>
																	</div>
																	<button type="submit" class="btn btn-warning">Encaminhar</button>
																	<a href=""><button type="button" class="btn btn-success">Finalizar</button></a>
																	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- Fim Modal -->
									</table>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="atendidos" aria-labelledby="atendidos-tab">
							<div class="tables">
								<div class="bs-example" data-example-id="hoverable-table">
									<table class="table table-hover">
										<thead>
											<tr>
												<th style="text-align: center;">#</th>
												<th style="text-align: center;">Nome</th>
												<th style="text-align: center;">Telefone</th>
												<th style="text-align: center;">Setor</th>
												<th style="text-align: center;">Status</th>
												<th style="text-align: center;">Data</th>
												<th style="text-align: center;">Preferencial</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="text-align: center;">1</th>
												<td style="text-align: center;">ALLAN DE MIRANDA</td>
												<td style="text-align: center;">(84)991151610</td>
												<td style="text-align: center;">R.H.</td>
												<td style="text-align: center;"><a href=""><button type="button" class="btn btn-info">Atendido</button></a></td>
												<td style="text-align: center;">00/00/0000 00:00</td>
												<td style="text-align: center;"><span class="label label-warning">SIM</span></td>
											</tr>
											<tr>
												<th scope="row" style="text-align: center;">1</th>
												<td style="text-align: center;">ALLAN DE MIRANDA</td>
												<td style="text-align: center;">(84)991151610</td>
												<td style="text-align: center;">R.H.</td>
												<td style="text-align: center;"><a href=""><button type="button" class="btn btn-info">Atendido</button></a></td>
												<td style="text-align: center;">00/00/0000 00:00</td>
												<td style="text-align: center;"><span class="label label-success">NÃO</span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
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