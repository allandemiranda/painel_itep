<?php

/**
 * @file encaminhar.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para encaminhar uma ficha a outro setor
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

$ficha_id = $json['ficha_id'];                                  //! id da ficha que será encaminhada
$setor_id = $json['setor_id'];                                  //! id do setor que a ficha será encamihada

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário
    $ficha = new ClassFicha($ficha_id);                         //! Obter a ficha pelo id
    $setor = new ClassSetor($setor_id);                         //! Ober o setor pelo id

    $ficha->set_attendant_status("ENCAMINHADO");                // Modificar staus para uma ficha encaminhada
    $ficha->set_attendant_sector($setor);                       // Indicar para qual setor ela deve ser encaminhada

    array_push(
        $dados,
        [
            'tipo' => 'success',
            'mensagem' => "Fichas " . $ficha->get_number() . " foi encaminhada."
        ]
    );

    $log = new ClassLogs(null, $credenciais->get_user(), "ENCAMINHOU FICHA", $ficha, $setor);   //! Criar um log desta operação no sistema
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
