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
    $mail_para_setor_id = test_input($_POST["mail_para_setor_id"]);
    $mail_assunto = test_input($_POST["mail_assunto"]);

    $sql_select = "SELECT `usuario_nome` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
    $query_select = mysqli_query($_SG['link'], $sql_select);
    $row_select = mysqli_fetch_assoc($query_select);
    $nome_array = explode(" ", $row_select["usuario_nome"]);

    $mail_conteudo = "<p><b>" . $nome_array[0] . " " . end($nome_array) . "</b>: " . $_POST["mail_conteudo"] . "</p><h5>-</h5>";

    $mail_data = date('Y-m-d H:i:s');

    $sql = "INSERT INTO `mails_tb`(`mail_assunto`, `mail_de_usuario_id`, `mail_para_setor_id`, `mail_conteudo`, `mail_status_caixa_entrada`, `mail_status_caixa_saida`, `mail_data`) VALUES ('" . $mail_assunto . "','" . $_SESSION['usuarioID'] . "','" . $mail_para_setor_id . "','" . $mail_conteudo . "','1','1','" . $mail_data . "')";
    if (mysqli_query($_SG['link'], $sql)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Mail enviado.';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error: " . $sql . "<br>" . mysqli_error($_SG['link']);
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
                <h2 class="title1">Novo Mail</h2>
                <div class="col-md-12 widget-shadow">
                    <div class="panel-default">
                        <div class="panel-body">
                            <div class="alert alert-info">
                                Por favor, preencha todos os campos para enviar uma nova mensagem
                            </div>
                            <form action="" method="POST" class="com-mail">
                                <div class="form-group">
                                    <select name="mail_para_setor_id" class="form-control" type="text">
                                        <?php
                                        $sql_lista_setores = "SELECT `setor_id`, `setor_nome` FROM `setores_tb`";
                                        $query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
                                        while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                            echo '<option value="' . $row_lista_setores["setor_id"] . '">' . $row_lista_setores["setor_nome"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input name="mail_assunto" type="text" class="form-control1 control3" placeholder="Assunto:">
                                <textarea name="mail_conteudo" rows="6" class="form-control1 control2 ckeditor" placeholder="Mensagem:"></textarea>
                                <input style="font-size: 0.9em;
                                background-color: #255a87;
                                border: 1px solid #255a87;
                                color: #fff;
                                padding: 0.4em 1em;
                                margin-top: 1em;" type="submit" value="Enviar">
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