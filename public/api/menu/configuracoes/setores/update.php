<?php

/**
 * @file delete.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para ataulizar informações de um Setor do Sistema
 * @version 1.0.0
 * @date 11-03-2020
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

$id = $json['id'];                                              //! id do setor que será modificado
$nome = input_check($json['nome']);                             //! novo nome do setor 
$ficha = $json['ficha'];                                        //! nova opção do setor se do tipo ficha
$admin = $json['admin'];                                        //! nova opção do setor se do tipo administrador

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário

    // Verificar se a credencial tem permição de atualizar um setor do sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $setor = new ClassSetor($id);                           //! Obter o setor do id

        $setor->set_name($nome);                                // Define novo nome do setor

        // Define se o setor é um criador de fichas
        if ($ficha == 1) {
            $setor->set_ficha(true);
        } else {
            $setor->set_ficha(false);
        }

        // Define se o setor é do tipo Administrador
        if ($admin == 1) {
            $setor->set_admin(true);
        } else {
            $setor->set_admin(false);
        }

        // Mensagem de alerta que tudo deu certo
        array_push($dados, [
            "mensagem" => "SETOR ATUALIZADO"
        ]);
        
        $log = new ClassLogs(null, $credenciais->get_user(), "ATUALIZOU SETOR", $setor);    //! Criar um log desta operação no sistema
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                    //! Imprime os dados obtidos da requisição
}
