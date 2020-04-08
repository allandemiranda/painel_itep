<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para verificar que tipo de Dashboard é exibido
 * @version 1.0.0
 * @date 23-03-2020
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

    // Verifica se o usuário da credencial é para exibir o painel de criação de fichas
    if ($credenciais->get_user()->get_sector()->get_ficha() == 1) {
        array_push($dados, [
            "mensagem"   => "USUARIO É DE UM GERENCIADOR DE FICHAS",
            "configuracao" => true
        ]);
    } else {
        array_push($dados, [
            "mensagem"   => "USUARIO NÃO É DE UM GERENCIADOR DE FICHAS",
            "configuracao" => false
        ]);
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
