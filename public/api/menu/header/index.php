<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para informação do cabeçalho do menu
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

    $company = new ClassCompany();                              //! Obtem as informações da empresa

    // Mensagem de alerta que tudo deu certo
    array_push($dados, [
        "mensagem" => "DADOS DA EMPRESA OBTIDOS",
        "nome" => $company->get_name(),
        "logo" => $company->get_company_logo()
    ]);
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
