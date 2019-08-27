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

if ($_GET["d"] != "") {
    $d = test_input($_GET["d"]);
    $sql_hoje_a = "SELECT `mail_id`, `mail_assunto`, `mail_de_usuario_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_data` FROM `mails_tb` WHERE `mail_id`='" . $d . "' AND `mail_para_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `mail_data` DESC";
    $query_hoje_a = mysqli_query($_SG['link'], $sql_hoje_a);
    if (mysqli_num_rows($query_hoje_a) == 1) {
        $sql_deletar = "UPDATE `mails_tb` SET `mail_status_caixa_entrada`='0' WHERE `mail_id`='" . $d . "'";
        if (mysqli_query($_SG['link'], $sql_deletar)) {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Mail deletado.';
            $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
            log_up("primary", "Usuário " . $_SESSION['usuarioNome'] . " deletou Mail de ID " . $d . " no ip " . $_SERVER["REMOTE_ADDR"]);
        } else {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . " Error deleting record usuarios_tb: " . mysqli_error($_SG['link']);
            $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail_id = test_input($_POST["mail_id"]);
    $mail_re_id_setor = test_input($_POST["mail_re_id_setor"]);

    $sql_select = "SELECT `usuario_nome` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
    $query_select = mysqli_query($_SG['link'], $sql_select);
    $row_select = mysqli_fetch_assoc($query_select);
    $nome_array = explode(" ", $row_select["usuario_nome"]);
    $mail_re_conteudo = "<p>(RE) <b>" . $nome_array[0] . " " . end($nome_array) . "</b>: " . $_POST["mail_re_conteudo"] . "</p><h5>-</h5>";

    $sql_select = "SELECT `mail_conteudo` FROM `mails_tb` WHERE `mail_id`='" . $mail_id . "'";
    $query_select = mysqli_query($_SG['link'], $sql_select);
    $row_select = mysqli_fetch_assoc($query_select);
    $mail_conteudo_final = $row_select["mail_conteudo"] . " " . $mail_re_conteudo;

    $sql_resposta = "UPDATE `mails_tb` SET `mail_conteudo`='" . $mail_conteudo_final . "',`mail_data`='" . date('Y-m-d H:i:s') . "', `mail_para_setor_id`='" . $mail_re_id_setor . "' ,`mail_de_usuario_id`='" . $_SESSION['usuarioID'] . "',`mail_status_caixa_entrada`='1', `mail_status_caixa_saida`='1' WHERE `mail_id`='" . $mail_id . "'";
    if (mysqli_query($_SG['link'], $sql_resposta)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Mail enviado.';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
        log_up("criou", "Usuário " . $_SESSION['usuarioNome'] . " respondeu a Mail de ID " . $mail_id . " para setor " . $mail_re_id_setor . " no ip " . $_SERVER["REMOTE_ADDR"]);
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error deleting record usuarios_tb: " . mysqli_error($_SG['link']);
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
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
                <h2 class="title1">Caixa de entrada</h2>
                <div class="col-md-12 widget-shadow">
                    <div class="panel-default">
                        <a href="/mailInbox.php" class="hvr-icon-spin" style="float: right;">Atualizar</a>
                        <div class="inbox-page">
                            <h4>Hoje</h4>
                            <?php
                            $data_hoje = date("Y-m-d") . " 00:00:00";
                            $sql_hoje = "SELECT `mail_id`, `mail_assunto`, `mail_de_usuario_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_data` FROM `mails_tb` WHERE `mail_status_caixa_entrada`='1' AND `mail_data`>'" . $data_hoje . "' AND `mail_para_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `mail_data` DESC";
                            $query_hoje = mysqli_query($_SG['link'], $sql_hoje);
                            if (mysqli_num_rows($query_hoje) > 0) {
                                // output data of each row
                                while ($row_hoje = mysqli_fetch_assoc($query_hoje)) {
                                    echo '<div class="inbox-row widget-shadow" id="accordion" role="tablist" aria-multiselectable="true">';
                                    echo '<div class="mail "> <span class="glyphicon glyphicon-alert"></span> </div>';
                                    echo '<div class="mail"></div>';
                                    echo '<div class="mail mail-name">';
                                    $sql_nome = "SELECT `usuario_nome`, `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $row_hoje['mail_de_usuario_id'] . "'";
                                    $query_nome = mysqli_query($_SG['link'], $sql_nome);
                                    $row_nome = mysqli_fetch_assoc($query_nome);
                                    $nome_array = explode(" ", $row_nome["usuario_nome"]);
                                    echo '<h6>' . $nome_array[0] . ' ' . end($nome_array) . '</h6>';
                                    $sql_setor = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_nome['usuario_setor_id'] . "'";
                                    $query_setor = mysqli_query($_SG['link'], $sql_setor);
                                    $row_setor = mysqli_fetch_assoc($query_setor);
                                    echo '<h5>' . $row_setor["setor_nome"] . '</h5>';
                                    echo '</div>';
                                    echo '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row_hoje["mail_id"] . 'h" aria-expanded="true" aria-controls="collapse' . $row_hoje["mail_id"] . 'h">';
                                    echo '<div class="mail">';
                                    echo '<p>' . $row_hoje["mail_assunto"] . '</p>';
                                    echo '</div>';
                                    echo '</a>';
                                    echo '<div class="mail-right dots_drop">';
                                    echo '<div class="dropdown">';
                                    echo '<a href="#" data-toggle="dropdown" aria-expanded="false">';
                                    echo '<p><i class="fa fa-ellipsis-v mail-icon"></i></p>';
                                    echo '</a>';
                                    echo '<ul class="dropdown-menu float-right">';
                                    echo '<li>';
                                    echo '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row_hoje["mail_id"] . 'h" aria-expanded="true" aria-controls="collapse' . $row_hoje["mail_id"] . 'h">';
                                    echo '<i class="fa fa-reply mail-icon"></i>';
                                    echo 'Responder';
                                    echo '</a>';
                                    echo '</li>';
                                    echo '<li>';
                                    echo '<a href="?d=' . $row_hoje["mail_id"] . '" class="font-red" title="">';
                                    echo '<i class="fa fa-trash-o mail-icon"></i>';
                                    echo 'Deletar';
                                    echo '</a>';
                                    echo '</li>';
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<div class="mail-right">';
                                    $data_quebrada = explode(" ", $row_hoje["mail_data"]);
                                    $data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
                                    echo '<p>' . $data_final . ' ' . $data_quebrada[1] . '</p>';
                                    echo '</div>';
                                    echo '<div class="clearfix"> </div>';
                                    echo '<div id="collapse' . $row_hoje["mail_id"] . 'h" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $row_hoje["mail_id"] . 'h">';
                                    echo '<div class="mail-body">';
                                    echo $row_hoje["mail_conteudo"];
                                    echo '<form action="" method="POST" name="resposta">';
                                    echo '<input name="mail_id" value="' . $row_hoje['mail_id'] . '" hidden>';
                                    echo '<input name="mail_re_id_setor" value="' . $row_nome['usuario_setor_id'] . '" hidden>';
                                    //echo '<input name="mail_re_conteudo" type="text" placeholder="Responder ao remetente" required="">';
                                    echo '<textarea name="mail_re_conteudo" placeholder="Responder ao remetente" class="form-control1 control2 ckeditor" ></textarea>';
                                    echo '<input type="submit" value="Enviar">';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="inbox-page row">
                            <h4>Outras Mensagens</h4>
                            <?php
                            $data_hoje = date("Y-m-d") . " 00:00:00";
                            $sql_hoje = "SELECT `mail_id`, `mail_assunto`, `mail_de_usuario_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_data` FROM `mails_tb` WHERE `mail_status_caixa_entrada`='1' AND `mail_data`<'" . $data_hoje . "' AND `mail_para_setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `mail_data` DESC";
                            $query_hoje = mysqli_query($_SG['link'], $sql_hoje);
                            if (mysqli_num_rows($query_hoje) > 0) {
                                // output data of each row
                                while ($row_hoje = mysqli_fetch_assoc($query_hoje)) {
                                    echo '<div class="inbox-row widget-shadow" id="accordion" role="tablist" aria-multiselectable="true">';
                                    echo '<div class="mail "> <span class="glyphicon glyphicon-alert"></span> </div>';
                                    echo '<div class="mail"></div>';
                                    echo '<div class="mail mail-name">';
                                    $sql_nome = "SELECT `usuario_nome`, `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $row_hoje['mail_de_usuario_id'] . "'";
                                    $query_nome = mysqli_query($_SG['link'], $sql_nome);
                                    $row_nome = mysqli_fetch_assoc($query_nome);
                                    $nome_array = explode(" ", $row_nome["usuario_nome"]);
                                    echo '<h6>' . $nome_array[0] . ' ' . end($nome_array) . '</h6>';
                                    $sql_setor = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_nome['usuario_setor_id'] . "'";
                                    $query_setor = mysqli_query($_SG['link'], $sql_setor);
                                    $row_setor = mysqli_fetch_assoc($query_setor);
                                    echo '<h5>' . $row_setor["setor_nome"] . '</h5>';
                                    echo '</div>';
                                    echo '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row_hoje["mail_id"] . 'o" aria-expanded="true" aria-controls="collapse' . $row_hoje["mail_id"] . 'o">';
                                    echo '<div class="mail">';
                                    echo '<p>' . $row_hoje["mail_assunto"] . '</p>';
                                    echo '</div>';
                                    echo '</a>';
                                    echo '<div class="mail-right dots_drop">';
                                    echo '<div class="dropdown">';
                                    echo '<a href="#" data-toggle="dropdown" aria-expanded="false">';
                                    echo '<p><i class="fa fa-ellipsis-v mail-icon"></i></p>';
                                    echo '</a>';
                                    echo '<ul class="dropdown-menu float-right">';
                                    echo '<li>';
                                    echo '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row_hoje["mail_id"] . 'o" aria-expanded="true" aria-controls="collapse' . $row_hoje["mail_id"] . 'o">';
                                    echo '<i class="fa fa-reply mail-icon"></i>';
                                    echo 'Responder';
                                    echo '</a>';
                                    echo '</li>';
                                    echo '<li>';
                                    echo '<a href="?d=' . $row_hoje["mail_id"] . '" class="font-red" title="">';
                                    echo '<i class="fa fa-trash-o mail-icon"></i>';
                                    echo 'Deletar';
                                    echo '</a>';
                                    echo '</li>';
                                    echo '</ul>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<div class="mail-right">';
                                    $data_quebrada = explode(" ", $row_hoje["mail_data"]);
                                    $data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
                                    echo '<p>' . $data_final . ' ' . $data_quebrada[1] . '</p>';
                                    echo '</div>';
                                    echo '<div class="clearfix"> </div>';
                                    echo '<div id="collapse' . $row_hoje["mail_id"] . 'o" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $row_hoje["mail_id"] . 'o">';
                                    echo '<div class="mail-body">';
                                    echo $row_hoje["mail_conteudo"];
                                    echo '<form action="" method="POST" name="resposta">';
                                    echo '<input name="mail_id" value="' . $row_hoje['mail_id'] . '" hidden>';
                                    echo '<input name="mail_re_id_setor" value="' . $row_nome['usuario_setor_id'] . '" hidden>';
                                    echo '<input name="mail_re_conteudo" type="text" placeholder="Responder ao remetente" required="">';
                                    //echo '<textarea class="ckeditor" name="content" ></textarea>';
                                    echo '<input type="submit" value="Enviar">';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            ?>
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