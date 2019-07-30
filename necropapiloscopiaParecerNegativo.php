<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
log_up("login", "Usuário " . $_SESSION['usuarioNome'] . " acessou página de impreção de documento da necropapiloscopia no endereço " . $_SERVER['REQUEST_URI'] . " no ip " . $_SERVER["REMOTE_ADDR"]);
function verificarSetorNecropapiloscopia()
{
    global $_SG;
    $sql_user = "SELECT `setor_nome` FROM `setores_tb` WHERE `setor_id`=(SELECT `usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
    $query_user = mysqli_query($_SG['link'], $sql_user);
    $row_user = mysqli_fetch_assoc($query_user);
    if ($row_user["setor_nome"] == "NECROPAPILOSCOPIA") {
        return true;
    } else {
        return false;
    }
}
?>
<?php
/**
 * Converter TimeStamp para data em Português
 *
 * @param integer $timestamp Unix timestamp
 * @param boolean $hours Se "true" devolve também as horas
 * @param string $timeZone Zona a utilizar para gerar as horas
 *
 * @return string
 */
function dataEmPortugues($timestamp, $hours = FALSE, $timeZone = "Europe/Lisbon")
{

    $dia_num = date("w", $timestamp); // Dia da semana.

    if ($dia_num == 0) {
        $dia_nome = "Domingo";
    } elseif ($dia_num == 1) {
        $dia_nome = "Segunda";
    } elseif ($dia_num == 2) {
        $dia_nome = "Terça";
    } elseif ($dia_num == 3) {
        $dia_nome = "Quarta";
    } elseif ($dia_num == 4) {
        $dia_nome = "Quinta";
    } elseif ($dia_num == 5) {
        $dia_nome = "Sexta";
    } else {
        $dia_nome = "Sábado";
    }

    $dia_mes = date("d", $timestamp); // Dia do mês

    $mes_num = date("m", $timestamp); // Nome do mês

    if ($mes_num == "01") {
        $mes_nome = "Janeiro";
    } elseif ($mes_num == "02") {
        $mes_nome = "Fevereiro";
    } elseif ($mes_num == "03") {
        $mes_nome = "Março";
    } elseif ($mes_num == "04") {
        $mes_nome = "Abril";
    } elseif ($mes_num == "05") {
        $mes_nome = "Maio";
    } elseif ($mes_num == "06") {
        $mes_nome = "Junho";
    } elseif ($mes_num == "07") {
        $mes_nome = "Julho";
    } elseif ($mes_num == "08") {
        $mes_nome = "Agosto";
    } elseif ($mes_num == "09") {
        $mes_nome = "Setembro";
    } elseif ($mes_num == "10") {
        $mes_nome = "Outubro";
    } elseif ($mes_num == "11") {
        $mes_nome = "Novembro";
    } else {
        $mes_nome = "Dezembro";
    }
    $ano = date("Y", $timestamp); // Ano

    date_default_timezone_set($timeZone); // Set time-zone
    $hora = date("H:i", $timestamp);

    if ($hours) {
        return $dia_nome . ", " . $dia_mes . " de " . $mes_nome . " de " . $ano . " - " . $hora;
    } else {
        return $dia_nome . ", " . $dia_mes . " de " . $mes_nome . " de " . $ano;
    }
}

function mesData($mes_num)
{
    if ($mes_num == "01") {
        return "Janeiro";
    } elseif ($mes_num == "02") {
        return "Fevereiro";
    } elseif ($mes_num == "03") {
        return "Março";
    } elseif ($mes_num == "04") {
        return "Abril";
    } elseif ($mes_num == "05") {
        return "Maio";
    } elseif ($mes_num == "06") {
        return "Junho";
    } elseif ($mes_num == "07") {
        return "Julho";
    } elseif ($mes_num == "08") {
        return "Agosto";
    } elseif ($mes_num == "09") {
        return "Setembro";
    } elseif ($mes_num == "10") {
        return "Outubro";
    } elseif ($mes_num == "11") {
        return "Novembro";
    } else {
        return "Dezembro";
    }
}
?>
<?php
$necropapiloscopia_protocolo = $_GET["necropapiloscopia_protocolo"];
$sql = "SELECT `necropapiloscopia_informacoes`, `necropapiloscopia_protocolo`, `necropapiloscopia_perito_nome`, `necropapiloscopia_perito_matricula`, `necropapiloscopia_perito_cargo`, `necropapiloscopia_doc_criacao_data`, `necropapiloscopia_nic_numero`, `necropapiloscopia_procedente_bairro`, `necropapiloscopia_procedente_cidade`, `necropapiloscopia_procedente_uf`, `necropapiloscopia_coleta_motivo` FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";
$query = mysqli_query($_SG['link'], $sql);
$row = mysqli_fetch_assoc($query);
$data_explode = explode("-", $row["necropapiloscopia_doc_criacao_data"]);
$dia_explode = explode(" ", $data_explode[2]);
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Sistema Necropapiloscopia </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Sistema, documentos" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        .A4 {
            background-color: #ffffff;
            color: #000000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 15pt;
            line-height: 1.3;
        }

        .cabecalho-texto {
            text-align: center;
            font-size: 15pt;
        }

        .cabecalho-img-esquerda {
            float: left;
            width: 100%;
        }

        .cabecalho-img-direita {
            float: right;
            width: 100%;
        }

        .titulo {
            text-align: center;
            font-size: 16pt;
            color: #000000;
            background-color: #d5e2bb;
        }

        .paragrafo {
            text-indent: 4em;
            text-align: justify;
        }

        .datacao {
            text-align: right;
        }

        .assinatura {
            text-align: center;
            line-height: 0.2;
        }
    </style>
