<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
log_up("mail-enviado", "Usuário " . $_SESSION['usuarioNome'] . " acessou página " . $_SERVER['REQUEST_URI'] . " no ip " . $_SERVER["REMOTE_ADDR"]);
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
    if (test_input($_POST["necropapiloscopia_nome"]) != "") {
        $necropapiloscopia_protocolo = test_input($_POST["necropapiloscopia_protocolo"]);
        $necropapiloscopia_nascimento_data = test_input($_POST["necropapiloscopia_nascimento_data"]);
        $necropapiloscopia_naturalidade_cidade = test_input($_POST["necropapiloscopia_naturalidade_cidade"]);
        $necropapiloscopia_naturalidade_uf = test_input($_POST["necropapiloscopia_naturalidade_uf"]);
        $necropapiloscopia_nome = test_input($_POST["necropapiloscopia_nome"]);
        $necropapiloscopia_pai_nome = test_input($_POST["necropapiloscopia_pai_nome"]);
        $necropapiloscopia_mae_nome = test_input($_POST["necropapiloscopia_mae_nome"]);
        $necropapiloscopia_documento_tipo = $_POST["necropapiloscopia_documento_tipo"];
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

        $sql_editar_doc = "UPDATE `necropapiloscopia_tb` SET `necropapiloscopia_perito_id`='" . $necropapiloscopia_perito_id . "',`necropapiloscopia_perito_nome`='" . $necropapiloscopia_perito_nome . "',`necropapiloscopia_perito_matricula`='" . $necropapiloscopia_perito_matricula . "',`necropapiloscopia_perito_cargo`='" . $necropapiloscopia_perito_cargo . "',`necropapiloscopia_doc_modificacao_data`='" . $necropapiloscopia_doc_modificacao_data . "',`necropapiloscopia_doc_modificacao_perito_nome`='" . $necropapiloscopia_doc_modificacao_perito_nome . "',`necropapiloscopia_nascimento_data`='" . $necropapiloscopia_nascimento_data . "',`necropapiloscopia_naturalidade_cidade`='" . $necropapiloscopia_naturalidade_cidade . "',`necropapiloscopia_naturalidade_uf`='" . $necropapiloscopia_naturalidade_uf . "',`necropapiloscopia_nome`='" . $necropapiloscopia_nome . "',`necropapiloscopia_pai_nome`='" . $necropapiloscopia_pai_nome . "',`necropapiloscopia_mae_nome`='" . $necropapiloscopia_mae_nome . "',`necropapiloscopia_documento_tipo`='" . $necropapiloscopia_documento_tipo . "',`necropapiloscopia_documento_numero`='" . $necropapiloscopia_documento_numero . "',`necropapiloscopia_documento_orgao`='" . $necropapiloscopia_documento_orgao . "',`necropapiloscopia_documento_uf`='" . $necropapiloscopia_documento_uf . "',`necropapiloscopia_observacoes`='" . $necropapiloscopia_observacoes . "' WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";

        if (mysqli_query($_SG['link'], $sql_editar_doc)) {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Protocolo <b>' . $necropapiloscopia_protocolo . '</b> Documeto adicionado.';
            $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
            log_up("criou", "Usuário " . $_SESSION['usuarioNome'] . " identificou documento da Necropapiloscopia de protocolo " . $necropapiloscopia_protocolo . " no ip " . $_SERVER["REMOTE_ADDR"]);
        } else {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . " Error: " . $sql_editar_doc . "<br>" . mysqli_error($_SG['link']);
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
                <div class="forms">
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Adicionar Identificação </h4>
                        </div>
                        <div class="form-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <?php
                                $necropapiloscopia_protocolo = test_input($_POST["necropapiloscopia_protocolo"]);
                                $sql_select_protocolo = "SELECT `necropapiloscopia_nic_numero`, `necropapiloscopia_nascimento_data`, `necropapiloscopia_naturalidade_cidade`, `necropapiloscopia_naturalidade_uf`, `necropapiloscopia_nome`, `necropapiloscopia_pai_nome`, `necropapiloscopia_mae_nome`, `necropapiloscopia_documento_tipo`, `necropapiloscopia_documento_numero`, `necropapiloscopia_documento_orgao`, `necropapiloscopia_documento_uf`, `necropapiloscopia_observacoes` FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";
                                $query_select_protocolo = mysqli_query($_SG['link'], $sql_select_protocolo);
                                $row_select_protocolo = mysqli_fetch_assoc($query_select_protocolo);
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
                                ?>
                                <div class="form-group col-md-3">
                                    <label>Protocolo Necropapiloscopia</label>
                                    <input name="necropapiloscopia_protocolo" type="text" class="form-control" value="<?php echo $necropapiloscopia_protocolo; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Nº NIC</label>
                                    <input name="necropapiloscopia_nic_numero" type="text" class="form-control" value="<?php echo $necropapiloscopia_nic_numero; ?>" disabled>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data de Nascimento</label>
                                    <input name="necropapiloscopia_nascimento_data" type="date" class="form-control" value="<?php echo $necropapiloscopia_nascimento_data; ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="width: 100%">Naturalidade</label>
                                    <input name="necropapiloscopia_naturalidade_cidade" type="text" class="col-md-9 form-control" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_naturalidade_cidade; ?>" required>
                                    <input name="necropapiloscopia_naturalidade_uf" type="text" class="col-md-3 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_naturalidade_uf; ?>" maxlength="2" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nome Completo</label>
                                    <input name="necropapiloscopia_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_nome; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nome do Pai</label>
                                    <input name="necropapiloscopia_pai_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_pai_nome; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nome do Mãe</label>
                                    <input name="necropapiloscopia_mae_nome" type="text" class=" col-md-12 form-control" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_mae_nome; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label style="width: 100%">Documento apresentado</label>
                                    <select name="necropapiloscopia_documento_tipo" class=" col-md-3 form-control">
                                        <?php
                                        $array_tipos_documentos = ["RG", "CTPS", "PRONT. CIVIL", "RESERVISTA", "OUTRO"];
                                        for ($i = 0; $i < sizeof($array_tipos_documentos); ++$i) {
                                            if ($necropapiloscopia_documento_tipo == $array_tipos_documentos[$i]) {
                                                echo '<option value="' . $array_tipos_documentos[$i] . '" selected>' . $array_tipos_documentos[$i] . '</option>';
                                            } else {
                                                echo '<option value="' . $array_tipos_documentos[$i] . '">' . $array_tipos_documentos[$i] . '</option>';
                                            }
                                        }
                                        ?>
                                        <input name="necropapiloscopia_documento_numero" type="text" class="col-md-4 form-control" placeholder="Nº" value="<?php echo $necropapiloscopia_documento_numero; ?>" required>
                                        <input name="necropapiloscopia_documento_orgao" type="text" class="col-md-4 form-control" placeholder="ORGÃO" value="<?php echo $necropapiloscopia_documento_orgao; ?>" required>
                                        <input name="necropapiloscopia_documento_uf" type="text" class="col-md-1 form-control" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_documento_uf; ?>" maxlength="2" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Observações</label>
                                    <input name="necropapiloscopia_observacoes" type="text" class="col-md-12 form-control" placeholder="Informe aqui as observações necessárias" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $necropapiloscopia_observacoes; ?>">
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-success">Adicionar</button>
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