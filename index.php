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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["submit"] == "encaminhar") {
		$ficha_id = test_input($_POST["ficha_id"]);
		$ficha_setor_id = test_input($_POST["ficha_setor_id"]);

		$ficha_data = date('Y-m-d H:i:s');

		$sql_atualizar_ficha = "UPDATE `fichas_tb` SET `ficha_status`='encaminhado',`ficha_data`='" . $ficha_data . "',`ficha_encaminhado_setor_id`='" . $ficha_setor_id . "' WHERE `ficha_id`='" . $ficha_id . "'";

		if (mysqli_query($_SG['link'], $sql_atualizar_ficha)) {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha emcaminhada.';
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		} else {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		}
	}

	if ($_POST["submit"] == "finalizar") {
		$ficha_id = test_input($_POST["ficha_id"]);

		$sql_atualizar_ficha = "UPDATE `fichas_tb` SET `ficha_status`='atendido' WHERE `ficha_id`='" . $ficha_id . "'";

		if (mysqli_query($_SG['link'], $sql_atualizar_ficha)) {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha finalizada.';
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		} else {
			$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
			$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
			$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
			$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
		}
	}

	if ($_POST["submit"] == "chamarProximo") {
		$sql_chamar_proximo_um = "SELECT `ficha_preferencial` FROM `fichas_tb` WHERE `ficha_status`='não atendido' AND `ficha_status`='encaminhado' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') LIMIT 1 ";
		$query_chamar_proximo_um =  mysqli_query($_SG['link'], $sql_chamar_proximo_um);
		if (mysqli_num_rows($query_chamar_proximo_um) > 0) {
			$row_chamar_proximo_um = mysqli_fetch_assoc($query_chamar_proximo_um);
			if ($row_chamar_proximo_um["ficha_preferencial"] == 0) {
				$sql_chamar_proximo_dois = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_preferencial`='1' AND `ficha_status`='não atendido' AND `ficha_status`='encaminhado' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` ASC LIMIT 1 ";
				$query_chamar_proximo_dois =  mysqli_query($_SG['link'], $sql_chamar_proximo_dois);
				if (mysqli_num_rows($query_chamar_proximo_dois) > 0) {
					$row_chamar_proximo_dois = mysqli_fetch_assoc($query_chamar_proximo_dois);
					$sql_update_proxima_dois = "UPDATE `fichas_tb` SET `ficha_status`='em atendimento' WHERE `ficha_id`='" . $row_chamar_proximo_dois['ficha_id'] . "'";
					if (mysqli_query($_SG['link'], $sql_update_proxima_dois)) {
						$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
						$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
						$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha <b>' . $row_chamar_proximo_dois['ficha_id'] . '</b> em antendimento.';
						$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
					} else {
						$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
						$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
						$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
						$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
					}
				} else {
					$sql_chamar_proximo_dois = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_preferencial`='0' AND `ficha_status`='não atendido' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` ASC LIMIT 1 ";
					$query_chamar_proximo_dois =  mysqli_query($_SG['link'], $sql_chamar_proximo_dois);
					if (mysqli_num_rows($query_chamar_proximo_dois) > 0) {
						$row_chamar_proximo_dois = mysqli_fetch_assoc($query_chamar_proximo_dois);
						$sql_update_proxima_dois = "UPDATE `fichas_tb` SET `ficha_status`='em atendimento' WHERE `ficha_id`='" . $row_chamar_proximo_dois['ficha_id'] . "'";
						if (mysqli_query($_SG['link'], $sql_update_proxima_dois)) {
							$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
							$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha <b>' . $row_chamar_proximo_dois['ficha_id'] . '</b> em antendimento.';
							$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
						} else {
							$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
							$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
							$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
						}
					} else {
						$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
						$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
						$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
						$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
					}
				}
			}
		} else {
			$sql_chamar_proximo_um = "SELECT `ficha_preferencial` FROM `fichas_tb` WHERE `ficha_status`='atendido' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') LIMIT 1 ";
			$query_chamar_proximo_um =  mysqli_query($_SG['link'], $sql_chamar_proximo_um);
			$row_chamar_proximo_um = mysqli_fetch_assoc($query_chamar_proximo_um);
			if ($row_chamar_proximo_um["ficha_preferencial"] == 0) {
				$sql_chamar_proximo_dois = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_preferencial`='1' AND `ficha_status`='atendido' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` ASC LIMIT 1 ";
				$query_chamar_proximo_dois =  mysqli_query($_SG['link'], $sql_chamar_proximo_dois);
				if (mysqli_num_rows($query_chamar_proximo_dois) > 0) {
					$row_chamar_proximo_dois = mysqli_fetch_assoc($query_chamar_proximo_dois);
					$sql_update_proxima_dois = "UPDATE `fichas_tb` SET `ficha_status`='em atendimento' WHERE `ficha_id`='" . $row_chamar_proximo_dois['ficha_id'] . "'";
					if (mysqli_query($_SG['link'], $sql_update_proxima_dois)) {
						$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
						$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
						$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha <b>' . $row_chamar_proximo_dois['ficha_id'] . '</b> em antendimento.';
						$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
					} else {
						$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
						$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
						$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
						$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
					}
				} else {
					$sql_chamar_proximo_dois = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_preferencial`='0' AND `ficha_status`='atendido' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` ASC LIMIT 1 ";
					$query_chamar_proximo_dois =  mysqli_query($_SG['link'], $sql_chamar_proximo_dois);
					if (mysqli_num_rows($query_chamar_proximo_dois) > 0) {
						$row_chamar_proximo_dois = mysqli_fetch_assoc($query_chamar_proximo_dois);
						$sql_update_proxima_dois = "UPDATE `fichas_tb` SET `ficha_status`='em atendimento' WHERE `ficha_id`='" . $row_chamar_proximo_dois['ficha_id'] . "'";
						if (mysqli_query($_SG['link'], $sql_update_proxima_dois)) {
							$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
							$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha <b>' . $row_chamar_proximo_dois['ficha_id'] . '</b> em antendimento.';
							$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
						} else {
							$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
							$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
							$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
							$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
						}
					} else {
						$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
						$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
						$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
						$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
					}
				}
			}
		}
	}
}

