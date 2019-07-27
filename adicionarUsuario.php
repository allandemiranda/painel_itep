<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
exigirAdmin();
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
    $usuario_nome = test_input($_POST["usuario_nome"]);
    $usuario_cargo = test_input($_POST["usuario_cargo"]);
    $usuario_setor_id = test_input($_POST["usuario_setor_id"]);
    $usuario_senha = test_input($_POST["usuario_senha"]);
    $usuario_matricula = test_input(($_POST["usuario_matricula"]));

    $usuario_senha = md5($usuario_senha);

    $usuario_nome_low = strtolower($usuario_nome);
    $usuario_nome_array = explode(" ", $usuario_nome_low);
    $usuario_login = $usuario_nome_array[0] . "." . end($usuario_nome_array);

    $cont_login_erro = 1;
    $usuario_login_temp = $usuario_login;
    while (true) {
        $sql_logn_temp = "SELECT `usuario_id` FROM `usuarios_tb` WHERE `usuario_login`='" . $usuario_login_temp . "'";
        $result_login_temp = mysqli_query($_SG['link'], sql_logn_temp);
        if (mysqli_num_rows($result_login_temp) > 0) {
            $usuario_login_temp = $usuario_login . "." . $cont_login_erro;
            $cont_login_erro++;
        } else {
            $usuario_login = $usuario_login_temp;
            break;
        }
    }

    $usuario_update_data = date('Y-m-d H:i:s');

    $sql_adicionar_novo_usurio = "INSERT INTO `usuarios_tb`(`usuario_nome`, `usuario_cargo`, `usuario_matricula`, `usuario_setor_id`, `usuario_login`, `usuario_senha`, `usuario_update_data`) VALUES ('" . $usuario_nome . "','" . $usuario_cargo . "','" . $usuario_matricula . "','" . $usuario_setor_id . "','" . $usuario_login . "','" . $usuario_senha . "','" . $usuario_update_data . "')";

    if (mysqli_query($_SG['link'], $sql_adicionar_novo_usurio)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Usuário <b>' . $usuario_nome . '</b> adicionado. Seu login é <b>' . $usuario_login . '</b> .';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error: " . $sql_adicionar_novo_usurio . "<br>" . mysqli_error($_SG['link']);
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
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input name="usuario_nome" type="text" class="col-md-12 form-control" placeholder="Nome completo" onChange="javascript:this.value=this.value.toUpperCase();" value="" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Cargo</label>
                                    <input name="usuario_cargo" type="text" class="col-md-12 form-control" value="" placeholder="Cargo" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Matrícula</label>
                                    <input name="usuario_matricula" type="text" class="col-md-12 form-control" value="" placeholder="000.00-0" onChange="javascript:this.value=this.value.toUpperCase();" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Setor</label>
                                    <select name="usuario_setor_id" class="col-md-12 form-control" type="text">
                                        <?php
                                        $sql_lista_setores = "SELECT `setor_id`, `setor_nome`, `setor_sala` FROM `setores_tb` ORDER BY `setor_nome` ASC";
                                        $query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
                                        while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                            echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . ' (' . $row_lista_setores["setor_sala"] . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Senha</label>
                                    <input name="usuario_senha" type="password" class="form-control" placeholder="Senha" value="" required>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Criar</button>
                                    <a href="listaUsuario.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
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