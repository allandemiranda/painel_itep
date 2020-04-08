<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a aplicação para gerenciamento do login de um usuário no sistema
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

$senha = md5($senha);                                           //! Criptografia usada para senhas de usuários armazenadas no banco de dados

try {
    $credenciais = new ClassCredenciais($login, $senha);                                    //! Obtém a credencial do usuaário caso o login e senha informados sejam válidos  
    array_push($dados, [
        "mensagem"   => "LOGIN EFETUADO",
        "ficha" => $credenciais->get_user()->get_sector()->get_ficha() == 1 ? true : false, // Informa se o usuário é de um setor que gera fichas ou não
        "login" => $credenciais->get_user()->get_login(),
        "senha" => $credenciais->get_user()->get_password()                                 // Informa senha do usuário já criptografada
    ]);
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
