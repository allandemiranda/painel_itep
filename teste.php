<?php
for ($i = 0; $i < 100; $i++) {
    $servername = 'localhost';
    $username = 'root';
    $password = 'itep123';
    $dbname = 'itep_necro';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO `documentos` (`perito`, `numero_nic`, `data_entrada`, `cadaver_informacao`, `data_fato`, `procedencia_bairro`, `procedencia_cidade`, `procedencia_uf`, `cadaver_situacao`, `numero_guia`, `causa_morte`, `destino_exame`, `numero_sei`, `status_coleta`) VALUES ('ALLAN', '123', '2019-07-17', 'info cadav', '2019-07-18', 'bairro um', 'teste', 'RN', 'situaço cad', '456', 'causa morte', 'destino exam', '789', '0')";
    if (mysqli_query($conn, $sql)) {
        //echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        break;
    }
}
echo "FIM";
