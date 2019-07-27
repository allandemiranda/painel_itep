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
    if (test_input($_POST["usuario_senha"]) != "") {
        $usuario_cargo = test_input($_POST["usuario_cargo"]);
        $usuario_setor_id = test_input($_POST["usuario_setor_id"]);
        $usuario_senha = test_input($_POST["usuario_senha"]);
        $usuario_matricula = test_input(($_POST["usuario_matricula"]));

        $usuario_senha = md5($usuario_senha);

        $usuario_update_data = date('Y-m-d H:i:s');

        $sql_adicionar_novo_usurio = "UPDATE `usuarios_tb` SET `usuario_matricula` = '" . $usuario_matricula . "', `usuario_cargo`='" . $usuario_cargo . "',`usuario_setor_id`='" . $usuario_setor_id . "',`usuario_senha`='" . $usuario_senha . "',`usuario_update_data`='" . $usuario_update_data . "' WHERE usuario_id='" . $_SESSION['usuarioID'] . "'";

        if (mysqli_query($_SG['link'], $sql_adicionar_novo_usurio)) {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário <b>' . $_SG['topBar']['usuario_nome'] . '</b> modificado.';
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
        $_SG['status-alert'] = $_SG['status-alert'] . " Error! A senha deve conter algum valor.";
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
                            <h4>Novo Usuário </h4>
                        </div>
                        <div class="form-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <?php
                                $sql_perfilUsuario = "SELECT `usuario_matricula`, `usuario_nome`, `usuario_cargo`, `usuario_setor_id`, `usuario_login` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
                                $query_perfilUsuario = mysqli_query($_SG['link'], $sql_perfilUsuario);
                                $row_perfilUsuario = mysqli_fetch_assoc($query_perfilUsuario);
                                ?>
                                <div class="col-md-12 form-group">
                                    <label>Nome</label>
                                    <input name="usuario_nome" type="text" class="col-md-12 form-control" placeholder="Nome completo" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row_perfilUsuario['usuario_nome']; ?>" disabled>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Cargo</label>
                                    <input name="usuario_cargo" type="text" class="col-md-12 form-control" placeholder="Cargo" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row_perfilUsuario['usuario_cargo']; ?>" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Setor</label>
                                    <select name="usuario_setor_id" class="col-md-12 form-control" type="text">
                                        <?php
                                        $sql_lista_setores = "SELECT `setor_id`, `setor_nome`, `setor_sala` FROM `setores_tb` ORDER BY `setor_nome` ASC";
                                        $query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
                                        while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                            if ($row_lista_setores["setor_id"] == $row_perfilUsuario['usuario_setor_id']) {
                                                echo '<option value="' . $row_lista_setores["setor_id"] . '" selected>' . $row_lista_setores["setor_nome"] . ' (' . $row_lista_setores["setor_sala"] . ')</option>';
                                            } else {
                                                echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . ' (' . $row_lista_setores["setor_sala"] . ')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Matrícula</label>
                                    <input name="usuario_matricula" type="text" class="col-md-12 form-control" value="<?php echo $row_perfilUsuario['usuario_matricula']; ?>" placeholder="000.00-0" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Login</label>
                                    <input name="usuario_login" type="text" class="form-control" placeholder="Nome completo" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row_perfilUsuario['usuario_login']; ?>" disabled>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Senha</label>
                                    <input name="usuario_senha" type="password" class="form-control" placeholder="Senha" value="" required>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Salvar</button>
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