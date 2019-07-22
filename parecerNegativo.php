<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>
<?php
$servername = $_SG['servidor'];
$username = $_SG['usuario'];
$password = $_SG['senha'];
$dbname = $_SG['banco'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM documentos WHERE id='" . $_GET["protocolo"] . "'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $perito_nome = $row["perito"];
        $protocolo = str_pad($row["id"], 4, '0', STR_PAD_LEFT);
        $data_entrada_ex = explode("-", $row["data_entrada"]);
        $protocolo_ano = $data_entrada_ex[0];
        $data_doc_ex = explode("-", $row["data_formulario"]);
        $doc_dia = $data_doc_ex[2];
        $doc_mes = $data_doc_ex[1];
        $doc_ano = $data_doc_ex[0];
        $numero_nic = $row["numero_nic"];
        $procedencia_barrio = $row["procedencia_bairro"];
        $procedencia_cidade = $row["procedencia_cidade"];
        $procedencia_uf = $row["procedencia_uf"];
        $cadaver_informacao = $row["cadaver_informacao"];
    }
} else {
    //echo "0 results";
}

mysqli_close($conn);
?>
<?php
$servername = $_SG['servidor'];
$username = $_SG['usuario'];
$password = $_SG['senha'];
$dbname = $_SG['banco'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM usuarios WHERE nome='" . $perito_nome . "'";
$result = mysqli_query($conn, $sql);

$perito_sobrenome = $perito_cargo = $matricula = "";

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $perito_sobrenome = $row["sobre_nome"];
        $perito_cargo = $row["cargo"];
        $perito_matricula = $row["matricula"];
    }
} else {
    //echo "0 results";
}

mysqli_close($conn);
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

<body class="A4">
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
                <b>INFORMAÇÃO TÉCNICA NECROPAPILOSCÓPICA Nº <?php echo $protocolo; ?>/<?php echo $protocolo_ano; ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 paragrafo">
                <p>
                    Em <b><?php echo $doc_dia; ?> de <?php echo mesData($doc_mes); ?> de <?php echo $doc_ano; ?></b> , o Instituto de Identificação do Rio Grande do Norte - IIRN, em
                    conformidade com a legalidade vigente na Portaria nº 119/2012- GS/SESED informa que, foram
                    realizadas coletas das impressões digitais no cadáver registrado no Instituto de Medicina Legal -
                    IML sob <b>NIC <?php echo $numero_nic; ?></b>, <?php echo $cadaver_informacao; ?>, procedente do <?php echo $procedencia_barrio . " " . $procedencia_cidade . " " . $procedencia_uf; ?> e não
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
                    Diante do exposto o signatário informa que o cadáver, <b>NIC <?php echo $numero_nic; ?> <u style="color: red">NÃO FOI
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
                <p><b><?php echo $perito_nome . " " . $perito_sobrenome; ?></b></p>
                <p><?php echo $perito_cargo; ?></p>
                <p>Mat <?php echo $perito_matricula; ?></p>
            </div>
        </div>
    </div>
</body>

</html>