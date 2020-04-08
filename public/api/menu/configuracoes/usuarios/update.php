<?php

/**
 * @file update.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para atualizar um usuários do sistema
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

$id = $json['id'];                                              //! id do usuário que seá atualizado
$setor = $json['setor'];                                        //! id do novo setor para o usuário

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário

    // Verificar se a credencial tem permição de deletar um usuários do sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $usuario = new ClassUsuario($id);                       //! Obter o usuário do id
        $novo_setor = new ClassSetor($setor);                   //! Obter o setor do id

        $usuario->set_sector($novo_setor);                      // Define um novo setor para o usuário

        // Mensagem de alerta que tudo deu certo
        array_push($dados, [
            "mensagem" => "FUNCIONÁRIO ATUALIZADO"
        ]);

        $log = new ClassLogs(null, $credenciais->get_user(), "ATUALIZOU USUÁRIO", $usuario);    //! Criar um log desta operação no sistema
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
