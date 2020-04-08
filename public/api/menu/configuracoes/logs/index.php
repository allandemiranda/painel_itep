<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para exibir a lista de logs do sistema
 * @version 1.0.0
 * @date 13-03-2020
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
    $credenciais = new ClassCredenciais($login, $senha);                    //! Obter a credencial do usário

    // Verificar se a credencial tem permição de obter lista de logs
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $credenciais = null;
        $db = new ClassConnection();
        $sql = "SELECT `log_id` FROM `logs_tb` ORDER BY `log_id` DESC";     //! Obter a lista de logs cadastradas no sistema
        $result = $db->request_query($sql);
        $db = null;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Salvar todas os logs no vetor $dados
                $log = new ClassLogs($row['log_id']);
                array_push(
                    $dados,
                    [
                        'log_id' => intval($log->get_log_id()),
                        'log_usuario_nome' => $log->get_log_usuario_nome(),
                        'log_usuario_setor_nome' => $log->get_log_usuario_setor_nome(),
                        'log_data_criacao' => date("d/m/Y H:i", strtotime($log->get_log_data_criacao())),
                        'log_acao' => $log->get_log_acao(),
                        'log_de_nome' => $log->get_log_de_nome(),
                        'log_de_setor_nome' => $log->get_log_de_setor_nome(),
                        'log_de_numero' => $log->get_log_de_numero(),
                        'log_de_telefone' => $log->get_log_de_telefone(),
                        'log_para_nome' => $log->get_log_para_nome(),
                        'log_ip' => $log->get_log_ip()
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
    echo json_encode($dados);                                       //! Imprime os dados obtidos da requisição
}
