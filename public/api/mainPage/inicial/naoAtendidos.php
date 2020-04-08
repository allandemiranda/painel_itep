<?php

/**
 * @file naoAtendidos.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para gerenciar as fichas não atendidas do setor
 * @version 1.0.0
 * @date 26-03-2020
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
    $today = date("Y-m-d");                                     //! Obter a data atual

    // Lista das fichas em espera do setor
    $sql = "SELECT * FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') ORDER BY `ficha_atualizacao_data` ASC";
    $result = $db->request_query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ficha = new ClassFicha($row['ficha_id']);          //! Obter a ficha pelo seu id
            array_push(
                $dados,
                [
                    'ficha_id' => intval($ficha->get_id()),
                    'ficha_numero' => intval($ficha->get_number()),
                    'ficha_nome' => $ficha->get_name(),
                    'ficha_telefone' => $ficha->get_phone(),
                    'ficha_status' => $ficha->get_attendant_status(),
                    'ficha_setor_id' => $ficha->get_attendant_sector()->get_id(),
                    'ficha_prioridade' => $ficha->get_priority(),
                    'ficha_hora' => date("H:i:s", strtotime($ficha->get_date())),
                    'ficha_atualizacao_data' => $ficha->get_date_update()
                ]
            );
        }
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados);                                   //! Imprime os dados obtidos da requisição
}