</head>

<body class="A4" onload="ClosePrint()">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"><img class="cabecalho-img-esquerda" src="images/logoRN.jpg" /></div>
            <div class="col-sm-8 cabecalho-texto">
                <div><b>Governo do Estado do Rio Grande do Norte</b></div>
                <div><b>Secretaria de Estado da Segurança Pública e da Defesa Social</b></div>
                <div style="font-size: 16pt;"><b>INSTITUTO TÉCNICO-CIENTÍFICO DE PERÍCIA - ITEP</b></div>
                <div style="font-size: 16pt;"><b>INSTITUTO DE IDENTIFICAÇÃO - II</b></div>
                <div style="font-size: 16pt;"><i>Setor de Necropapiloscopia</i></div>
            </div>
            <div class="col-sm-2"><img class="cabecalho-img-direita" src="images/logoITEP.jpg" /></div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-sm-10 titulo alert alert-success">
                <b>INFORMAÇÃO TÉCNICA NECROPAPILOSCÓPICA Nº <?php echo $necropapiloscopia_protocolo; ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 paragrafo">
                <p>
                    Em <b><?php echo $dia_explode[0]; ?> de <?php echo mesData($data_explode[1]); ?> de <?php echo $data_explode[0]; ?></b> , o Instituto de Identificação do Rio Grande do Norte - IIRN, em
                    conformidade com a legalidade vigente na Portaria nº 119/2012- GS/SESED informa que, foram
                    realizadas coletas das impressões digitais no cadáver registrado no Instituto de Medicina Legal -
                    IML sob <b>NIC <?php echo $row["necropapiloscopia_nic_numero"]; ?></b>, <?php echo $row["necropapiloscopia_informacoes"]; ?>, procedente do <?php echo $row["necropapiloscopia_procedente_bairro"] . " " . $row["necropapiloscopia_procedente_cidade"] . " " . $row["necropapiloscopia_procedente_uf"]; ?> e não
                    foi submetido a Exame de Confronto Necropapiloscópico por não apresentarem até o momento, documentos
                    com padrões dactiloscópicos que confirmem a Identidade Civil do(a) mesmo(a). Foram realizados
                    pesquisas no nosso banco de dados civil e não foi localizado nenhum registro referente ao citado
                    cadáver.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 paragrafo">
                <p>
                    As planilhas dactiloscópicas coletadas e não identificadas serão arquivadas no Setor de
                    Necropapiloscopia para que se dê continuidade a futuras pesquisas.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 paragrafo">
                <p>
                    Diante do exposto o signatário informa que o cadáver, <b>NIC <?php echo $row["necropapiloscopia_nic_numero"]; ?> <u style="color: red">NÃO FOI
                            IDENTIFICADO(A) PELO SISTEMA DACTILOSCÓPICO.</u></b>
                </p>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col datacao">
                <p>Natal/RN, <?php echo dataEmPortugues(time()); ?></p>
            </div>
        </div>
        <br>
        <div class="row ">
            <div class="col assinatura">
                <?php
                if (!verificarSetorNecropapiloscopia()) {
                    echo '<p style="color: red;">NÃO ASSINAR</p>';
                }
                ?>
                <p>_______________________________________</p>
                <br><br>
                <p><b><?php echo $row["necropapiloscopia_perito_nome"]; ?></b></p>
                <p><?php echo $row["necropapiloscopia_perito_cargo"]; ?></p>
                <p>Matr. <?php echo $row["necropapiloscopia_perito_matricula"]; ?></p>
            </div>
            <?php
            if ($_SESSION['usuarioNome'] != $row["necropapiloscopia_perito_nome"]) {
                $sql_nao_necro = "SELECT `usuario_nome`, `usuario_cargo`, `usuario_matricula` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "'";
                $query_nao_necro = mysqli_query($_SG["link"], $sql_nao_necro);
                $row_nao_necro = mysqli_fetch_assoc($query_nao_necro);
                echo '<div class="col assinatura">';
                echo '<p>Este documento foi impresso por:</p>';
                echo '<br><br>';
                echo '<p><b>' . $row_nao_necro["usuario_nome"] . '</b></p>';
                echo '<p>' . $row_nao_necro["usuario_cargo"] . '</p>';
                echo '<p>Matr. ' . $row_nao_necro["usuario_matricula"] . '</p>';
                echo '<p>Natal/RN, ' . dataEmPortugues(time()) . ',</p>';
                echo '<p> às ' . date("H:i:s") . ' horas</p>';
                echo '<p style="color: red;">Atenção! Este não é um usuário do setor da Necropapiloscopia</p>';
                echo '<br><br><br><br>';
                echo '</div>';
            }
            ?>
        </div>
        <br><br>
    </div>
</body>

</html>