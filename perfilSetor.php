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
$setor_id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $setor_id = test_input($_POST["setor_id"]);
    $setor_nome = test_input($_POST["setor_nome"]);
    $setor_sala = test_input($_POST["setor_sala"]);
    $setor_hall = $_POST["setor_hall"];
    $setor_admin = $_POST["setor_admin"];
    $setor_acessibilidade_cor = $_POST["setor_acessibilidade_cor"];
    $setor_acessibilidade_check = $_POST["setor_acessibilidade_check"];

    if ($setor_hall == "on") {
        $setor_hall = "1";
    } else {
        $setor_hall = "0";
    }

    if ($setor_admin == "on") {
        $setor_admin = "1";
    } else {
        $setor_admin = "0";
    }

    if ($setor_acessibilidade_check == "on") {
        $setor_acessibilidade_check = "1";
    } else {
        $setor_acessibilidade_check = "0";
    }

    $sql_perfil_setor_modificar = "UPDATE `setores_tb` SET `setor_nome`='" . $setor_nome . "',`setor_sala`='" . $setor_sala . "',`setor_hall`='" . $setor_hall . "',`setor_admin`='" . $setor_admin . "',`setor_acessibilidade_cor`='" . $setor_acessibilidade_cor . "',`setor_acessibilidade_check`='" . $setor_acessibilidade_check . "' WHERE `setor_id`='" . $setor_id . "'";

    if (mysqli_query($_SG['link'], $sql_perfil_setor_modificar)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário <b>' . $setor_nome . '</b> modificado.';
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
                <div class="forms">
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Perfil Setor </h4>
                        </div>
                        <div class="form-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <?php
                                if ($setor_id == "") {
                                    $setor_id = $_GET["setorID"];
                                }
                                $sql_perfil_setor_selecionar = "SELECT `setor_id`, `setor_nome`, `setor_sala`, `setor_hall`, `setor_admin`,`setor_acessibilidade_check` FROM `setores_tb` WHERE `setor_id`='" . $setor_id . "'";
                                $query_perfil_setor_selecionar = mysqli_query($_SG['link'], $sql_perfil_setor_selecionar);
                                $row_perfil_setor_selecionar = mysqli_fetch_assoc($query_perfil_setor_selecionar);
                                ?>
                                <input name="setor_id" value="<?php echo $row_perfil_setor_selecionar['setor_id']; ?>" hidden>
                                <div class="form-group">
                                    <label>Nome do Setor</label>
                                    <input name="setor_nome" type="text" class="form-control" placeholder="Nome do Setor" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row_perfil_setor_selecionar['setor_nome']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Sala</label>
                                    <input name="setor_sala" type="text" class="form-control" value="<?php echo $row_perfil_setor_selecionar['setor_sala']; ?>" placeholder="Sala do Setor" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="setor_hall" type="checkbox" class="checkbox" placeholder="Sala do Setor" <?php if ($row_perfil_setor_selecionar['setor_hall']) {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>>
                                        Atendimento Hall
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="setor_admin" type="checkbox" class="checkbox" placeholder="Sala do Setor" <?php if ($row_perfil_setor_selecionar['setor_admin']) {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>>
                                        Setor administrador do sistema
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="setor_acessibilidade_check" type="checkbox" class="checkbox" placeholder="Sala do Setor" <?php if ($row_perfil_setor_selecionar['setor_acessibilidade_check']) {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?>>
                                        Chamador com acessibilidade
                                    </label>
                                </div>
                                <div class="form-group" id="acessibilidade">
                                    <label>
                                        Cor do botão:
                                    </label>
                                    <label>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#1E252F" checked> <a style="color:white; background-color: #1E252F;">#1E252F</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#0E8F9F"> <a style="color:white; background-color: #0E8F9F;">#0E8F9F</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#32C867"> <a style="color:white; background-color: #32C867;">#32C867</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#32C8A3"> <a style="color:white; background-color: #32C8A3;">#32C8A3</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#FF5D25"> <a style="color:white; background-color: #FF5D25;">#FF5D25</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#EB3E28"> <a style="color:white; background-color: #EB3E28;">#EB3E28</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#FDAE2D"> <a style="color:white; background-color: #FDAE2D;">#FDAE2D</a>
                                        <input type="radio" name="setor_acessibilidade_cor" value="#5B479F"> <a style="color:white; background-color: #5B479F;">#5B479F</a>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success">Salvar</button>
                                <a href="listaSetor.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
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