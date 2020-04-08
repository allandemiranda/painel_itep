<?php

/**
 * @file naoAtendidosProximoIndividual.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para gerenciar uma chamada de ficha individual
 * @version 1.0.0
 * @date 27-03-2020
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

$ficha_id = $json['ficha_id'];                                  //! id da ficha a ser chamada

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário

    $ficha = new ClassFicha($ficha_id);
    if (($ficha->get_attendant_status() == "EM ATENDIMENTO") || ($ficha->get_attendant_status() == "CHAMAR")) {
        array_push(
            $dados,
            [
                'tipo' => 'warning',
                'mensagem' => "Ficha " . $ficha->get_number() . " não está disponível."
            ]
        );
    } else {
        $ficha->set_attendant_status("CHAMAR");
        $ficha->set_attendant_user($credenciais->get_user());
        array_push(
            $dados,
            [
                'tipo' => 'success',
                'mensagem' => "Fichas " . $ficha->get_number() . " foi chamada."
            ]
        );

        $log = new ClassLogs(null, $credenciais->get_user(), "CHAMOU FICHA", $ficha);   //! Criar um log desta operação no sistema
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
