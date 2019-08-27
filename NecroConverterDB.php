<?php

$servername = "localhost";
$username = "root";
$password = "itep123";
$dbname = "sistema_itep";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT `id`, `perito`, `numero_nic`, `data_entrada`, `cadaver_informacao`, `data_fato`, `procedencia_bairro`, `procedencia_cidade`, `procedencia_uf`, `cadaver_situacao`, `numero_guia`, `causa_morte`, `destino_exame`, `numero_sei`, `status_coleta`, `nome_completo`, `nome_pai`, `nome_mae`, `naturalidade_cidade`, `naturalidade_uf`, `data_nascimento`, `docuemnto_tipo`, `docuemnto_numero`, `docuemnto_orgao`, `docuemnto_uf`, `observacoes`, `data_formulario` FROM `documentos`";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $necropapiloscopia_id = $row["id"];

        $necropapiloscopia_protocolo = str_pad($row["id"], 4, "0", STR_PAD_LEFT) . "/2019";

        $sql_perito = "SELECT `id`, `nome`, `sobre_nome`, `cargo`, `matricula`, `usuario`, `senha` FROM `usuarios` WHERE `nome`='" . $row['perito'] . "'";
        $result_perito = mysqli_query($conn, $sql_perito);
        if (mysqli_num_rows($result_perito) > 0) {
            $row_perito = mysqli_fetch_assoc($result_perito);

            $sql_necropapiloscopia_perito = "SELECT `usuario_id`, `usuario_nome`, `usuario_cargo`, `usuario_matricula`, `usuario_setor_id`, `usuario_login`, `usuario_senha`, `usuario_update_data`, `usuario_cadastrado` FROM `usuarios_tb` WHERE `usuario_nome`='" . $row_perito['nome'] . " " . $row_perito['sobre_nome'] . "'";
            $result_necropapiloscopia_perito = mysqli_query($conn, $sql_necropapiloscopia_perito);
            if (mysqli_num_rows($result_necropapiloscopia_perito) > 0) {
                $row_necropapiloscopia_perito = mysqli_fetch_assoc($result_necropapiloscopia_perito);

                $necropapiloscopia_perito_id = $row_necropapiloscopia_perito["usuario_id"];
                $necropapiloscopia_perito_nome = $row_necropapiloscopia_perito["usuario_nome"];
                $necropapiloscopia_perito_matricula = $row_necropapiloscopia_perito["usuario_matricula"];
                $necropapiloscopia_perito_cargo = $row_necropapiloscopia_perito["usuario_cargo"];

                $necropapiloscopia_doc_criacao_data = $row["data_formulario"] . " 00:00:00";
                $necropapiloscopia_doc_criacao_perito_nome = "NULL";
                $necropapiloscopia_doc_modificacao_data = $row["data_formulario"] . " 00:00:00";
                $necropapiloscopia_doc_modificacao_perito_nome = $row_necropapiloscopia_perito["usuario_nome"];

                $necropapiloscopia_nic_numero = $row["numero_nic"];
                $necropapiloscopia_entrada_data = $row["data_entrada"];
                $necropapiloscopia_fato_data = $row["data_fato"];
                $necropapiloscopia_sei_protocolo = "00000.000000/0000-00";
                $necropapiloscopia_procedente_bairro = $row["procedencia_bairro"];
                $necropapiloscopia_procedente_cidade = $row["procedencia_cidade"];
                $necropapiloscopia_procedente_uf = $row["procedencia_uf"];
                $necropapiloscopia_informacoes = $row["cadaver_informacao"];
                $necropapiloscopia_situacao = $row["cadaver_situacao"];
                $necropapiloscopia_guia_numero = $row["numero_guia"];
                $necropapiloscopia_causa_morte = $row["causa_morte"];
                $necropapiloscopia_exame_destino = $row["destino_exame"];
                $necropapiloscopia_coleta_check = $row["status_coleta"];
                $necropapiloscopia_coleta_motivo = "";

                $necropapiloscopia_nascimento_data = $row["data_nascimento"];
                $necropapiloscopia_naturalidade_cidade = $row["naturalidade_cidade"];
                $necropapiloscopia_naturalidade_uf = $row["naturalidade_uf"];
                $necropapiloscopia_nome = $row["nome_completo"];
                $necropapiloscopia_pai_nome = $row["nome_pai"];
                $necropapiloscopia_mae_nome = $row["nome_mae"];
                $necropapiloscopia_documento_tipo = $row["docuemnto_tipo"];
                $necropapiloscopia_documento_numero = $row["docuemnto_numero"];
                $necropapiloscopia_documento_orgao = $row["docuemnto_orgao"];
                $necropapiloscopia_documento_uf = $row["docuemnto_uf"];
                $necropapiloscopia_observacoes = $row["observacoes"];

                $sql_inserir = "INSERT INTO `necropapiloscopia_tb`(`necropapiloscopia_id`, `necropapiloscopia_protocolo`, `necropapiloscopia_perito_id`, `necropapiloscopia_perito_nome`, `necropapiloscopia_perito_matricula`, `necropapiloscopia_perito_cargo`, `necropapiloscopia_doc_criacao_data`, `necropapiloscopia_doc_criacao_perito_nome`, `necropapiloscopia_doc_modificacao_data`, `necropapiloscopia_doc_modificacao_perito_nome`, `necropapiloscopia_nic_numero`, `necropapiloscopia_entrada_data`, `necropapiloscopia_fato_data`, `necropapiloscopia_sei_protocolo`, `necropapiloscopia_procedente_bairro`, `necropapiloscopia_procedente_cidade`, `necropapiloscopia_procedente_uf`, `necropapiloscopia_informacoes`, `necropapiloscopia_situacao`, `necropapiloscopia_guia_numero`, `necropapiloscopia_causa_morte`, `necropapiloscopia_exame_destino`, `necropapiloscopia_coleta_check`, `necropapiloscopia_coleta_motivo`, `necropapiloscopia_nascimento_data`, `necropapiloscopia_naturalidade_cidade`, `necropapiloscopia_naturalidade_uf`, `necropapiloscopia_nome`, `necropapiloscopia_pai_nome`, `necropapiloscopia_mae_nome`, `necropapiloscopia_documento_tipo`, `necropapiloscopia_documento_numero`, `necropapiloscopia_documento_orgao`, `necropapiloscopia_documento_uf`, `necropapiloscopia_observacoes`) VALUES ('" . $necropapiloscopia_id . "', '" . $necropapiloscopia_protocolo . "', '" . $necropapiloscopia_perito_id . "', '" . $necropapiloscopia_perito_nome . "', '" . $necropapiloscopia_perito_matricula . "', '" . $necropapiloscopia_perito_cargo . "', '" . $necropapiloscopia_doc_criacao_data . "', '" . $necropapiloscopia_doc_criacao_perito_nome . "', '" . $necropapiloscopia_doc_modificacao_data . "', '" . $necropapiloscopia_doc_modificacao_perito_nome . "', '" . $necropapiloscopia_nic_numero . "', '" . $necropapiloscopia_entrada_data . "', '" . $necropapiloscopia_fato_data . "', '" . $necropapiloscopia_sei_protocolo . "', '" . $necropapiloscopia_procedente_bairro . "', '" . $necropapiloscopia_procedente_cidade . "', '" . $necropapiloscopia_procedente_uf . "', '" . $necropapiloscopia_informacoes . "', '" . $necropapiloscopia_situacao . "', '" . $necropapiloscopia_guia_numero . "', '" . $necropapiloscopia_causa_morte . "', '" . $necropapiloscopia_exame_destino . "', '" . $necropapiloscopia_coleta_check . "', '" . $necropapiloscopia_coleta_motivo . "', '" . $necropapiloscopia_nascimento_data . "', '" . $necropapiloscopia_naturalidade_cidade . "', '" . $necropapiloscopia_naturalidade_uf . "', '" . $necropapiloscopia_nome . "', '" . $necropapiloscopia_pai_nome . "', '" . $necropapiloscopia_mae_nome . "', '" . $necropapiloscopia_documento_tipo . "', '" . $necropapiloscopia_documento_numero . "', '" . $necropapiloscopia_documento_orgao . "', '" . $necropapiloscopia_documento_uf . "', '" . $necropapiloscopia_observacoes . "')";
                if (mysqli_query($conn, $sql_inserir)) {
                    echo "Record " . $necropapiloscopia_protocolo . " updated successfully <br>";
                } else {
                    echo "Error: " . $sql_inserir . "<br>" . mysqli_error($conn) . "<br>";
                }
            } else {
                echo "Nome do perito " . $row_perito['nome'] . " " . $row_perito['sobre_nome'] . " não encontrado nos peritos novos <br>";
            }
        } else {
            echo "Nome do perito " . $row['nome'] . " não encontrado nos peritos antigos <br>";
        }
    }
} else {
    echo "0 results de documentos antigos <br>";
}