if ($_GET["submit"] == "naoAtendido") {
	$ficha_id = test_input($_GET["ficha_id"]);

	$sql_atualizar_ficha = "UPDATE `fichas_tb` SET `ficha_status`='em atendimento' WHERE `ficha_id`='" . $ficha_id . "'";

	if (mysqli_query($_SG['link'], $sql_atualizar_ficha)) {
		$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
		$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
		$_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Ficha em antendimento.';
		$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
	} else {
		$_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
		$_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
		$_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
		$_SG['status-alert'] = $_SG['status-alert'] . '</div>';
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
				<div class="col_3">
					<div class="col-md-3 widget-shadow">
						<div class="r3_counter_box">
							<i class="pull-left fa fa-exclamation-triangle user1 icon-rounded"></i>
							<div class="stats">
								<?php
								$sql_index_widget_painel_nao_atendida = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_status`='não atendido' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
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
								$sql_index_widget_painel_encaminhado = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_status`='encaminhado' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
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
								$sql_index_widget_painel_em_atendimento = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_status`='em atendimento' AND `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
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
															<label>Atendimento em</label>
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
				<?php } else { ?>
					<div class="tool-tips widget-shadow">
						<h4 style="font-size: 1.4em; margin: 0 0 1em 0; color: #777777;">
							Painel do Setor:
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
								<button name="submit" value="chamarProximo" type="submit" class="btn btn-primary" style="float: right;">
									Chamar Próximo
								</button>
							</form>
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
													<th style="text-align: center;">Status</th>
													<th style="text-align: center;">Data</th>
													<th style="text-align: center;">Preferencial</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql_lista_fichas_geral = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`, `ficha_encaminhado_setor_id` FROM `fichas_tb` WHERE `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` DESC";
												$query_lista_fichas_geral = mysqli_query($_SG['link'], $sql_lista_fichas_geral);
												$cont_lista_fichas_geral = 0;
												while ($row_lista_fichas_geral = mysqli_fetch_assoc($query_lista_fichas_geral)) {
													if (($row_lista_fichas_geral["ficha_status"] == "não atendido") or ($row_lista_fichas_geral["ficha_status"] == "encaminhado")) {
														echo '<tr>';
														$ultimos3id = substr($row_lista_fichas_geral["ficha_id"], -3);
														echo '<th scope="row" style="text-align: center;">' . str_pad($ultimos3id, 3, '0', STR_PAD_LEFT) . '</th>';
														echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_nome"] . '</td>';
														echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_telefone"] . '</td>';
														if ($row_lista_fichas_geral["ficha_status"] == "não atendido") {
															echo '<td style="text-align: center;"><form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET"><input name="ficha_id" value="' . $row_lista_fichas_geral["ficha_id"] . '" hidden><button type="submit" name="submit" value="naoAtendido" class="btn btn-danger">Não atendido</button></form></td>';
														}
														if ($row_lista_fichas_geral["ficha_status"] == "encaminhado") {
															$sql_encaminhado_painel = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_lista_fichas_geral['ficha_encaminhado_setor_id'] . "'";
															$query_encaminhado_painel = mysqli_query($_SG['link'], $sql_encaminhado_painel);
															$row_encaminhado_painel = mysqli_fetch_assoc($query_encaminhado_painel);
															echo '<td style="text-align: center;"><form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET"><input name="ficha_id" value="' . $row_lista_fichas_geral["ficha_id"] . '" hidden><button type="submit" name="submit" value="naoAtendido" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="' . $row_encaminhado_painel["setor_nome"] . '" data-original-title="">Encaminhado</button></form></td>';
														}
														$data_quebrada = explode(" ", $row_lista_fichas_geral["ficha_data"]);
														$data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
														echo '<td style="text-align: center;">' . $data_final . " " . $data_quebrada[1] . '</td>';
														if ($row_lista_fichas_geral["ficha_preferencial"] == "1") {
															echo '<td style="text-align: center;"><span class="label label-warning">SIM</span></td>';
														} else {
															echo '<td style="text-align: center;"><span class="label label-success">NÃO</span></td>';
														}
														echo '</tr>';
													}
												}
												?>
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
													<th style="text-align: center;">Status</th>
													<th style="text-align: center;">Data</th>
													<th style="text-align: center;">Preferencial</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql_lista_fichas_geral = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`, `ficha_encaminhado_setor_id` FROM `fichas_tb` WHERE `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` DESC";
												$query_lista_fichas_geral = mysqli_query($_SG['link'], $sql_lista_fichas_geral);
												$cont_lista_fichas_geral = 0;
												while ($row_lista_fichas_geral = mysqli_fetch_assoc($query_lista_fichas_geral)) {
													if (($row_lista_fichas_geral["ficha_status"] == "em atendimento")) {
														echo '<tr>';
														$ultimos3id = substr($row_lista_fichas_geral["ficha_id"], -3);
														echo '<th scope="row" style="text-align: center;">' . str_pad($ultimos3id, 3, '0', STR_PAD_LEFT) . '</th>';
														echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_nome"] . '</td>';
														echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_telefone"] . '</td>';
														echo '<td style="text-align: center;"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#emAtendimento' . $row_lista_fichas_geral["ficha_id"] . '">Em antendimento</button></td>';
														$data_quebrada = explode(" ", $row_lista_fichas_geral["ficha_data"]);
														$data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
														echo '<td style="text-align: center;">' . $data_final . " " . $data_quebrada[1] . '</td>';
														if ($row_lista_fichas_geral["ficha_preferencial"] == "1") {
															echo '<td style="text-align: center;"><span class="label label-warning">SIM</span></td>';
														} else {
															echo '<td style="text-align: center;"><span class="label label-success">NÃO</span></td>';
														}
														echo '</tr>';
													}
												}
												?>
											</tbody>
											<!-- Modal -->
											<?php
											$sql_lista_fichas_geral = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`, `ficha_encaminhado_setor_id` FROM `fichas_tb` WHERE `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` DESC";
											$query_lista_fichas_geral = mysqli_query($_SG['link'], $sql_lista_fichas_geral);
											$cont_lista_fichas_geral = 0;
											while ($row_lista_fichas_geral = mysqli_fetch_assoc($query_lista_fichas_geral)) {
												if (($row_lista_fichas_geral["ficha_status"] == "em atendimento")) {
													echo '<div class="modal fade" id="emAtendimento' . $row_lista_fichas_geral["ficha_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
													echo '<div class="modal-dialog" role="document">';
													echo '<div class="modal-content">';
													echo '<div class="forms">';
													echo '<div class="form-grids row widget-shadow" data-example-id="basic-forms">';
													echo '<div class="form-title">';
													echo '<h4>Ficha </h4>';
													echo '</div>';
													echo '<div class="form-body">';
													echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST">';
													echo '<div class="form-group">';
													echo '<label>Nome </label>';
													echo '<input name="ficha_nome" type="text" class="form-control" value="' . $row_lista_fichas_geral["ficha_nome"] . '" disabled>';
													echo '</div>';
													echo '<div class="form-group">';
													echo '<label>Telefone</label>';
													echo '<input name="ficha_telefone" type="tel" class="form-control" value="' . $row_lista_fichas_geral["ficha_telefone"] . '" disabled>';
													echo '</div>';
													echo '<div class="form-group">';
													echo '<label>Atendimento em</label>';
													echo '<select name="ficha_setor_id" class="form-control" type="text">';
													$sql_lista_setores = "SELECT `setor_id`, `setor_nome` FROM `setores_tb`";
													$query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
													while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
														if ($row_lista_setores["setor_id"] == $row_lista_fichas_geral["ficha_setor_id"]) {
															echo '<option value="' . $row_lista_setores["setor_id"] . '" selected>' . $row_lista_setores["setor_nome"] . '</option>';
														} else {
															echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . '</option>';
														}
													}
													echo '</select>';
													echo '</div>';
													echo '<input type="" name="ficha_id" value="' . $row_lista_fichas_geral["ficha_id"] . '" hidden>';
													echo '<button type="submit" name="submit" value="encaminhar" class="btn btn-warning">Encaminhar</button>';
													echo '<button type="submit" name="submit" value="finalizar" class="btn btn-success">Finalizar</button>';
													echo '<a href="/"><button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button></a>';
													echo '</form>';
													echo '</div>';
													echo '</div>';
													echo '</div>';
													echo '</div>';
													echo '</div>';
													echo '</div>';
												}
											}
											?>
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
													<th style="text-align: center;">Status</th>
													<th style="text-align: center;">Data</th>
													<th style="text-align: center;">Preferencial</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql_lista_fichas_geral = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`, `ficha_encaminhado_setor_id` FROM `fichas_tb` WHERE `ficha_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `ficha_data` DESC LIMIT 500";
												$query_lista_fichas_geral = mysqli_query($_SG['link'], $sql_lista_fichas_geral);
												$cont_lista_fichas_geral = 0;
												while ($row_lista_fichas_geral = mysqli_fetch_assoc($query_lista_fichas_geral)) {
													if (($row_lista_fichas_geral["ficha_status"] == "atendido")) {
														echo '<tr>';
														$ultimos3id = substr($row_lista_fichas_geral["ficha_id"], -3);
														echo '<th scope="row" style="text-align: center;">' . str_pad($ultimos3id, 3, '0', STR_PAD_LEFT) . '</th>';
														echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_nome"] . '</td>';
														echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_telefone"] . '</td>';
														echo '<td style="text-align: center;"><button type="button" class="btn btn-info">Atendido</button></td>';
														$data_quebrada = explode(" ", $row_lista_fichas_geral["ficha_data"]);
														$data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
														echo '<td style="text-align: center;">' . $data_final . " " . $data_quebrada[1] . '</td>';
														if ($row_lista_fichas_geral["ficha_preferencial"] == "1") {
															echo '<td style="text-align: center;"><span class="label label-warning">SIM</span></td>';
														} else {
															echo '<td style="text-align: center;"><span class="label label-success">NÃO</span></td>';
														}
														echo '</tr>';
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
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