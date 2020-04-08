<?php

/**
 * @file new.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para criar um novo Setores do Sistema
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

$nome = input_check($json['nome']);                             //! Nome do novo setor
(bool) $setor_ficha = $json['ficha'];                           //! Se o novo setor irá criar fichas
(bool) $setor_admin = $json['admin'];                           //! Se o novo setor será do tipo administrador

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário

    // Verificar se a credencial tem permição para criar um novo setor no sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $setor = new ClassSetor(null, strtoupper($nome), $setor_ficha, $setor_admin);   //! Cria um novo setor

        // Mensagem de alerta que tudo deu certo
        array_push($dados, [
            "mensagem" => "FUNCIONÁRIO ADICIONADO",
            "nome" => $setor->get_name()
        ]);

        $log = new ClassLogs(null, $credenciais->get_user(), "CRIOU SETOR", $setor);    //! Criar um log desta operação no sistema
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                                //! Imprime os dados obtidos da requisição
}
