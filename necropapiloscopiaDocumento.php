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
    $necropapiloscopia_protocolo = test_input($_GET["necropapiloscopia_protocolo"]);
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

    $sql_pegar_usuario = "SELECT `usuario_nome`, `usuario_cargo`, `usuario_matricula` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
    $query_pegar_usuario = mysqli_query($_SG['link'], $sql_pegar_usuario);
    $row_pegar_usuario = mysqli_fetch_assoc($query_pegar_usuario);
    $necropapiloscopia_perito_id = $_SESSION['usuarioID'];
    $necropapiloscopia_perito_nome = $row_pegar_usuario["usuario_nome"];
    $necropapiloscopia_perito_matricula = $row_pegar_usuario["usuario_matricula"];
    $necropapiloscopia_perito_cargo = $row_pegar_usuario["usuario_cargo"];

    $necropapiloscopia_doc_modificacao_data = date("Y-m-d H:i:s");
    $necropapiloscopia_doc_modificacao_perito_nome = $row_pegar_usuario["usuario_nome"];

    if ($necropapiloscopia_coleta_check == "on") {
        $necropapiloscopia_coleta_check = 1;
    } else {
        $necropapiloscopia_coleta_check = 0;
    }

    if ($necropapiloscopia_nome != "") {
        $sql_editar_doc = "UPDATE `necropapiloscopia_tb` SET `necropapiloscopia_perito_nome`='" . $necropapiloscopia_perito_nome . "',`necropapiloscopia_perito_matricula`='" . $necropapiloscopia_perito_matricula . "',`necropapiloscopia_perito_cargo`='" . $necropapiloscopia_perito_cargo . "',`necropapiloscopia_doc_modificacao_data`='" . $necropapiloscopia_doc_modificacao_data . "',`necropapiloscopia_doc_modificacao_perito_nome`='" . $necropapiloscopia_doc_modificacao_perito_nome . "',`necropapiloscopia_nic_numero`='" . $necropapiloscopia_nic_numero . "',`necropapiloscopia_entrada_data`='" . $necropapiloscopia_entrada_data . "',`necropapiloscopia_fato_data`='" . $necropapiloscopia_fato_data . "',`necropapiloscopia_sei_protocolo`='" . $necropapiloscopia_sei_protocolo . "',`necropapiloscopia_procedente_bairro`='" . $necropapiloscopia_procedente_bairro . "',`necropapiloscopia_procedente_cidade`='" . $necropapiloscopia_procedente_cidade . "',`necropapiloscopia_procedente_uf`='" . $necropapiloscopia_procedente_uf . "',`necropapiloscopia_informacoes`='" . $necropapiloscopia_informacoes . "',`necropapiloscopia_situacao`='" . $necropapiloscopia_situacao . "',`necropapiloscopia_guia_numero`='" . $necropapiloscopia_guia_numero . "',`necropapiloscopia_causa_morte`='" . $necropapiloscopia_causa_morte . "',`necropapiloscopia_exame_destino`='" . $necropapiloscopia_exame_destino . "',`necropapiloscopia_coleta_check`='" . $necropapiloscopia_coleta_check . "',`necropapiloscopia_coleta_motivo`='" . $necropapiloscopia_coleta_motivo . "',`necropapiloscopia_nascimento_data`='" . $necropapiloscopia_nascimento_data . "',`necropapiloscopia_naturalidade_cidade`='" . $necropapiloscopia_naturalidade_cidade . "',`necropapiloscopia_naturalidade_uf`='" . $necropapiloscopia_naturalidade_uf . "',`necropapiloscopia_nome`='" . $necropapiloscopia_nome . "',`necropapiloscopia_pai_nome`='" . $necropapiloscopia_pai_nome . "',`necropapiloscopia_mae_nome`='" . $necropapiloscopia_mae_nome . "',`necropapiloscopia_documento_tipo`='" . $necropapiloscopia_documento_tipo . "',`necropapiloscopia_documento_numero`='" . $necropapiloscopia_documento_numero . "',`necropapiloscopia_documento_orgao`='" . $necropapiloscopia_documento_orgao . "',`necropapiloscopia_documento_uf`='" . $necropapiloscopia_documento_uf . "',`necropapiloscopia_observacoes`='" . $necropapiloscopia_observacoes . "' WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";
    } else {
        $sql_editar_doc = "UPDATE `necropapiloscopia_tb` SET `necropapiloscopia_perito_nome`='" . $necropapiloscopia_perito_nome . "',`necropapiloscopia_perito_matricula`='" . $necropapiloscopia_perito_matricula . "',`necropapiloscopia_perito_cargo`='" . $necropapiloscopia_perito_cargo . "',`necropapiloscopia_doc_modificacao_data`='" . $necropapiloscopia_doc_modificacao_data . "',`necropapiloscopia_doc_modificacao_perito_nome`='" . $necropapiloscopia_doc_modificacao_perito_nome . "',`necropapiloscopia_nic_numero`='" . $necropapiloscopia_nic_numero . "',`necropapiloscopia_entrada_data`='" . $necropapiloscopia_entrada_data . "',`necropapiloscopia_fato_data`='" . $necropapiloscopia_fato_data . "',`necropapiloscopia_sei_protocolo`='" . $necropapiloscopia_sei_protocolo . "',`necropapiloscopia_procedente_bairro`='" . $necropapiloscopia_procedente_bairro . "',`necropapiloscopia_procedente_cidade`='" . $necropapiloscopia_procedente_cidade . "',`necropapiloscopia_procedente_uf`='" . $necropapiloscopia_procedente_uf . "',`necropapiloscopia_informacoes`='" . $necropapiloscopia_informacoes . "',`necropapiloscopia_situacao`='" . $necropapiloscopia_situacao . "',`necropapiloscopia_guia_numero`='" . $necropapiloscopia_guia_numero . "',`necropapiloscopia_causa_morte`='" . $necropapiloscopia_causa_morte . "',`necropapiloscopia_exame_destino`='" . $necropapiloscopia_exame_destino . "',`necropapiloscopia_coleta_check`='" . $necropapiloscopia_coleta_check . "',`necropapiloscopia_coleta_motivo`='" . $necropapiloscopia_coleta_motivo . "' WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";
    }

    if (mysqli_query($_SG['link'], $sql_editar_doc)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Protocolo <b>' . $necropapiloscopia_protocolo . '</b> Documeto adicionado.';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error: " . $sql_editar_doc . "<br>" . mysqli_error($_SG['link']);
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
                            <?php
                            $necropapiloscopia_protocolo = test_input($_GET["necropapiloscopia_protocolo"]);
                            ?>
                            <h4>Modificar Documento - Protocolo <b><?php echo $necropapiloscopia_protocolo; ?></b> </h4>
                        </div>
                        <div class="form-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?necropapiloscopia_protocolo=<?php echo $necropapiloscopia_protocolo; ?>" method="POST">
                                <?php
                                $sql_select_protocolo = "SELECT * FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";
                                $query_select_protocolo = mysqli_query($_SG['link'], $sql_select_protocolo);
                                $row_select_protocolo = mysqli_fetch_assoc($query_select_protocolo);
                                $necropapiloscopia_nic_numero = $row_select_protocolo["necropapiloscopia_nic_numero"];
                                $necropapiloscopia_entrada_data = $row_select_protocolo["necropapiloscopia_entrada_data"];
                                $necropapiloscopia_fato_data = $row_select_protocolo["necropapiloscopia_fato_data"];
                                $necropapiloscopia_sei_protocolo = $row_select_protocolo["necropapiloscopia_sei_protocolo"];
                                $necropapiloscopia_procedente_bairro = $row_select_protocolo["necropapiloscopia_procedente_bairro"];
                                $necropapiloscopia_procedente_cidade = $row_select_protocolo["necropapiloscopia_procedente_cidade"];
                                $necropapiloscopia_procedente_uf = $row_select_protocolo["necropapiloscopia_procedente_uf"];
                                $necropapiloscopia_informacoes = $row_select_protocolo["necropapiloscopia_informacoes"];
                                $necropapiloscopia_situacao = $row_select_protocolo["necropapiloscopia_situacao"];
                                $necropapiloscopia_guia_numero = $row_select_protocolo["necropapiloscopia_guia_numero"];
                                $necropapiloscopia_causa_morte = $row_select_protocolo["necropapiloscopia_causa_morte"];
                                $necropapiloscopia_exame_destino = $row_select_protocolo["necropapiloscopia_exame_destino"];
                                $necropapiloscopia_coleta_check = $row_select_protocolo["necropapiloscopia_coleta_check"];
                                $necropapiloscopia_coleta_motivo = $row_select_protocolo["necropapiloscopia_coleta_motivo"];
                                ?>
                                <div class="form-group col-md-3">
                                    <label>Nº NIC</label>
                                    <input name="necropapiloscopia_nic_numero" type="text" class="form-control" placeholder="0000" value="<?php echo $necropapiloscopia_nic_numero; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                    } ?>>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data de Entrada no ITEP</label>
                                    <input name="necropapiloscopia_entrada_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_entrada_data; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                    } ?>>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data do Fato</label>
                                    <input name="necropapiloscopia_fato_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_fato_data; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                echo "disabled";
                                                                                                                                                                            } ?>>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Protocolo SEI</label>
                                    <input name="necropapiloscopia_sei_protocolo" type="text" class="form-control" placeholder="<?php echo $necropapiloscopia_sei_protocolo; ?>" value="00000.000000/0000-00" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                        } ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="width: 100%">Procedente</label>
                                    <input name="necropapiloscopia_procedente_bairro" type="text" class=" col-md-6 form-control" placeholder="Bairro ou Hospital" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_procedente_bairro; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                    } ?>>
                                    <input name="necropapiloscopia_procedente_cidade" type="text" class="col-md-5 form-control" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_procedente_cidade; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                                        } ?>>
                                    <input name="necropapiloscopia_procedente_uf" type="text" class="col-md-1 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_procedente_uf; ?>" maxlength="2" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                                        } ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Informações do Cadáver</label>
                                    <input name="necropapiloscopia_informacoes" type="text" class="col-md-12 form-control" placeholder="Informe aqui as caracteristicas físicas e/ou sexuais do cadaver" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_informacoes; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                    } ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Situação do Cadáver</label>
                                    <input name="necropapiloscopia_situacao" type="text" class="col-md-12 form-control" placeholder="Informe aqui o estado físico que se encontra o cadaver" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_situacao; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                    } ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nº da Guia de Solicitação</label>
                                    <input name="necropapiloscopia_guia_numero" type="text" class="col-md-12 form-control" placeholder="" value="<?php echo $necropapiloscopia_guia_numero; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                            } ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Causa Morte</label>
                                    <input name="necropapiloscopia_causa_morte" type="text" class="col-md-12 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_causa_morte; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                    } ?>>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Destino do Exame</label>
                                    <input name="necropapiloscopia_exame_destino" type="text" class="col-md-12 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_exame_destino; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                        } ?>>
                                </div>
                                <div class="checkbox col-md-12">
                                    <label class="col-md-12">
                                        <?php
                                        if ($necropapiloscopia_coleta_check == 1) {
                                            if (!verificarSetorNecropapiloscopia()) {
                                                echo '<input name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox" checked disabled>';
                                            } else {
                                                echo '<input name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox" checked>';
                                            }
                                        } else {
                                            if (!verificarSetorNecropapiloscopia()) {
                                                echo '<input name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox" disabled>';
                                            } else {
                                                echo '<input name="necropapiloscopia_coleta_check" type="checkbox" class="checkbox">';
                                            }
                                        }
                                        ?>
                                        Não apresenta condições de coleta de Impressões Digitais
                                        <input name="necropapiloscopia_coleta_motivo" type="text" class="col-md-12 form-control" placeholder="Informe aqui o motivo devido" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_coleta_motivo; ?>" <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                } ?>>
                                    </label>
                                </div>
                                <?php
                                $necropapiloscopia_nic_numero = $row_select_protocolo["necropapiloscopia_nic_numero"];
                                $necropapiloscopia_nascimento_data = $row_select_protocolo["necropapiloscopia_nascimento_data"];
                                $necropapiloscopia_naturalidade_cidade = $row_select_protocolo["necropapiloscopia_naturalidade_cidade"];
                                $necropapiloscopia_naturalidade_uf = $row_select_protocolo["necropapiloscopia_naturalidade_uf"];
                                $necropapiloscopia_nome = $row_select_protocolo["necropapiloscopia_nome"];
                                $necropapiloscopia_pai_nome = $row_select_protocolo["necropapiloscopia_pai_nome"];
                                $necropapiloscopia_mae_nome = $row_select_protocolo["necropapiloscopia_mae_nome"];
                                $necropapiloscopia_documento_tipo = $row_select_protocolo["necropapiloscopia_documento_tipo"];
                                $necropapiloscopia_documento_numero = $row_select_protocolo["necropapiloscopia_documento_numero"];
                                $necropapiloscopia_documento_orgao = $row_select_protocolo["necropapiloscopia_documento_orgao"];
                                $necropapiloscopia_documento_uf = $row_select_protocolo["necropapiloscopia_documento_uf"];
                                $necropapiloscopia_observacoes = $row_select_protocolo["necropapiloscopia_observacoes"];

                                if ($necropapiloscopia_nome != "") {
                                    ?>
                                    <div class="form-group col-md-3">
                                        <label>Data de Nascimento</label>
                                        <input name="necropapiloscopia_nascimento_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_nascimento_data; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                            } ?>>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label style="width: 100%">Naturalidade</label>
                                        <input name="necropapiloscopia_naturalidade_cidade" type="text" class="col-md-9 form-control" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_naturalidade_cidade; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                } ?>>
                                        <input name="necropapiloscopia_naturalidade_uf" type="text" class="col-md-3 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_naturalidade_uf; ?>" maxlength="2" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                } ?>>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Nome Completo</label>
                                        <input name="necropapiloscopia_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_nome; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                            } ?>>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Nome do Pai</label>
                                        <input name="necropapiloscopia_pai_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_pai_nome; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                    } ?>>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Nome do Mãe</label>
                                        <input name="necropapiloscopia_mae_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_mae_nome; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                    } ?>>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label style="width: 100%">Documento apresentado</label>
                                        <select name="necropapiloscopia_documento_tipo" class=" col-md-3 form-control" <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>
                                            <?php
                                            $array_tipos_documentos = array("RG", "CTPS", "PRONT.CIVIL", "RESERVISTA", "OUTRO");
                                            for ($i = 0; $i < sizeof($array_tipos_documentos); ++$i) {
                                                if ($necropapiloscopia_documento_tipo == $array_tipos_documentos[$i]) {
                                                    echo '<option value=' . $array_tipos_documentos[$i] . ' selected>' . $array_tipos_documentos[$i] . '</option>';
                                                } else {
                                                    echo "<option value=" . $array_tipos_documentos[$i] . ">" . $array_tipos_documentos[$i] . "</option>";
                                                }
                                            }
                                            ?>
                                            <input name="necropapiloscopia_documento_numero" type="text" class="col-md-4 form-control" placeholder="Nº" value="<?php echo $necropapiloscopia_documento_numero; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                            } ?>>
                                            <input name="necropapiloscopia_documento_orgao" type="text" class="col-md-4 form-control" placeholder="ORGÃO" value="<?php echo $necropapiloscopia_documento_orgao; ?>" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                } ?>>
                                            <input name="necropapiloscopia_documento_uf" type="text" class="col-md-1 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_documento_uf; ?>" maxlength="2" required <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                } ?>>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Observações</label>
                                        <input name="necropapiloscopia_observacoes" type="text" class="col-md-12 form-control" placeholder="Informe aqui as observações necessárias" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_observacoes; ?>" <?php if (!verificarSetorNecropapiloscopia()) {
                                                                                                                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                                                                                                                        } ?>>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="col-md-12">
                                    <br>
                                    <?php if (verificarSetorNecropapiloscopia()) {
                                        echo '<button type="submit" class="btn btn-success">Modificar</button>';
                                    } ?>
                                    <a href="/"><button type="button" class="btn btn-danger">Voltar</button></a>
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