<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["requisicao"] == "deletar") {
        $sql_lista_setores_nova_deletar = "DELETE FROM `setores_tb` WHERE `setor_id`='" . $_GET["setorID"] . "'";
        if (mysqli_query($_SG['link'], $sql_lista_setores_nova_deletar)) {
            $sql_lista_setores_nova_deletar = "DELETE FROM `usuarios_tb` WHERE `usuario_setor_id`='" . $_GET["setorID"] . "'";
            if (mysqli_query($_SG['link'], $sql_lista_setores_nova_deletar)) {
                $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
                $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
                $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso! Setor deletado.';
                $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
            } else {
                $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
                $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
                $_SG['status-alert'] = $_SG['status-alert'] . " Error deleting record usuarios_tb: " . mysqli_error($_SG['link']);
                $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
            }
        } else {
            $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
            $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
            $_SG['status-alert'] = $_SG['status-alert'] . " Error deleting record setores_tb: " . mysqli_error($_SG['link']);
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
                <div class="tables">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        <h4>Lista Usuários</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">#</th>
                                    <th style="text-align: center;">Setor</th>
                                    <th style="text-align: center;">Sala</th>
                                    <th style="text-align: center;">Editar</th>
                                    <th style="text-align: center;">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_lista_setores = "SELECT `setor_id`, `setor_nome`, `setor_sala` FROM `setores_tb`";
                                $query_lista_setores = mysqli_query($_SG['link'], $sql_lista_setores);
                                while ($row_lista_setores = mysqli_fetch_assoc($query_lista_setores)) {
                                    echo '<tr>';
                                    echo '<th scope="row" style="text-align: center;">' . $row_lista_setores["setor_id"] . '</th>';
                                    echo '<td style="text-align: center;">' . $row_lista_setores["setor_nome"] . '</td>';
                                    echo '<td style="text-align: center;">' . $row_lista_setores["setor_sala"] . '</td>';
                                    echo '<td style="text-align: center;"><a href="perfilSetor.php?setorID=' . $row_lista_setores["setor_id"] . '"><i class="fa fa-edit"></i></td>';
                                    echo '<td style="text-align: center;"><a href="?requisicao=deletar&setorID=' . $row_lista_setores["setor_id"] . '"><i class="glyphicon glyphicon-remove-circle"></i></a></td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
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