<?php

/**
 * @file delete.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para deletar um usuários do sistema
 * @version 1.0.0
 * @date 09-03-2020
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

$id = $json['id'];                                              //! id do usuário que será deletado do sistema

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário

    // Verificar se a credencial tem permição de deletar um usuários do sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $usuario = new ClassUsuario($id);                       //! Obter o usuário do id

        $usuario->set_deleted(true);                            // Deletar o usuário

        // Mensagem de alerta que tudo deu certo
        array_push($dados, [
            "mensagem" => "FUNCIONÁRIO DELETADO",
            "usuario_nome" => $usuario->get_name()
        ]);

        $log = new ClassLogs(null, $credenciais->get_user(), "EXCLUIU USUÁRIO", $usuario);  //! Criar um log desta operação no sistema
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
