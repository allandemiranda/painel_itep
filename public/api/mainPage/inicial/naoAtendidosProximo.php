<?php

/**
 * @file naoAtendidoProximo.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para gerenciar a próxima ficha a ser chamada
 * @version 1.0.0
 * @date 26-03-2020
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

/**
 * @brief Define a ficha para CHAMAR (EM ATENDIMENTO)
 * 
 * @param id id da Ficha
 * @param user usuário que está atendendo a ficha
 * @return Array Mensagem
 */
function set_emAtendimento($id, $user)
{
    $ficha = new ClassFicha($id);
    $ficha->set_attendant_status("CHAMAR");
    $ficha->set_attendant_user($user);
    $msg = [
        'tipo' => 'success',
        'mensagem' => "Fichas " . $ficha->get_number() . " foi chamada."
    ];
    $log = new ClassLogs(null, $user, "CHAMOU FICHA", $ficha); //! Criar um log desta operação no sistema
    return $msg;
}

try {
    $credenciais = new ClassCredenciais($login, $senha);        //! Obter a credencial do usário
    $db = new ClassConnection();

    $today = date("Y-m-d");                                     //! Data do dia atual

    // Verifique se exitem fichas disponíveis para serem chamadas
    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO')";
    $result = $db->request_query($sql);
    if (mysqli_num_rows($result) > 0) {
        // Se tiver ficha em espera verifique o tipo de prioridade da última ficha que está em atendimento
        $sql = "SELECT `ficha_prioridade` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND `ficha_status`='EM ATENDIMENTO' ORDER BY `ficha_atualizacao_data` DESC LIMIT 1";
        $result = $db->request_query($sql);
        if (mysqli_num_rows($result) == 1) {
            // Se houver ficha em atendimento
            if (mysqli_fetch_assoc($result)['ficha_prioridade'] == 1) {
                // Se a última ficha em atendimento foi com prioridade, selecione a próxima sem prioridade 
                $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=0 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                $result = $db->request_query($sql);
                if (mysqli_num_rows($result) == 1) {
                    // Se houver ficha sem prioridade adicione ao vetor de dados               
                    array_push(
                        $dados,
                        set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                    );
                } else {
                    // Se não houver ficha sem prioridade, chame uma com prioridade mesmo
                    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=1 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                    $result = $db->request_query($sql);
                    // Tratar possiveis erros
                    if (mysqli_num_rows($result) == 1) {
                        // Adicione ao vetor de dados
                        array_push(
                            $dados,
                            set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                        );
                    } else {
                        throw new Exception("Erro ao tentar chamar próxima ficha", 1);
                    }
                }
            } else {
                // Se a última ficha em atendimento foi sem prioridade, selecione a próxima com prioridade 
                $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=1 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                $result = $db->request_query($sql);
                if (mysqli_num_rows($result) == 1) {
                    // Se houver ficha com prioridade adicione ao vetor de dados
                    array_push(
                        $dados,
                        set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                    );
                } else {
                    // Se não houver ficha com prioridade, chame uma sem prioridade mesmo
                    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=0 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                    $result = $db->request_query($sql);
                    // Tratar possiveis erros
                    if (mysqli_num_rows($result) == 1) {
                        // Adicione ao vetor de dados
                        array_push(
                            $dados,
                            set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                        );
                    } else {
                        throw new Exception("Erro ao tentar chamar próxima ficha", 2);
                    }
                }
            }
        } else {
            // Já que não tem ficha em atendimento, verifique nas fichas finalizadas
            $sql = "SELECT `ficha_prioridade` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND `ficha_status`='FINALIZADO' ORDER BY `ficha_atualizacao_data` DESC LIMIT 1";
            $result = $db->request_query($sql);
            if (mysqli_num_rows($result) == 1) {
                // Se houver ficha finalizada
                if (mysqli_fetch_assoc($result)['ficha_prioridade'] == 1) {
                    // Se a última ficha finalizada foi com prioridade, selecione a próxima sem prioridade 
                    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=0 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                    $result = $db->request_query($sql);
                    if (mysqli_num_rows($result) == 1) {
                        // Se houver ficha sem prioridade adicione ao vetor de dados               
                        array_push(
                            $dados,
                            set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                        );
                    } else {
                        // Se não houver ficha sem prioridade, chame uma com prioridade mesmo
                        $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=1 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                        $result = $db->request_query($sql);
                        // Tratar possiveis erros
                        if (mysqli_num_rows($result) == 1) {
                            // Adicione ao vetor de dados
                            array_push(
                                $dados,
                                set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                            );
                        } else {
                            throw new Exception("Erro ao tentar chamar próxima ficha", 3);
                        }
                    }
                } else {
                    // Se a última ficha finalizada foi sem prioridade, selecione a próxima com prioridade 
                    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=1 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                    $result = $db->request_query($sql);
                    if (mysqli_num_rows($result) == 1) {
                        // Se houver ficha com prioridade adicione ao vetor de dados
                        array_push(
                            $dados,
                            set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                        );
                    } else {
                        // Se não houver ficha com prioridade, chame uma sem prioridade mesmo
                        $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=0 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                        $result = $db->request_query($sql);
                        // Tratar possiveis erros
                        if (mysqli_num_rows($result) == 1) {
                            // Adicione ao vetor de dados
                            array_push(
                                $dados,
                                set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                            );
                        } else {
                            throw new Exception("Erro ao tentar chamar próxima ficha", 4);
                        }
                    }
                }
            } else {
                // Se não tiver chamado nenhum ficha no dia atual, então chame o primeiro com prioridade
                $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=1 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                $result = $db->request_query($sql);
                if (mysqli_num_rows($result) == 1) {
                    // Se houver uma ficha com prioridade, adicione ao vetor de dados
                    array_push(
                        $dados,
                        set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                    );
                } else {
                    // Como não tem ficha com prioridade, chame uma sem prioridade
                    $sql = "SELECT `ficha_id` FROM `fichas_tb` WHERE `ficha_criacao_data`>='" . $today . "' AND `ficha_setor_id`=" . $credenciais->get_user()->get_sector()->get_id() . " AND (`ficha_status`='NÃO ATENDIDO' OR  `ficha_status`='ENCAMINHADO') AND `ficha_prioridade`=0 ORDER BY `ficha_atualizacao_data` ASC LIMIT 1";
                    $result = $db->request_query($sql);
                    // Tratar possiveis erros
                    if (mysqli_num_rows($result) == 1) {
                        // Adicione ao vetor de dados
                        array_push(
                            $dados,
                            set_emAtendimento(mysqli_fetch_assoc($result)['ficha_id'], $credenciais->get_user())
                        );
                    } else {
                        throw new Exception("Erro ao tentar chamar próxima ficha", 5);
                    }
                }
            }
        }
    } else {
        // Não existe nenhuma ficha na fila de espera
        array_push(
            $dados,
            [
                'tipo' => 'warning',
                'mensagem' => "Não existem fichas a ser chamada."
            ]
        );
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados);                                       //! Imprime os dados obtidos da requisição
}
