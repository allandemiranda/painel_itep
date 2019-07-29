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
    if ($_POST["senha"] == $_POST["usuario_senha"]) {
        $senha = test_input($_POST["senha"]);
        $usuario_senha = test_input($_POST["usuario_senha"]);
        $usuario_nome = test_input($_POST["usuario_nome"]);
        $usuario_cargo = test_input($_POST["usuario_cargo"]);
        $usuario_setor_id = test_input($_POST["usuario_setor_id"]);
        $usuario_senha = md5($usuario_senha);
        $usuario_update_data = date('Y-m-d H:i:s');
        $sql_update = "UPDATE `usuarios_tb` SET `usuario_nome`='" . $usuario_nome . "',`usuario_cargo`='" . $usuario_cargo . "',`usuario_setor_id`='" . $usuario_setor_id . "',`usuario_senha`='" . $usuario_senha . "',`usuario_update_data`='" . $usuario_update_data . "',`usuario_cadastrado`='1' WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
        if (mysqli_query($_SG['link'], $sql_update)) {
            log_up("success", "Usuário " . $usuario_nome . " de cargo " . $usuario_cargo . " efetuou cadastro. IP:" . $_SERVER["REMOTE_ADDR"]);
            expulsaVisitanteCadastro();
        } else {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . " Error updating record: " . mysqli_error($_SG['link']);
            $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
        }
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error! Senhas digitadas não coincidem. ";
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    }
}

$sql_cadastro = "SELECT `usuario_nome`, `usuario_cargo`, `usuario_login`, `usuario_cadastrado` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
$query_cadastro = mysqli_query($_SG['link'], $sql_cadastro);
$row_cadastro = mysqli_fetch_assoc($query_cadastro);
if ($row_cadastro["usuario_cadastrado"] == 1) {
    header("Location: index.php");
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
    <script>
        function validarSenha() {
            senha = document.getElementById("senha").value;
            senha_dois = document.getElementById("confirmar_senha").value;
            if (senha != senha_dois) {
                senha2.setCustomValidity("Senhas diferentes!");
                return false;
            }
            return true;
        }
    </script>
</head>

<body class="">
    <div class="main-content">
        <!-- main content start-->
        <div id="page-wrapper">
            <?php
            echo $_SG['status-alert'];
            ?>
            <div class="alert alert-info alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>
                Info! Todas as informações contidas aqui foram coletadas do portal da transparência do governo do estado do RN.
            </div>
            <div class="main-page signup-page">
                <h2 class="title1">Formulário</h2>
                <div class="sign-up-row widget-shadow">
                    <h5>Informações pessoais :</h5>
                    <form action="" method="POST">
                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>
                            Alerta! Verifique se seu nome está correto, se possui todos os acentos e sobrenomes, pois não será mais possível modifica-lo.
                        </div>
                        <label>Seu Nome Completo:</label>
                        <div class="sign-u">
                            <input type="text" name="usuario_nome" value="<?php echo $row_cadastro["usuario_nome"]; ?>" placeholder="Nome completo" onChange="javascript:this.value=this.value.toUpperCase();" required="">
                            <div class="clearfix"> </div>
                        </div>
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>
                            Info! Verifique se seu cargo está correto.
                        </div>
                        <label>Seu Cargo:</label>
                        <div class="sign-u">
                            <input name="usuario_cargo" type="text" value="<?php echo $row_cadastro["usuario_cargo"]; ?>" placeholder="Seu cargo" onChange="javascript:this.value=this.value.toUpperCase();" required="">
                            <div class="clearfix"> </div>
                        </div>
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>
                            Info! Selecione seu setor. Lembre-se que este deve ser referente a sua sala de trabalho.
                        </div>
                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>
                            Alerta! Caso seu setor não esteja na lista, solicite ao responsável pelo setor o cadastramento, e cancele este formulário fechando esta página <a href="?status=logout">aqui</a>.
                        </div>
                        <label>Seu Setor:</label>
                        <div class="form-group">
                            <select name="usuario_setor_id" class="form-control" type="text">
                                <?php
                                $sql_lista_setores = "SELECT `setor_id`, `setor_nome`, `setor_sala` FROM `setores_tb` ORDER BY `setor_nome` ASC";
                                $query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
                                while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                    echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . ' (' . $row_lista_setores["setor_sala"] . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <h6>Login Information :</h6>
                        <label>Login:</label>
                        <div class="sign-u">
                            <input name="usuario_login" type="text" value="<?php echo $row_cadastro["usuario_login"]; ?>" disabled>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>
                            Info! Digite uma nova senha de no mínimo 5 dígitos.
                        </div>
                        <label>Nova Senha:</label>
                        <div class="sign-u">
                            <input minlength="5" name="senha" type="password" placeholder="Nova senha" required="">
                            <div class="clearfix"> </div>
                        </div>
                        <label>Confirme Senha:</label>
                        <div class="sign-u">
                            <input minlength="5" name="usuario_senha" type="password" placeholder="Confirmar senha" required="">
                        </div>
                        <div class="clearfix"> </div>
                        <div class="sub_home">
                            <input name="submit" type="submit" value="Cadastrar" style="display: inline;">
                        </div>
                        <div class="clearfix"> </div>
                    </form>
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