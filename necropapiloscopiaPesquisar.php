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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $necropapiloscopia_protocolo = test_input($_POST["necropapiloscopia_protocolo"]);
    $necropapiloscopia_nic_numero = test_input($_POST["necropapiloscopia_nic_numero"]);
    $necropapiloscopia_entrada_data = test_input($_POST["necropapiloscopia_entrada_data"]);
    $necropapiloscopia_fato_data = test_input($_POST["necropapiloscopia_fato_data"]);
    $necropapiloscopia_sei_protocolo = test_input($_POST["necropapiloscopia_sei_protocolo"]);
    $necropapiloscopia_procedente_bairro = test_input($_POST["necropapiloscopia_procedente_bairro"]);
    $necropapiloscopia_procedente_cidade = test_input($_POST["necropapiloscopia_procedente_cidade"]);
    $necropapiloscopia_procedente_uf = test_input($_POST["necropapiloscopia_procedente_uf"]);
    $necropapiloscopia_informacoes = test_input($_POST["necropapiloscopia_informacoes"]);
    $necropapiloscopia_situacao = test_input($_POST["necropapiloscopia_situacao"]);
    $necropapiloscopia_guia_numero = test_input($_POST["necropapiloscopia_guia_numero"]);
    $necropapiloscopia_causa_morte = test_input($_POST["necropapiloscopia_causa_morte"]);
    $necropapiloscopia_exame_destino = test_input($_POST["necropapiloscopia_exame_destino"]);
    $necropapiloscopia_coleta_check = $_POST["necropapiloscopia_coleta_check"];
    $necropapiloscopia_coleta_motivo = test_input($_POST["necropapiloscopia_coleta_motivo"]);
    $necropapiloscopia_nascimento_data = test_input($_POST["necropapiloscopia_nascimento_data"]);
    $necropapiloscopia_naturalidade_cidade = test_input($_POST["necropapiloscopia_naturalidade_cidade"]);
    $necropapiloscopia_naturalidade_uf = test_input($_POST["necropapiloscopia_naturalidade_uf"]);
    $necropapiloscopia_nome = test_input($_POST["necropapiloscopia_nome"]);
    $necropapiloscopia_pai_nome = test_input($_POST["necropapiloscopia_pai_nome"]);
    $necropapiloscopia_mae_nome = test_input($_POST["necropapiloscopia_mae_nome"]);
    $necropapiloscopia_documento_tipo = test_input($_POST["necropapiloscopia_documento_tipo"]);
    $necropapiloscopia_documento_numero = test_input($_POST["necropapiloscopia_documento_numero"]);
    $necropapiloscopia_documento_orgao = test_input($_POST["necropapiloscopia_documento_orgao"]);
    $necropapiloscopia_documento_uf = test_input($_POST["necropapiloscopia_documento_uf"]);
    $necropapiloscopia_observacoes = test_input($_POST["necropapiloscopia_observacoes"]);
    if ($necropapiloscopia_coleta_check == "on") {
        $necropapiloscopia_coleta_check = 1;
    } else {
        $necropapiloscopia_coleta_check = 0;
    }
    if ($necropapiloscopia_documento_numero == "") {
        $necropapiloscopia_documento_tipo = "";
    }
    $necropapiloscopia_doc_criacao_data_inicial = test_input($_POST["necropapiloscopia_doc_criacao_data_inicial"]);
    $necropapiloscopia_doc_criacao_data_final = test_input($_POST["necropapiloscopia_doc_criacao_data_final"]);

    $sql_select_protocolo = "SELECT * FROM `necropapiloscopia_tb` WHERE ";

    $sql_select_protocolo_array = array();

    if ($necropapiloscopia_protocolo != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'");
    }
    if ($necropapiloscopia_nic_numero != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_nic_numero`='" . $necropapiloscopia_nic_numero . "'");
    }
    if ($necropapiloscopia_entrada_data != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_entrada_data`='" . $necropapiloscopia_entrada_data . "'");
    }
    if ($necropapiloscopia_fato_data != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_fato_data`='" . $necropapiloscopia_fato_data . "'");
    }
    if ($necropapiloscopia_sei_protocolo != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_sei_protocolo`='" . $necropapiloscopia_sei_protocolo . "'");
    }
    if ($necropapiloscopia_procedente_bairro != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_procedente_bairro`='" . $necropapiloscopia_procedente_bairro . "'");
    }
    if ($necropapiloscopia_procedente_cidade != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_procedente_cidade`='" . $necropapiloscopia_procedente_cidade . "'");
    }
    if ($necropapiloscopia_procedente_uf != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_procedente_uf`='" . $necropapiloscopia_procedente_uf . "'");
    }
    if ($necropapiloscopia_informacoes != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_informacoes`='" . $necropapiloscopia_informacoes . "'");
    }
    if ($necropapiloscopia_situacao != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_situacao`='" . $necropapiloscopia_situacao . "'");
    }
    if ($necropapiloscopia_guia_numero != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_guia_numero`='" . $necropapiloscopia_guia_numero . "'");
    }
    if ($necropapiloscopia_causa_morte != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_causa_morte`='" . $necropapiloscopia_causa_morte . "'");
    }
    if ($necropapiloscopia_exame_destino != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_exame_destino`='" . $necropapiloscopia_exame_destino . "'");
    }
    if ($necropapiloscopia_coleta_check != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_coleta_check`='" . $necropapiloscopia_coleta_check . "'");
    }
    if ($necropapiloscopia_coleta_motivo != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_coleta_motivo`='" . $necropapiloscopia_coleta_motivo . "'");
    }
    if ($necropapiloscopia_nascimento_data != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_nascimento_data`='" . $necropapiloscopia_nascimento_data . "'");
    }
    if ($necropapiloscopia_naturalidade_cidade != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_naturalidade_cidade`='" . $necropapiloscopia_naturalidade_cidade . "'");
    }
    if ($necropapiloscopia_naturalidade_uf != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_naturalidade_uf`='" . $necropapiloscopia_naturalidade_uf . "'");
    }
    if ($necropapiloscopia_nome != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_nome`='" . $necropapiloscopia_nome . "'");
    }
    if ($necropapiloscopia_pai_nome != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_pai_nome`='" . $necropapiloscopia_pai_nome . "'");
    }
    if ($necropapiloscopia_mae_nome != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_mae_nome`='" . $necropapiloscopia_mae_nome . "'");
    }
    if ($necropapiloscopia_documento_tipo != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_documento_tipo`='" . $necropapiloscopia_documento_tipo . "'");
    }
    if ($necropapiloscopia_documento_numero != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_documento_numero`='" . $necropapiloscopia_documento_numero . "'");
    }
    if ($necropapiloscopia_documento_orgao != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_documento_orgao`='" . $necropapiloscopia_documento_orgao . "'");
    }
    if ($necropapiloscopia_documento_uf != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_documento_uf`='" . $necropapiloscopia_documento_uf . "'");
    }
    if ($necropapiloscopia_observacoes != "") {
        array_push($sql_select_protocolo_array, "`necropapiloscopia_observacoes`='" . $necropapiloscopia_observacoes . "'");
    }

    for ($i = 0; $i < count($sql_select_protocolo_array); $i++) {
        $sql_select_protocolo .= $sql_select_protocolo_array[$i] . " ";
        if ($i != (count($sql_select_protocolo_array) - 1)) {
            $sql_select_protocolo .= "AND ";
        }
    }

    if (count($sql_select_protocolo_array) != 0) {
        $sql_select_protocolo .= "AND ";
    }
    $sql_select_protocolo .= "`necropapiloscopia_doc_criacao_data` BETWEEN '" . $necropapiloscopia_doc_criacao_data_inicial . " 00:00:00' AND '" . $necropapiloscopia_doc_criacao_data_final . " 00:00:00' ORDER BY `necropapiloscopia_id` DESC";

    $query_select_protocolo = mysqli_query($_SG['link'], $sql_select_protocolo);

    if (mysqli_num_rows($query_select_protocolo) > 0) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Encontrados <b>' . mysqli_num_rows($query_select_protocolo) . '</b> Documeto(s).';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Desculpe! Encontrado <b>nenhum</b> Documeto.';
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
                <div class="forms">
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Pesquisar Documento </h4>
                        </div>
                        <div class="form-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="form-group col-md-3">
                                    <label>Nº NIC</label>
                                    <input name="necropapiloscopia_nic_numero" type="text" class="form-control" placeholder="0000" value="<?php echo $necropapiloscopia_nic_numero; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data de Entrada no ITEP</label>
                                    <input name="necropapiloscopia_entrada_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_entrada_data; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data do Fato</label>
                                    <input name="necropapiloscopia_fato_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_fato_data; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Protocolo SEI</label>
                                    <input name="necropapiloscopia_sei_protocolo" type="text" class="form-control" placeholder="<?php echo $necropapiloscopia_sei_protocolo; ?>" value="<?php echo $necropapiloscopia_sei_protocolo; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="width: 100%">Procedente</label>
                                    <input name="necropapiloscopia_procedente_bairro" type="text" class=" col-md-6 form-control" placeholder="Bairro ou Hospital" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_procedente_bairro; ?>">
                                    <input name="necropapiloscopia_procedente_cidade" type="text" class="col-md-5 form-control" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_procedente_cidade; ?>">
                                    <input name="necropapiloscopia_procedente_uf" type="text" class="col-md-1 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_procedente_uf; ?>" maxlength="2">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Informações do Cadáver</label>
                                    <input name="necropapiloscopia_informacoes" type="text" class="col-md-12 form-control" placeholder="Informe aqui as caracteristicas físicas e/ou sexuais do cadaver" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_informacoes; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Situação do Cadáver</label>
                                    <input name="necropapiloscopia_situacao" type="text" class="col-md-12 form-control" placeholder="Informe aqui o estado físico que se encontra o cadaver" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_situacao; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nº da Guia de Solicitação</label>
                                    <input name="necropapiloscopia_guia_numero" type="text" class="col-md-12 form-control" placeholder="" value="<?php echo $necropapiloscopia_guia_numero; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Causa Morte</label>
                                    <input name="necropapiloscopia_causa_morte" type="text" class="col-md-12 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_causa_morte; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Destino do Exame</label>
                                    <input name="necropapiloscopia_exame_destino" type="text" class="col-md-12 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_exame_destino; ?>">
                                </div>
                                <div class="checkbox col-md-12">
                                    <label class="col-md-12">
                                        <?php
                                        if ($necropapiloscopia_coleta_check == 1) {
                                            echo '<input name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox" checked>';
                                        } else {
                                            echo '<input name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox">';
                                        }
                                        ?>
                                        Não apresenta condições de coleta de Impressões Digitais
                                        <input name="necropapiloscopia_coleta_motivo" type="text" class="col-md-12 form-control" placeholder="Informe aqui o motivo devido" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_coleta_motivo; ?>">
                                    </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data de Nascimento</label>
                                    <input name="necropapiloscopia_nascimento_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_nascimento_data; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Naturalidade</label>
                                    <input name="necropapiloscopia_naturalidade_cidade" type="text" class="col-md-9 form-control" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_naturalidade_cidade; ?>">
                                    <input name="necropapiloscopia_naturalidade_uf" type="text" class="col-md-3 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_naturalidade_uf; ?>" maxlength="2">
                                </div>
                                <div class="form-group col-md-6">
                                    <label style="width: 100%;">Data de Criação do Documento</label>
                                    <div class="col-md-2"> Entre </div>
                                    <input name="necropapiloscopia_doc_criacao_data_inicial" type="date" class="col-md-4 form-control" value="<?php echo $necropapiloscopia_nascimento_data_inicial; ?>" required>
                                    <div class="col-md-1"> e </div>
                                    <input name="necropapiloscopia_doc_criacao_data_final" type="date" class="col-md-4 form-control" value="<?php echo $necropapiloscopia_nascimento_data_final; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nome Completo</label>
                                    <input name="necropapiloscopia_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_nome; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nome do Pai</label>
                                    <input name="necropapiloscopia_pai_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_pai_nome; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nome do Mãe</label>
                                    <input name="necropapiloscopia_mae_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_mae_nome; ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="width: 100%">Documento apresentado</label>
                                    <select name="necropapiloscopia_documento_tipo" class=" col-md-3 form-control">
                                        <?php
                                        $array_tipos_documentos = array("RG", "CTPS", "PRONT. CIVIL", "RESERVISTA", "OUTRO");
                                        for ($i = 0; $i < sizeof($array_tipos_documentos); ++$i) {
                                            if ($necropapiloscopia_documento_tipo == $array_tipos_documentos[$i]) {
                                                echo '<option value="' . $array_tipos_documentos[$i] . '" selected>' . $array_tipos_documentos[$i] . '</option>';
                                            } else {
                                                echo "<option value='" . $array_tipos_documentos[$i] . "'>" . $array_tipos_documentos[$i] . "</option>";
                                            }
                                        }
                                        ?>
                                        <input name="necropapiloscopia_documento_numero" type="text" class="col-md-4 form-control" placeholder="Nº" value="<?php echo $necropapiloscopia_documento_numero; ?>">
                                        <input name="necropapiloscopia_documento_orgao" type="text" class="col-md-4 form-control" placeholder="ORGÃO" value="<?php echo $necropapiloscopia_documento_orgao; ?>">
                                        <input name="necropapiloscopia_documento_uf" type="text" class="col-md-1 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_documento_uf; ?>" maxlength="2">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Observações</label>
                                    <input name="necropapiloscopia_observacoes" type="text" class="col-md-12 form-control" placeholder="Informe aqui as observações necessárias" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_observacoes; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Protocolo Necropapiloscopia</label>
                                    <input name="necropapiloscopia_protocolo" type="text" class="col-md-12 form-control" placeholder="0000/0000" value="<?php echo $necropapiloscopia_protocolo; ?>">
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-success">Pesquisar</button>
                                    <br><br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
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
                                    }
                                    ?>
                                    <th style="text-align: center;">Imprimir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="necropapiloscopiaIdentificacao.php" method="POST">
                                    <?php
                                    while ($row_lista = mysqli_fetch_assoc($query_select_protocolo)) {
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
                                            echo '<th style="text-align: center;"><a href="necropapiloscopiaLista.php?delete=' . $row_lista["necropapiloscopia_protocolo"] . '"><i class=" glyphicon glyphicon-trash "></a></th>';
                                        }
                                        echo '<th style="text-align: center;">' . montarDivImpressora($row_lista["necropapiloscopia_protocolo"]) . '</th>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </form>
                            </tbody>
                        </table>
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