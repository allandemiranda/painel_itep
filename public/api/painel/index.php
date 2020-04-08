<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para gerenciar os indicadores de fichas para o setor no dia
 * @version 1.0.0
 * @date 31-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */
?>
<?php

include($_SERVER['DOCUMENT_ROOT'] . '/api/HeaderJSON.php');     //! Cabeçalho para conteudo json
include($_SERVER['DOCUMENT_ROOT'] . '/api/Header.php');         //! Cabeçalho com as classes e funções gerias

$dados = [];                                                    //! Contem todos os dados a serem enviados

try {
    $db = new ClassConnection();

    $today = date("Y-m-d");                                                 //! Data do dia atual

    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_status`='CHAMAR' LIMIT 1";   //! Lista  se tem ficha para ser chamada
    $result = $db->request_query($sql);

    // Se tiver ficha para ser chamada
    if (mysqli_num_rows($result) == 1) {
        $ficha = new ClassFicha(mysqli_fetch_assoc($result)['ficha_id']);   //! Obtem ficha pelo id
        array_push(
            $dados,
            [
                'ficha' => 1,
                'ficha_numero' => $ficha->get_number(),
                'ficha_setor_nome' => $ficha->get_attendant_sector()->get_name()
            ]
        );
        $ficha->set_attendant_status("EM ATENDIMENTO");
    } else {
        array_push(
            $dados,
            [
                'ficha' => 0,
                'ficha_numero' => '',
                'ficha_setor_nome' => ''
            ]
        );
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
