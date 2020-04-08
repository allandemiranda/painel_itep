<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para exibir a lista de fichas do sistema
 * @version 1.0.0
 * @date 30-03-2020
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

    // Verificar se a credencial tem permição de obter lista de fichas
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $credenciais = null;
        $db = new ClassConnection();
        $sql = "SELECT `ficha_id` FROM `fichas_tb` ORDER BY `ficha_id` DESC";   //! Obter a lista de fichas cadastradas no sistema
        $result = $db->request_query($sql);
        $db = null;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Salvar todas as fichas no vetor $dados
                $ficha = new ClassFicha($row['ficha_id']);
                array_push(
                    $dados,
                    [
                        'ficha_id' => intval($ficha->get_id()),
                        'ficha_numero' => intval($ficha->get_number()),
                        'ficha_nome' => $ficha->get_name(),
                        'ficha_telefone' => $ficha->get_phone(),
                        'ficha_prioridade' => intval($ficha->get_priority()),
                        'ficha_setor_nome' => $ficha->get_attendant_sector()->get_name(),
                        'ficha_status' => $ficha->get_attendant_status(),
                        'ficha_criacao_data' => date("d/m/Y H:i", strtotime($ficha->get_date())),
                        'ficha_atualizacao_data' => date("d/m/Y H:i", strtotime($ficha->get_date_update()))
                    ]
                );
            }
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
