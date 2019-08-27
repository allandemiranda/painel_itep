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
    $sql_hoje_a = "SELECT `mail_id`, `mail_assunto`, `mail_de_usuario_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_data` FROM `mails_tb` WHERE `mail_id`='" . $d . "' AND `mail_de_usuario_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "') ORDER BY `mail_data` DESC";
    $query_hoje_a = mysqli_query($_SG['link'], $sql_hoje_a);
    if (mysqli_num_rows($query_hoje_a) == 1) {
        $sql_deletar = "UPDATE `mails_tb` SET `mail_status_caixa_saida`='0' WHERE `mail_id`='" . $d . "'";
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
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Você não tem permição para deletar este Mail";
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
                <h2 class="title1">Caixa de saída</h2>
                <div class="col-md-12 widget-shadow">
                    <div class="panel-default">
                        <a href="/mailOutbox.php" class="hvr-icon-spin" style="float: right;">Atualizar</a>
                        <div class="inbox-page">
                            <h4>Hoje</h4>
                            <?php
                            $data_hoje = date("Y-m-d") . " 00:00:00";
                            $sql_hoje = "SELECT `mail_id`, `mail_assunto`, `mail_para_setor_id`, `mail_de_usuario_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_data` FROM `mails_tb` WHERE `mail_status_caixa_saida`='1' AND `mail_data`>'" . $data_hoje . "' ORDER BY `mail_data` DESC";
                            $query_hoje = mysqli_query($_SG['link'], $sql_hoje);
                            if (mysqli_num_rows($query_hoje) > 0) {
                                // output data of each row
                                while ($row_hoje = mysqli_fetch_assoc($query_hoje)) {
                                    $sql_verificacao = "SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $row_hoje['mail_de_usuario_id'] . "'";
                                    $query_verificacao = mysqli_query($_SG['link'], $sql_verificacao);
                                    $row_verificacao = mysqli_fetch_assoc($query_verificacao);

                                    $sql_verificacao_um = "SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
                                    $query_verificacao_um = mysqli_query($_SG['link'], $sql_verificacao_um);
                                    $row_verificacao_um = mysqli_fetch_assoc($query_verificacao_um);

                                    if ($row_verificacao["usuario_setor_id"] != $row_verificacao_um["usuario_setor_id"]) {
                                        continue;
                                    }

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
                                    $sql_setor = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_hoje['mail_para_setor_id'] . "'";
                                    $query_setor = mysqli_query($_SG['link'], $sql_setor);
                                    $row_setor = mysqli_fetch_assoc($query_setor);
                                    echo '<p>Para: ' . $row_setor["setor_nome"] . ' - ' . $row_hoje["mail_assunto"] . '</p>';
                                    echo '</div>';
                                    echo '</a>';
                                    echo '<div class="mail-right dots_drop">';
                                    echo '<div class="dropdown">';
                                    echo '<a href="#" data-toggle="dropdown" aria-expanded="false">';
                                    echo '<p><i class="fa fa-ellipsis-v mail-icon"></i></p>';
                                    echo '</a>';
                                    echo '<ul class="dropdown-menu float-right">';
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
                            $sql_hoje = "SELECT `mail_id`, `mail_assunto`, `mail_de_usuario_id`, `mail_para_setor_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_data` FROM `mails_tb` WHERE `mail_status_caixa_saida`='1' AND `mail_data`<'" . $data_hoje . "' ORDER BY `mail_data` DESC";
                            $query_hoje = mysqli_query($_SG['link'], $sql_hoje);
                            if (mysqli_num_rows($query_hoje) > 0) {
                                // output data of each row
                                while ($row_hoje = mysqli_fetch_assoc($query_hoje)) {
                                    $sql_verificacao = "SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $row_hoje['mail_de_usuario_id'] . "'";
                                    $query_verificacao = mysqli_query($_SG['link'], $sql_verificacao);
                                    $row_verificacao = mysqli_fetch_assoc($query_verificacao);

                                    $sql_verificacao_um = "SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
                                    $query_verificacao_um = mysqli_query($_SG['link'], $sql_verificacao_um);
                                    $row_verificacao_um = mysqli_fetch_assoc($query_verificacao_um);

                                    if ($row_verificacao["usuario_setor_id"] != $row_verificacao_um["usuario_setor_id"]) {
                                        continue;
                                    }

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
                                    $sql_setor = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row_hoje['mail_para_setor_id'] . "'";
                                    $query_setor = mysqli_query($_SG['link'], $sql_setor);
                                    $row_setor = mysqli_fetch_assoc($query_setor);
                                    echo '<p>Para: ' . $row_setor["setor_nome"] . ' - ' . $row_hoje["mail_assunto"] . '</p>';
                                    echo '</div>';
                                    echo '</a>';
                                    echo '<div class="mail-right dots_drop">';
                                    echo '<div class="dropdown">';
                                    echo '<a href="#" data-toggle="dropdown" aria-expanded="false">';
                                    echo '<p><i class="fa fa-ellipsis-v mail-icon"></i></p>';
                                    echo '</a>';
                                    echo '<ul class="dropdown-menu float-right">';
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