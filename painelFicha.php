<?php
include("segurancaOff.php");
?>
<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
</head>

<body class="">
    <div class="main-content">
        <!-- main content start-->
        <div id="page-wrapper">
            <div class="tables">
                <a href="painelFicha.php" class="hvr-icon-spin" style="float: right;">Atualizar página</a>
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
                                                        $sql_lista_setores = "SELECT `setor_id`, `setor_nome`, `setor_sala` FROM `setores_tb` ORDER BY `setor_nome` ASC";
                                                        $query_lista_setores = mysqli_query($conn, $sql_lista_setores);
                                                        while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                                            echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . ' (' . $row_lista_setores["setor_sala"] . ')</option>';
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
                                                <a href="painelFicha.php"><button type="button" class="btn btn-danger">Voltar</button></a>
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
                            $query_lista_fichas_geral = mysqli_query($conn, $sql_lista_fichas_geral);
                            $cont_lista_fichas_geral = 0;
                            while ($row_lista_fichas_geral = mysqli_fetch_assoc($query_lista_fichas_geral)) {
                                echo '<tr>';
                                $ultimos3id = substr($row_lista_fichas_geral["ficha_id"], -3);
                                echo '<th scope="row" style="text-align: center;">' . str_pad($ultimos3id, 3, '0', STR_PAD_LEFT) . '</th>';
                                echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_nome"] . '</td>';
                                echo '<td style="text-align: center;">' . $row_lista_fichas_geral["ficha_telefone"] . '</td>';
                                $sql_setor_painel = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_lista_fichas_geral["ficha_setor_id"] . "'";
                                $query_setor_painel = mysqli_query($conn, $sql_setor_painel);
                                $row_setor_painel = mysqli_fetch_assoc($query_setor_painel);
                                echo '<td style="text-align: center;">' . $row_setor_painel["setor_nome"] . '</td>';
                                if ($row_lista_fichas_geral["ficha_status"] == "não atendido") {
                                    echo '<td style="text-align: center;"><button type="button" class="btn btn-danger">Não atendido</button></td>';
                                }
                                if ($row_lista_fichas_geral["ficha_status"] == "encaminhado") {
                                    $sql_encaminhado_painel = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_lista_fichas_geral['ficha_encaminhado_setor_id'] . "'";
                                    $query_encaminhado_painel = mysqli_query($conn, $sql_encaminhado_painel);
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
        </div>
        <!--footer-->
        <?php include 'footer.php'; ?>
        <!--//footer-->
    </div>
    <?php include 'scriptEnd.php'; ?>
</body>

</html>