<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
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
function corrigirData($data)
{
    $explode_data = explode("-", $data);
    return $explode_data[2] . "/" . $explode_data[1] . "/" . $explode_data[0];
}
?>
<?php
$necropapiloscopia_protocolo = $_GET["necropapiloscopia_protocolo"];
$sql = "SELECT * FROM `necropapiloscopia_tb` WHERE `necropapiloscopia_protocolo`='" . $necropapiloscopia_protocolo . "'";
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
    <script>
        function ClosePrint() {
            setTimeout(function() {
                window.print();
            }, 500);            
        }
    </script>
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
                    Em, <b><?php echo $dia_explode[0]; ?> de <?php echo mesData($data_explode[1]); ?> de <?php echo $data_explode[0]; ?></b> o Instituto de Identificação do Rio Grande do Norte - IIRN, em
                    conformidade com a legalidade vigente na Portaria nº 119/2012 - GS/SESED informa que, após coletas
                    das
                    impressões digitais no cadáver registrado no Instituto de Medicina Legal - IML sob <b>NIC <?php echo $row["necropapiloscopia_nic_numero"]; ?></b>
                    foram submetidos a Exame de Confronto Necropapiloscópico com as impressões digitais provenientes
                    do(a), <b><?php echo $row["necropapiloscopia_documento_tipo"] . " " . $row["necropapiloscopia_documento_numero"] . " " . $row["necropapiloscopia_documento_orgao"] . "/" . $row["necropapiloscopia_documento_uf"]; ?></b> conforme dados qualificativos a seguir:
                </p>
            </div>
        </div>
        <div class="row" style="line-height: 0.2;">
            <div class="col-sm-4">
                <p><b>DATA DE ENTRADA:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo corrigirData($row["necropapiloscopia_entrada_data"]); ?></p>
            </div>
            <div class="col-sm-4">
                <p><b>PROCEDÊNCIA:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo $row["necropapiloscopia_procedente_bairro"] . " " . $row["necropapiloscopia_procedente_cidade"] . " " . $row["necropapiloscopia_procedente_uf"]; ?></p>
            </div>
            <div class="col-sm-4">
                <p><b>NOME COMPLETO:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo $row["necropapiloscopia_nome"]; ?></p>
            </div>
            <div class="col-sm-4">
                <p><b>NOME DO PAI:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo $row["necropapiloscopia_pai_nome"]; ?></p>
            </div>
            <div class="col-sm-4">
                <p><b>NOME DA MÃE:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo $row["necropapiloscopia_mae_nome"]; ?></p>
            </div>
            <div class="col-sm-4">
                <p><b>NATURALIDADE:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo $row["necropapiloscopia_naturalidade_cidade"] . " " . $row["necropapiloscopia_naturalidade_uf"]; ?> </p>
            </div>
            <div class="col-sm-4">
                <p><b>DATA DE NASCIMENTO:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo corrigirData($row["necropapiloscopia_nascimento_data"]); ?></p>
            </div>
            <div class="col-sm-4">
                <p><b>DOC. APRESENTADO:</b></p>
            </div>
            <div class="col-sm-8">
                <p><?php echo $row["necropapiloscopia_documento_tipo"] . " " . $row["necropapiloscopia_documento_numero"] . " " . $row["necropapiloscopia_documento_orgao"] . "/" . $row["necropapiloscopia_documento_uf"]; ?></p>
            </div>
            <?php
            if ($row["necropapiloscopia_observacoes"] != "") {
                echo '<div class="col-sm-4" style="color: red">';
                echo '<p><b><u>OBSERVAÇÃO:</u></b></p>';
                echo '</div>';
                echo '<div class="col-sm-8" style="color: red">';
                echo '<p>' . $row["necropapiloscopia_observacoes"] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="row">
            <div class="col-sm-12 paragrafo">
                <p>
                    Diante dos exames realizados o signatário conclui que <u><b>foram encontrados padrões
                            dactiloscópicos que confirmam a Identidade Civil do mesmo.</b></u>
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
                <p>_______________________________________</p>
                <br><br>
                <p><b><?php echo $row["necropapiloscopia_perito_nome"]; ?></b></p>
                <p><?php echo $row["necropapiloscopia_perito_cargo"]; ?></p>
                <p>Mat <?php echo $row["necropapiloscopia_perito_matricula"]; ?></p>
            </div>
        </div>
    </div>
</body>

</html>