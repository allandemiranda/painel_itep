<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para imprimir as fichas do sistema
 * @version 1.0.0
 * @date 25-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */
?>
<?php

include($_SERVER['DOCUMENT_ROOT'] . '/api/Header.php'); //! Cabeçalho com as classes e funções gerias

try {
    $body_ficha_id = null;                              //! Armazena o id da ficha a ser impressa

    if ($_GET["id"] == null) {
        throw new Exception("Tentativa de injeção de código", 1);
    } else {
        $temp = $_GET["id"];                            //! Obtem número da ficha a ser impressa
        $body_ficha_id = input_check($temp);
    }

    $ficha = new ClassFicha($body_ficha_id);            //! Obtem ficha pelo seu id
    $empresa = new ClassCompany();                      //! Obter dados da empresa
} catch (\Throwable $th) {
    // echo $th;
    echo "Erro ao imprimir a ficha! Não tente imprimir novamente. Feche a aba e contacte a DIGETI - ITEP/RN.";
    return 0;
}

// Página HTML no formato necessário para impressão da ficha
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>IMPRIMIR FICHA</title>
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
            <p><?php echo date("d-m-Y H:i:s", strtotime($ficha->get_date())); ?></p>
        </div>
        <div>
            <h1>Senha: <?php echo $ficha->get_number(); ?></h1>
        </div>
        <div>
            <p>Nome: <?php echo $ficha->get_name(); ?></p>
        </div>
        <div>
            <p>Tel.: <?php echo $ficha->get_phone(); ?></p>
        </div>
        <div>
            <p>Atendimento: <?php echo $ficha->get_attendant_sector()->get_name(); ?></p>
        </div>
        <div>
            <p style="font-size: 70%"><?php echo $empresa->get_footer_print(); ?></p>
        </div>
    </div>
</body>

</html>