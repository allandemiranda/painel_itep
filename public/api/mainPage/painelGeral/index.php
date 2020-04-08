<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para gerenciar as fichas do sistema
 * @version 1.0.0
 * @date 24-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */
?>
<?php

include($_SERVER['DOCUMENT_ROOT'] . '/api/HeaderJSON.php');     //! Cabeçalho para conteudo json
include($_SERVER['DOCUMENT_ROOT'] . '/api/Header.php');         //! Cabeçalho com as classes e funções gerias

$dados = [];                                                    //! Contem todos os dados a serem enviados

$body = file_get_contents('php://input');                       //! Obtém todas as informações requisitadas POST
$json = json_decode($body, true);                               //! Decodifica as informações requisitadas

$login = $json['login'];                                        //! Login do usuário que requisitou a informação
$senha = $json['senha'];                                        //! Senha criptografada do usuário que requisitou a informação

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário
    $db = new ClassConnection();

    // Obter a lista de setores ativos do sistema
    $setores = [];
    $sql = "SELECT `setor_id`, `setor_nome` FROM `setores_tb` WHERE `setor_deletado`=0";    //! Lista de setores ativos no sistema
    $result = $db->request_query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $setores[$row["setor_id"]] = $row["setor_nome"];
        }

        // Adicioar os setores aos dados
        array_push($dados, $setores);
        $setores = null;
    }

    // Obter a lista de fichas do dia
    $fichas = [];
    $today = date("Y-m-d");
    $sql = "SELECT * FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' ORDER BY `ficha_numero` DESC";   //! Lista de fichas geradas no dia
    $result = $db->request_query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ficha = new ClassFicha($row['ficha_id']);          //! Obter a ficha pelo id

            // Salvar informações da ficha no vetor $fichas
            array_push(
                $fichas,
                [
                    'ficha_id' => intval($ficha->get_id()),
                    'ficha_numero' => intval($ficha->get_number()),
                    'ficha_nome' => $ficha->get_name(),
                    'ficha_telefone' => $ficha->get_phone(),
                    'ficha_status' => $ficha->get_attendant_status(),
                    'ficha_setor_id' => $ficha->get_attendant_sector()->get_id(),
                    'ficha_prioridade' => $ficha->get_priority(),
                    'ficha_hora' => date("H:i:s", strtotime($ficha->get_date()))
                ]
            );
        }

        // Adicionar as fichas aos dados
        array_push($dados, $fichas);
        $fichas = null;
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados);                                   //! Imprime os dados obtidos da requisição
}
