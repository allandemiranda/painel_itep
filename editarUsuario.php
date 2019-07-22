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
    $usuario_id = test_input($_POST["usuario_id"]);
    $usuario_cargo = test_input($_POST["usuario_cargo"]);
    $usuario_setor = test_input($_POST["usuario_setor"]);

    $sql_adicionar_novo_usurio = "UPDATE `usuarios_tb` SET `usuario_cargo`='" . $usuario_cargo . "',`usuario_setor_id`='" . $usuario_setor . "' WHERE usuario_id='" . $usuario_id . "'";

    if (mysqli_query($_SG['link'], $sql_adicionar_novo_usurio)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário <b>' . $_POST["usuario_nome"] . '</b> editado.';
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
                            <h4>Novo Usuário </h4>
                        </div>
                        <div class="form-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <?php
                                $sql_usuario_editar = "SELECT `usuario_id`, `usuario_nome`, `usuario_cargo`, `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_GET['usuarioID'] . "'";
                                $query_usuario_editar = mysqli_query($_SG['link'], $sql_usuario_editar);
                                $row_usuario_editar = mysqli_fetch_assoc($query_usuario_editar);
                                ?>
                                <input name="usuario_id" value="<?php echo $row_usuario_editar['usuario_id']; ?>" hidden>
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input name="usuario_nome" type="text" class="form-control" placeholder="Nome completo" onChange="javascript:this.value=this.value.toUpperCase();" value="<?php echo $row_usuario_editar['usuario_nome']; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Cargo</label>
                                    <input name="usuario_cargo" type="text" class="form-control" value="<?php echo $row_usuario_editar['usuario_cargo']; ?>" placeholder="Cargo" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="form-group">
                                    <label>Setor</label>
                                    <select name="usuario_setor" class="form-control" type="text">
                                        <?php
                                        $sql_lista_setores = "SELECT `setor_id`, `setor_nome` FROM `setores_tb`";
                                        $query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
                                        while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                            if ($row_usuario_editar['usuario_id'] = $row_lista_setores["setor_id"]) {
                                                echo '<option value="' . $row_lista_setores["setor_id"] . '" selected>' . $row_lista_setores["setor_nome"] . '</option>';
                                            } else {
                                                echo '<option value="' . $row_lista_setores["setor_id"] . '" >' . $row_lista_setores["setor_nome"] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Editar</button>
                                <a href="/"><button type="button" class="btn btn-danger">Cancelar</button></a>
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