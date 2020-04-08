<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para validar dados necessários para o cabeçalho da página
 * @version 1.0.0
 * @date 03-03-2020
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

    // Mensagem de alerta que tudo deu certo
    array_push($dados, [
        "mensagem"   => "INFORMAÇÕES PARA O CABEÇALHO",
        "nome" => $credenciais->get_user()->get_name(),
        "setor" => $credenciais->get_user()->get_sector()->get_name()
    ]);
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
