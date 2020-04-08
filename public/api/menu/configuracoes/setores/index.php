<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para listar todos os setores ativos do sistema
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

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário

    // Verificar se a credencial tem permição de listar os setor do sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $db = new ClassConnection();
        $sql = "SELECT `setor_id` FROM `setores_tb` WHERE `setor_deletado`=0";  //! Lista de todos os setores não deletados
        $result = $db->request_query($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Salva todos os setores em no vetor $dados
                $setor = new ClassSetor($row['setor_id']);      //! Obter o setor do id
                array_push(
                    $dados,
                    [
                        'setor_id' => $setor->get_id(),
                        'setor_nome' => $setor->get_name(),
                        'setor_ficha' => $setor->get_ficha(),
                        'setor_admin' => $setor->get_admin(),
                        'setor_criado_data' => date("d/m/Y H:i", strtotime($setor->get_created_on_date()))
                    ]
                );
            }
        } else {
            throw new Exception("Nenhum setor encontrado no banco de dados");
        }
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados);                                   //! Imprime os dados obtidos da requisição
}
