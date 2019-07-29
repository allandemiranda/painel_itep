<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php
function peritoAbreviado($nomePertito)
{
    $explode_perito = explode(" ", $nomePertito);
    return $explode_perito[0] . " " . end($explode_perito);
}
function corrigirDataCompleta($dataCompleta)
{
    $explode_data_completa = explode(" ", $dataCompleta);
    $explode_data = explode("-", $explode_data_completa[0]);
    return $explode_data[2] . "/" . $explode_data[1] . "/" . $explode_data[0] . " " . $explode_data_completa[1];
}
function corrigirData($data)
{
    $explode_data = explode("-", $data);
    return $explode_data[2] . "/" . $explode_data[1] . "/" . $explode_data[0];
}
function montarDivStatus($protocolo)
{
    global $_SG;
    $sql = "SELECT `necropapiloscopia_coleta_check`, `necropapiloscopia_nome` FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $protocolo . "'";
    $query = mysqli_query($_SG['link'], $sql);
    $row = mysqli_fetch_assoc($query);
    if ($row["necropapiloscopia_coleta_check"]) {
        return '<span class="label label-warning"><b>Sem Condiçoes de Coleta</b></span>';
    } else {
        if ($row["necropapiloscopia_nome"] != "") {
            return '<span class="label label-success"><b>Identificado</b></span>';
        } else {
            if (verificarSetorNecropapiloscopia()) {
                return '<button type="submit" class="label label-danger" name="necropapiloscopia_protocolo" value="' . $protocolo . '"><b>Não Identificado</b></button>';
            } else {
                return '<span class="label label-danger"><b>Não Identificado</b></span>';
            }
        }
    }
}
function montarDivImpressora($protocolo)
{
    global $_SG;
    $sql = "SELECT `necropapiloscopia_coleta_check`, `necropapiloscopia_nome` FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $protocolo . "'";
    $query = mysqli_query($_SG['link'], $sql);
    $row = mysqli_fetch_assoc($query);
    if ($row["necropapiloscopia_coleta_check"]) {
        return '<a target="_blank" href="necropapiloscopiaParecerInformativo.php?necropapiloscopia_protocolo=' . $protocolo . '"><i class="glyphicon glyphicon-print"></a>';
    } else {
        if ($row["necropapiloscopia_nome"] == "") {
            return '<a target="_blank" href="necropapiloscopiaParecerNegativo.php?necropapiloscopia_protocolo=' . $protocolo . '"><i class="glyphicon glyphicon-print"></a>';
        } else {
            return '<a target="_blank" href="necropapiloscopiaParecerPositivo.php?necropapiloscopia_protocolo=' . $protocolo . '"><i class="glyphicon glyphicon-print"></a>';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["delete"] != "") {
        $sql_deletar = "DELETE FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $_GET["delete"] . "'";
        if (mysqli_query($_SG['link'], $sql_deletar)) {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Protocolo <b>' . $_GET["delete"] . '</b> deletado.';
            $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
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
                        <h4>Lista Documentos</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">#</th>
                                    <th style="text-align: center;">NIC</th>
                                    <th style="text-align: center;">Nome</th>
                                    <th style="text-align: center;">Documento</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Entrada</th>
                                    <th style="text-align: center;">Doc Criação</th>
                                    <th style="text-align: center;">Doc Modificação</th>
                                    <?php
                                    if (verificarSetorNecropapiloscopia()) {
                                        echo '<th style="text-align: center;">Excluir</th>';
                                        echo '<th style="text-align: center;">Digitais</th>';
                                    }
                                    ?>
                                    <th style="text-align: center;">Imprimir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="necropapiloscopiaIdentificacao.php" method="POST">
                                    <?php
                                    $pg_num = $_GET["pg_num"];
                                    if ($_GET["pg_num"] == "") {
                                        $pg_num = 1;
                                    }
                                    $sql_num_of_doc = "SELECT `necropapiloscopia_id` FROM `necropapiloscopia_tb` ORDER BY `necropapiloscopia_id` DESC LIMIT 1";
                                    $query_num_of_doc = mysqli_query($_SG['link'], $sql_num_of_doc);
                                    $row_num_of_doc = mysqli_fetch_assoc($query_num_of_doc);
                                    $pg_num_of_doc = $row_num_of_doc["necropapiloscopia_id"];
                                    $size_page = 11; //(-1)
                                    $primeiro_doc = $pg_num_of_doc - (($pg_num - 1) * $size_page);
                                    $ultimo_doc = $primeiro_doc - $size_page + 1;

                                    $sql_lista = "SELECT * FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_id` BETWEEN '" . $ultimo_doc . "' AND '" . $primeiro_doc . "' ORDER BY `necropapiloscopia_id` DESC";
                                    $query_lista = mysqli_query($_SG['link'], $sql_lista);
                                    while ($row_lista = mysqli_fetch_assoc($query_lista)) {
                                        echo '<tr>';
                                        echo '<th scope="row" style="text-align: center;"><a href="necropapiloscopiaDocumento.php?necropapiloscopia_protocolo=' . $row_lista["necropapiloscopia_protocolo"] . '">' . $row_lista["necropapiloscopia_protocolo"] . '</a></th>';
                                        echo '<th style="text-align: center;">' . $row_lista["necropapiloscopia_nic_numero"] . '</th>';
                                        echo '<th style="text-align: center;">' . $row_lista["necropapiloscopia_nome"] . '</th>';
                                        $necropapiloscopia_documento = $row_lista["necropapiloscopia_documento_tipo"] . " " . $row_lista["necropapiloscopia_documento_numero"] . " " . $row_lista["necropapiloscopia_documento_orgao"] . " " . $row_lista["necropapiloscopia_documento_uf"];
                                        echo '<th style="text-align: center;">' . $necropapiloscopia_documento . '</th>';
                                        echo '<th style="text-align: center;">' . montarDivStatus($row_lista["necropapiloscopia_protocolo"]) . '</th>';
                                        echo '<th style="text-align: center;">' . corrigirData($row_lista["necropapiloscopia_entrada_data"]) . '</th>';
                                        $necropapiloscopia_doc_criacao = peritoAbreviado($row_lista["necropapiloscopia_doc_criacao_perito_nome"]) . " " . corrigirDataCompleta($row_lista["necropapiloscopia_doc_criacao_data"]);
                                        echo '<th style="text-align: center;">' . $necropapiloscopia_doc_criacao . '</th>';
                                        $necropapiloscopia_doc_modificacao = peritoAbreviado($row_lista["necropapiloscopia_doc_modificacao_perito_nome"]) . " " . corrigirDataCompleta($row_lista["necropapiloscopia_doc_modificacao_data"]);
                                        echo '<th style="text-align: center;">' . $necropapiloscopia_doc_modificacao . '</th>';
                                        if (verificarSetorNecropapiloscopia()) {
                                            echo '<th style="text-align: center;"><a href="?delete=' . $row_lista["necropapiloscopia_protocolo"] . '"><i class="glyphicon glyphicon-trash"></i></a></th>';
                                            echo '<th style="text-align: center;">';
                                            echo '<a target="_blank" href="necropapiloscopiaVerDigitais.php?necropapiloscopia_digitais_folha_um=' . $row_lista["necropapiloscopia_protocolo"] . '"><i class="glyphicon glyphicon-hand-up"></i></a>';
                                            echo ' <a target="_blank" href="necropapiloscopiaVerDigitais.php?necropapiloscopia_digitais_folha_dois=' . $row_lista["necropapiloscopia_protocolo"] . '"><i class="glyphicon glyphicon-hand-down"></i></a>';
                                            echo '</th>';
                                        }
                                        echo '<th style="text-align: center;">' . montarDivImpressora($row_lista["necropapiloscopia_protocolo"]) . '</th>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </form>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <?php
                                if ($pg_num == 1) {
                                    echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                } else {
                                    echo '<li><a href="?pg_num=' . ($pg_num - 1) . '" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                }
                                if ($ultimo_doc <= 1) {
                                    echo '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                } else {
                                    echo '<li><a href="?pg_num=' . ($pg_num + 1) . '" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                }
                                ?>
                            </ul>
                        </nav>
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