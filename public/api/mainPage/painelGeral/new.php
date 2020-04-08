<?php

/**
 * @file new.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para criar nova Ficha no Sistema
 * @version 1.0.0
 * @date 24-03-2020
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

$nome = input_check($json['nome']);                             //! Nome da nova ficha
$telefone = input_check($json['telefone']);                     //! Telefone da nova ficha
(int) $setor_id = intval($json['setor_id']);                    //! id so setor da nova ficha
$prioridade = $json['prioridade'];                              //! se a nova ficha é do tipo prioridade

try {
    $credenciais = new ClassCredenciais($login, $senha);                    //! Obter a credencial do usário

    $setor = new ClassSetor($setor_id);                                     //! Obter o setor pelo id

    $ficha = new ClassFicha(null, $nome, $telefone, $setor, $prioridade);   //! Criar uma nova ficha

    // Mensagem de alerta que tudo deu certo
    array_push($dados, [
        "mensagem" => "FICHA CRIADA",
        "numero" => intval($ficha->get_number()),
        "setor" => $ficha->get_attendant_sector()->get_name()
    ]);

    $log = new ClassLogs(null, $credenciais->get_user(), "CRIOU FICHA", $ficha);    //! Criar um log desta operação no sistema
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
