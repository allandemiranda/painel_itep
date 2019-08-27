<?php
include("segurancaOff.php");
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
    if ($_POST["submit"] == "fichaNormal") {
        $ficha_nome = test_input($_POST["ficha_nome"]);
        $ficha_telefone = test_input($_POST["ficha_telefone"]);
        $ficha_setor_id = test_input($_POST["ficha_setor_id"]);
        $ficha_preferencial = $_POST["ficha_preferencial"];

        if ($ficha_preferencial == "on") {
            $ficha_preferencial = "1";
        } else {
            $ficha_preferencial = "0";
        }

        $ficha_status = "não atendido";
        $ficha_data = date('Y-m-d H:i:s');

        $sql_nova_ficha = "INSERT INTO `fichas_tb`(`ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`) VALUES ('" . $ficha_nome . "','" . $ficha_telefone . "','" . $ficha_setor_id . "','" . $ficha_status . "','" . $ficha_data . "','" . $ficha_preferencial . "')";
        mysqli_query($conn, $sql_nova_ficha);
    }
    if ($_POST["submitNormal"] != "") {
        $ficha_nome = "-";
        $ficha_telefone = "-";
        $ficha_setor_id = test_input($_POST["submitNormal"]);
        $ficha_preferencial = "off";

        if ($ficha_preferencial == "on") {
            $ficha_preferencial = "1";
        } else {
            $ficha_preferencial = "0";
        }

        $ficha_status = "não atendido";
        $ficha_data = date('Y-m-d H:i:s');

        $sql_nova_ficha = "INSERT INTO `fichas_tb`(`ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`) VALUES ('" . $ficha_nome . "','" . $ficha_telefone . "','" . $ficha_setor_id . "','" . $ficha_status . "','" . $ficha_data . "','" . $ficha_preferencial . "')";
        mysqli_query($conn, $sql_nova_ficha);
    }
    if ($_POST["submitPreferencial"] != "") {
        $ficha_nome = "-";
        $ficha_telefone = "-";
        $ficha_setor_id = test_input($_POST["submitPreferencial"]);
        $ficha_preferencial = "on";

        if ($ficha_preferencial == "on") {
            $ficha_preferencial = "1";
        } else {
            $ficha_preferencial = "0";
        }

        $ficha_status = "não atendido";
        $ficha_data = date('Y-m-d H:i:s');

        $sql_nova_ficha = "INSERT INTO `fichas_tb`(`ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_status`, `ficha_data`, `ficha_preferencial`) VALUES ('" . $ficha_nome . "','" . $ficha_telefone . "','" . $ficha_setor_id . "','" . $ficha_status . "','" . $ficha_data . "','" . $ficha_preferencial . "')";
        mysqli_query($conn, $sql_nova_ficha);
    }
}
?>
<?php
$row = $row_setor = "";
if ($_GET['fichaID'] != "") {
    $sql = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_data`, `ficha_preferencial` FROM `fichas_tb` WHERE `ficha_id`='" . $_GET['fichaID'] . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql_setor = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row["ficha_setor_id"] . "' ";
    $result_setor = mysqli_query($conn, $sql_setor);
    $row_setor = mysqli_fetch_assoc($result_setor);
    mysqli_close($conn);
} else {
    $sql = "SELECT `ficha_id`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_data`, `ficha_preferencial` FROM `fichas_tb` WHERE `ficha_id`='" . mysqli_insert_id($conn) . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql_setor = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`='" . $row["ficha_setor_id"] . "' ";
    $result_setor = mysqli_query($conn, $sql_setor);
    $row_setor = mysqli_fetch_assoc($result_setor);
    mysqli_close($conn);
}
?>
<?php
function log_up($conn, $class, $msg)
{
    $div_final = '<div class="sl-item sl-' . $class . '">';
    $div_final .= '<div class="sl-content">';
    $explode_data_completa = explode(" ", date('Y-m-d H:i:s'));
    $explode_data = explode("-", $explode_data_completa[0]);
    $data_final =  $explode_data[2] . "/" . $explode_data[1] . "/" . $explode_data[0] . " " . $explode_data_completa[1];
    $div_final .= '<small class="text-muted">' . $data_final . '</small>';
    $div_final .= '<p>' . $msg . '</p>';
    $div_final .= '</div>';
    $div_final .= '</div>';
    $sql = "INSERT INTO `logs_tb`(`log_data`, `log_div`) VALUES ('" . date('Y-m-d H:i:s') . "', '" . $div_final . "')";
    mysqli_query($conn, $sql);
}
log_up($conn, "login", "Foi impresso ficha para " . $row["ficha_nome"] . " no ip " . $_SERVER["REMOTE_ADDR"]);
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Painel ITEP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 15pt;
            line-height: 1.1;
            margin-top: 1%;
            width: 71mm;
            height: 100%;
            text-align: center;
            word-wrap: break-word;
        }
    </style>
    <script>
        function ClosePrint() {
            setTimeout(function() {
                window.print();
            }, 500);
            window.onfocus = function() {
                setTimeout(function() {
                    window.close();
                }, 500);
            }
        }
    </script>
</head>

<body onload="ClosePrint()">
    <div>
        <div>
            <?php
            $data_quebrada = explode(" ", $row["ficha_data"]);
            $data_final = date('d/m/Y',  strtotime($data_quebrada[0]));
            ?>
            <p><?php echo $data_final . " " . $data_quebrada[1]; ?></p>
        </div>
        <div>
            <?php
            $ultimos3id = substr($row["ficha_id"], -3);
            ?>
            <h1>Senha: <?php echo str_pad($ultimos3id, 3, '0', STR_PAD_LEFT); ?></h1>
        </div>
        <div>
            <p>Nome: <?php echo $row["ficha_nome"]; ?></p>
        </div>
        <div>
            <p>Tel.: <?php echo $row["ficha_telefone"]; ?></p>
        </div>
        <div>
            <p>Atendimento: <?php echo $row_setor["setor_nome"]; ?></p>
        </div>
        <?php
        if ($row["ficha_preferencial"] ==  "1") {
            echo "<div><p><b>PREFERÊNCIAL</b></p></div>";
        }
        ?>
        <div>
            <p>&copy; 2019 All Rights Reserved | Design by Allan de Miranda | allandemiranda.eti.br</p>
        </div>
    </div>
</body>

</html>