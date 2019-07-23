<?php
include("segurancaOff.php");
?>
<?php
$sql = "SELECT * FROM `painel_tb` ORDER BY `painel_id` DESC LIMIT 4";
$result = mysqli_query($conn, $sql);
$senha = $nome = $sala = $painel_id = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ultimos3id = substr($row["painel_senha"], -3);
        $senha_correta = str_pad($ultimos3id, 3, '0', STR_PAD_LEFT);
        array_push($senha, $senha_correta);
        array_push($nome, $row["painel_nome"]);
        array_push($sala, $row["painel_sala"]);
        array_push($painel_id, $row["painel_id"]);
    }
} else {
    echo "ERRO";
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="refresh" content="10;url=<?php echo $_SERVER["HTTP_REFERER"]; ?>?painel_id=<?php echo $painel_id[0]; ?>">
    <title>Painel ITEP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="painel/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <script src="painel/js/bootstrap.js"></script>
    <link href="painel/css/all.css" rel="stylesheet">
    <script defer src="painel/js/all.js"></script>
    <style>
        body {
            background-color: #d5e2bb;
            color: #000000;
            font-family: 'Times New Roman', Times, serif;
            font-size: 15pt;
            line-height: 1.3;
            margin-top: 3%;
        }

        .footer {
            background: #fff;
            padding: 1em;
            width: 100%;
            text-align: center;
            box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.21);
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    if ($painel_id[0] != $_GET["painel_id"]) {
        echo '<audio autoplay>';
        echo '<source src="/painel/som-alerta.mp3" type="audio/mpeg">';
        echo 'Your browser does not support the audio tag.';
        echo '</audio>';
    }
    ?>
    <?php
    if ($painel_id[0] != $_GET["painel_id"]) {
        echo '<div class="container text-center h-100 shadow p-3 mb-5 bg-white rounded" style="background-color: #19d518 !important;">';
    } else {
        echo '<div class="container text-center h-100 shadow p-3 mb-5 bg-white rounded">';
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-6 ">
            <h1><?php echo $senha[0]; ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            <h1><?php echo $nome[0]; ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            <h1><?php echo $sala[0]; ?></h1>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col">
                        <div class="row text-center h-100 shadow p-3 mb-5 bg-white rounded">
                            <div class="col-12 ">
                                <h1><?php echo $senha[1]; ?></h1>
                            </div>
                            <div class="col-12"><?php echo $sala[1]; ?></div>
                        </div>
                    </div>
                    <div class="col-1"></div>
                    <div class="col">
                        <div class="row text-center h-100 shadow p-3 mb-5 bg-white rounded">
                            <div class="col-12 ">
                                <h1><?php echo $senha[2]; ?></h1>
                            </div>
                            <div class="col-12"><?php echo $sala[2]; ?></div>
                        </div>
                    </div>
                    <div class="col-1"></div>
                    <div class="col">
                        <div class="row text-center h-100 shadow p-3 mb-5 bg-white rounded">
                            <div class="col-12 ">
                                <h1><?php echo $senha[3]; ?></h1>
                            </div>
                            <div class="col-12"><?php echo $sala[3]; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer-->
    <div class="footer">
        <p>&copy; 2019 All Rights Reserved | Design by <a href="http://allandemiranda.eti.br/" target="_blank">Allan
                de Miranda</a></p>
    </div>
    <!--//footer-->
</body>

</html>