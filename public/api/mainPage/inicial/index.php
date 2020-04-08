<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para gerenciar os indicadores de fichas para o setor no dia
 * @version 1.0.0
 * @date 30-03-2020
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
    $today = date("Y-m-d");                                     //! Data do dia atual

    // Obter a quantidade de fichas não atendidas do setor
    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND `ficha_status`='NÃO ATENDIDO'";
    $result = $db->request_query($sql);
    $naoAtendidos = mysqli_num_rows($result);

    // Obter a quantidade de fichas em atendimento pelo setor
    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND `ficha_status`='EM ATENDIMENTO'";
    $result = $db->request_query($sql);
    $emAtendimento = mysqli_num_rows($result);

    // Obter a quantidade de fichas encaminhadas para o setor
    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND `ficha_status`='ENCAMINHADO'";
    $result = $db->request_query($sql);
    $encaminhado = mysqli_num_rows($result);

    // Obter a quantidade de fichas fianlizadas pelo setor
    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND `ficha_status`='FINALIZADO'";
    $result = $db->request_query($sql);
    $finalizado = mysqli_num_rows($result);

    // Salvando dados obtidos 
    array_push(
        $dados,
        [
            'naoAtendidos' => intval($naoAtendidos),
            'emAtendimento' => intval($emAtendimento),
            'encaminhado' => intval($encaminhado),
            'finalizado' => intval($finalizado)
        ]
    );
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
