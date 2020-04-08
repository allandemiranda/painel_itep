<?php

/**
 * @file formulario.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para modificar senha do usuário logado
 * @version 1.0.0
 * @date 05-03-2020
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

$nova_senha = encrypt_password($json['novaSenha']);             //! Nova senha do usuário já criptografada

try {
    $credenciais = new ClassCredenciais($login, $senha);    //! Obter a credencial do usário

    $credenciais->get_user()->set_password($nova_senha);    // Difinis noca senha ao usuário

    // Mensagem de alerta que tudo deu certo
    array_push($dados, [
        "mensagem" => "SENHA DO FUNCIONÁRIO ATUALIZADA",
        "senha" => $credenciais->get_user()->get_password()
    ]);

    $log = new ClassLogs(null, $credenciais->get_user(), "ATUALIZOU PERFIL", null, null);   //! Criar um log desta operação no sistema
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
