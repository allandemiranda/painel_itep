<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a aplicação para gerenciamento se o usuário tem acesso a área de trabalho do sistema
 * @version 1.0.0
 * @date 02-03-2020
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

$login = input_check($json['login']);                           //! login do usuário que requisitou login no sistema
$senha = input_check($json['senha']);                           //! senha do usuário que requisitou login no sistema

try {
    $credenciais = new ClassCredenciais($login, $senha);       //! Obtém a credencial do usuaário caso o login e senha informados sejam válidos  
    array_push($dados, [
        "mensagem"   => "USUÁRIO ATIVO",

    ]);
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
