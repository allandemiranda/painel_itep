<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
log_up("mail-enviado", "Usuário " . $_SESSION['usuarioNome'] . " acessou página " . $_SERVER['REQUEST_URI'] . " no ip " . $_SERVER["REMOTE_ADDR"]);
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
            <div class="main-page">
                <div class="col-sm-12 w3-agile-crd widgettable">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="">
                                <header class="widget-header">
                                    <h4 class="widget-title">Atividade no Sistema</h4>
                                </header>
                                <hr class="widget-separator">
                                <div class="widget-body">
                                    <div class="streamline">
                                        <?php
                                        $pg_num = $_GET["pg_num"];
                                        if ($_GET["pg_num"] == "") {
                                            $pg_num = 1;
                                        }
                                        $sql_num_of_doc = "SELECT `log_id` FROM `logs_tb` ORDER BY `log_id` DESC LIMIT 1";
                                        $query_num_of_doc = mysqli_query($_SG['link'], $sql_num_of_doc);
                                        $row_num_of_doc = mysqli_fetch_assoc($query_num_of_doc);
                                        $pg_num_of_doc = $row_num_of_doc["log_id"];
                                        $size_page = 21; //(-1)
                                        $primeiro_doc = $pg_num_of_doc - (($pg_num - 1) * $size_page);
                                        $ultimo_doc = $primeiro_doc - $size_page + 1;

                                        $sql_lista = "SELECT * FROM `logs_tb` WHERE `log_id` BETWEEN '" . $ultimo_doc . "' AND '" . $primeiro_doc . "' ORDER BY `log_id` DESC";
                                        $query_lista = mysqli_query($_SG['link'], $sql_lista);
                                        while ($row_lista = mysqli_fetch_assoc($query_lista)) {
                                            echo $row_lista["log_div"];
                                        }
                                        ?>
                                        <nav>
                                            <ul class="pagination">
                                                <?php
                                                if ($pg_num == 1) {
                                                    echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                                } else {
                                                    echo '<li><a href="?pg_num=' . ($pg_num - 1) . '" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                                }
                                                if ($ultimo_doc <= 1) {
                                                    echo '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                                } else {
                                                    echo '<li><a href="?pg_num=' . ($pg_num + 1) . '" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                                }
                                                ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
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