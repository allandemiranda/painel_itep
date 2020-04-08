<?php

/**
 * @file finalizar.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para finalizar uma ficha em atendimento
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

$ficha_id = $json['ficha_id'];                                  //! id da ficha que será finalizada

try {
    $credenciais = new ClassCredenciais($login, $senha);
    $ficha = new ClassFicha($ficha_id);                         //! Obter ficha pelo id
    $ficha->set_attendant_status("FINALIZADO");                 // Finaliza a ficha

    array_push(
        $dados,
        [
            'tipo' => 'success',
            'mensagem' => "Fichas " . $ficha->get_number() . " foi finalizada."
        ]
    );

    $log = new ClassLogs(null, $credenciais->get_user(), "FINALIZOU FICHA", $ficha);    //! Criar um log desta operação no sistema
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
