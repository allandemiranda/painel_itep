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

    $sql_pegar_usuario = "SELECT `usuario_nome`, `usuario_cargo`, `usuario_matricula` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
    $query_pegar_usuario = mysqli_query($_SG['link'], $sql_pegar_usuario);
    $row_pegar_usuario = mysqli_fetch_assoc($query_pegar_usuario);
    $necropapiloscopia_perito_id = $_SESSION['usuarioID'];
    $necropapiloscopia_perito_nome = $row_pegar_usuario["usuario_nome"];
    $necropapiloscopia_perito_matricula = $row_pegar_usuario["usuario_matricula"];
    $necropapiloscopia_perito_cargo = $row_pegar_usuario["usuario_cargo"];

    $necropapiloscopia_doc_criacao_data = date("Y-m-d H:i:s");
    $necropapiloscopia_doc_criacao_perito_nome = $row_pegar_usuario["usuario_nome"];

    $imagem = $_FILES['necropapiloscopia_digitais_folha_um']['tmp_name'];
    $tamanho = $_FILES['necropapiloscopia_digitais_folha_um']['size'];
    $fp = fopen($imagem, "rb");
    $necropapiloscopia_digitais_folha_um = fread($fp, $tamanho);
    $necropapiloscopia_digitais_folha_um = addslashes($necropapiloscopia_digitais_folha_um);
    fclose($fp);
    $imagem = $_FILES['necropapiloscopia_digitais_folha_dois']['tmp_name'];
    $tamanho = $_FILES['necropapiloscopia_digitais_folha_dois']['size'];
    $fp = fopen($imagem, "rb");
    $necropapiloscopia_digitais_folha_dois = fread($fp, $tamanho);
    $necropapiloscopia_digitais_folha_dois = addslashes($necropapiloscopia_digitais_folha_dois);
    fclose($fp);

    if ($necropapiloscopia_coleta_check == "on") {
        $necropapiloscopia_coleta_check = "1";
        $sql_novo_doc = "INSERT INTO `necropapiloscopia_tb`(`necropapiloscopia_perito_id`, `necropapiloscopia_perito_nome`, `necropapiloscopia_perito_matricula`, `necropapiloscopia_perito_cargo`, `necropapiloscopia_doc_criacao_data`, `necropapiloscopia_doc_criacao_perito_nome`, `necropapiloscopia_nic_numero`, `necropapiloscopia_entrada_data`, `necropapiloscopia_fato_data`, `necropapiloscopia_sei_protocolo`, `necropapiloscopia_procedente_bairro`, `necropapiloscopia_procedente_cidade`, `necropapiloscopia_procedente_uf`, `necropapiloscopia_informacoes`, `necropapiloscopia_situacao`, `necropapiloscopia_guia_numero`, `necropapiloscopia_causa_morte`, `necropapiloscopia_exame_destino`, `necropapiloscopia_coleta_check`, `necropapiloscopia_coleta_motivo`,`necropapiloscopia_digitais_folha_um`,`necropapiloscopia_digitais_folha_dois`) VALUES ('" . $necropapiloscopia_perito_id . "','" . $necropapiloscopia_perito_nome . "','" . $necropapiloscopia_perito_matricula . "','" . $necropapiloscopia_perito_cargo . "','" . $necropapiloscopia_doc_criacao_data . "','" . $necropapiloscopia_doc_criacao_perito_nome . "','" . $necropapiloscopia_nic_numero . "', '" . $necropapiloscopia_entrada_data . "', '" . $necropapiloscopia_fato_data . "', '" . $necropapiloscopia_sei_protocolo . "', '" . $necropapiloscopia_procedente_bairro . "', '" . $necropapiloscopia_procedente_cidade . "', '" . $necropapiloscopia_procedente_uf . "', '" . $necropapiloscopia_informacoes . "', '" . $necropapiloscopia_situacao . "', '" . $necropapiloscopia_guia_numero . "', '" . $necropapiloscopia_causa_morte . "', '" . $necropapiloscopia_exame_destino . "', '" . $necropapiloscopia_coleta_check . "', '" . $necropapiloscopia_coleta_motivo . "','" . $necropapiloscopia_digitais_folha_um . "','" . $necropapiloscopia_digitais_folha_dois . "')";
    } else {
        $necropapiloscopia_coleta_check = "0";
        $sql_novo_doc = "INSERT INTO `necropapiloscopia_tb`(`necropapiloscopia_perito_id`, `necropapiloscopia_perito_nome`, `necropapiloscopia_perito_matricula`, `necropapiloscopia_perito_cargo`, `necropapiloscopia_doc_criacao_data`, `necropapiloscopia_doc_criacao_perito_nome`,`necropapiloscopia_nic_numero`, `necropapiloscopia_entrada_data`, `necropapiloscopia_fato_data`, `necropapiloscopia_sei_protocolo`, `necropapiloscopia_procedente_bairro`, `necropapiloscopia_procedente_cidade`, `necropapiloscopia_procedente_uf`, `necropapiloscopia_informacoes`, `necropapiloscopia_situacao`, `necropapiloscopia_guia_numero`, `necropapiloscopia_causa_morte`, `necropapiloscopia_exame_destino`, `necropapiloscopia_coleta_check`,`necropapiloscopia_digitais_folha_um`,`necropapiloscopia_digitais_folha_dois`) VALUES ('" . $necropapiloscopia_perito_id . "','" . $necropapiloscopia_perito_nome . "','" . $necropapiloscopia_perito_matricula . "','" . $necropapiloscopia_perito_cargo . "','" . $necropapiloscopia_doc_criacao_data . "','" . $necropapiloscopia_doc_criacao_perito_nome . "','" . $necropapiloscopia_nic_numero . "', '" . $necropapiloscopia_entrada_data . "', '" . $necropapiloscopia_fato_data . "', '" . $necropapiloscopia_sei_protocolo . "', '" . $necropapiloscopia_procedente_bairro . "', '" . $necropapiloscopia_procedente_cidade . "', '" . $necropapiloscopia_procedente_uf . "', '" . $necropapiloscopia_informacoes . "', '" . $necropapiloscopia_situacao . "', '" . $necropapiloscopia_guia_numero . "', '" . $necropapiloscopia_causa_morte . "', '" . $necropapiloscopia_exame_destino . "', '" . $necropapiloscopia_coleta_check . "','" . $necropapiloscopia_digitais_folha_um . "','" . $necropapiloscopia_digitais_folha_dois . "')";
    }

    if (mysqli_query($_SG['link'], $sql_novo_doc)) {
        $necropapiloscopia_id = mysqli_insert_id($_SG['link']);
        $necropapiloscopia_id = str_pad($necropapiloscopia_id, 4, "0", STR_PAD_LEFT);
        $necropapiloscopia_protocolo = $necropapiloscopia_id . "/" . date("Y");
        $sql_adicionar_protocolo = "UPDATE `necropapiloscopia_tb` SET `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "' WHERE `necropapiloscopia_id`='" . $necropapiloscopia_id . "'";
        mysqli_query($_SG['link'], $sql_adicionar_protocolo);
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Protocolo <b>' . $necropapiloscopia_protocolo . '</b> criado.';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error: " . $sql_novo_doc . "<br>" . mysqli_error($_SG['link']);
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
                            <h4>Novo Documento </h4>
                        </div>
                        <div class="form-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group col-md-3">
                                    <label>Nº NIC</label>
                                    <input name="necropapiloscopia_nic_numero" type="text" class="form-control" placeholder="0000" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data de Entrada no ITEP</label>
                                    <input name="necropapiloscopia_entrada_data" type="date" class="form-control" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data do Fato</label>
                                    <input name="necropapiloscopia_fato_data" type="date" class="form-control" value="" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Protocolo SEI</label>
                                    <input name="necropapiloscopia_sei_protocolo" type="text" class="form-control" placeholder="" value="00000.000000/0000-00" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="width: 100%">Procedente</label>
                                    <input name="necropapiloscopia_procedente_bairro" type="text" class=" col-md-6 form-control" placeholder="Bairro ou Hospital" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                    <input name="necropapiloscopia_procedente_cidade" type="text" class="col-md-5 form-control" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                    <input name="necropapiloscopia_procedente_uf" type="text" class="col-md-1 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="" maxlength="2" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Informações do Cadáver</label>
                                    <input name="necropapiloscopia_informacoes" type="text" class="col-md-12 form-control" placeholder="Informe aqui as caracteristicas físicas e/ou sexuais do cadaver" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Situação do Cadáver</label>
                                    <input name="necropapiloscopia_situacao" type="text" class="col-md-12 form-control" placeholder="Informe aqui o estado físico que se encontra o cadaver" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nº da Guia de Solicitação</label>
                                    <input name="necropapiloscopia_guia_numero" type="text" class="col-md-12 form-control" placeholder="" value="" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Causa Morte</label>
                                    <input name="necropapiloscopia_causa_morte" type="text" class="col-md-12 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Destino do Exame</label>
                                    <input name="necropapiloscopia_exame_destino" type="text" class="col-md-12 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                </div>
                                <div class="checkbox col-md-12">
                                    <label class="col-md-12">
                                        <input id="necropapiloscopia_coleta_check" name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox">
                                        Não apresenta condições de coleta de Impressões Digitais
                                        <input name="necropapiloscopia_coleta_motivo" type="text" class="col-md-12 form-control" placeholder="Informe aqui o motivo devido" onChange="javascript:this.value=this.value.toUpperCase();" value="">
                                    </label>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="width: 100%;">Digitais</label>
                                    <input id="necropapiloscopia_digitais_folha_um" type="file" name="necropapiloscopia_digitais_folha_um" class="col-md-6">
                                    <p class="help-block"> Documento com as Digitais Frente.</p>
                                    <input id="necropapiloscopia_digitais_folha_dois" type="file" name="necropapiloscopia_digitais_folha_dois" class="col-md-6">
                                    <p class="help-block"> Documento com as Digitais Verso.</p>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <input type="submit" class="btn btn-success" value="Criar">
                                    <a href="/"><button type="button" class="btn btn-danger">Cancelar</button></a>
                                    <br><br>
                                </div>
                            </form>
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