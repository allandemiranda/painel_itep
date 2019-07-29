<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
log_up("mail-enviado", "Usuário " . $_SESSION['usuarioNome'] . " acessou página " . $_SERVER['REQUEST_URI'] . " no ip " . $_SERVER["REMOTE_ADDR"]);
?>
<?php
if ($_GET["necropapiloscopia_digitais_folha_um"] != "") {
    $PicNum = $_GET["necropapiloscopia_digitais_folha_um"];
    $sql = "SELECT `necropapiloscopia_digitais_folha_um` FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $PicNum . "'";
    $result = mysqli_query($_SG['link'], $sql) or die("Impossível executar a query ");
    $row = mysqli_fetch_object($result);
    Header("Content-type: image/gif");
    echo $row->necropapiloscopia_digitais_folha_um;
}
if ($_GET["necropapiloscopia_digitais_folha_dois"] != "") {
    $PicNum = $_GET["necropapiloscopia_digitais_folha_dois"];
    $sql = "SELECT `necropapiloscopia_digitais_folha_dois` FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $PicNum . "'";
    $result = mysqli_query($_SG['link'], $sql) or die("Impossível executar a query ");
    $row = mysqli_fetch_object($result);
    Header("Content-type: image/gif");
    echo $row->necropapiloscopia_digitais_folha_dois;
}
?>