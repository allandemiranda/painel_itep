<?php

/**
 * @file index.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para listar todos os usuários ativos do sistema
 * @version 1.0.0
 * @date 09-03-2020
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
    $credenciais = new ClassCredenciais($login, $senha);                                        //! Obter a credencial do usário

    // Verificar se a credencial tem permição de listar os usuários do sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $credenciais = null;
        $db = new ClassConnection();

        // Criar a lista de setores não deletados do sistema para a coluna de setores do usuário
        $setores = [];
        $sql = "SELECT `setor_id`, `setor_nome` FROM `setores_tb` WHERE `setor_deletado`=0";    //! Lista de todos os setores não deletados
        $result = $db->request_query($sql);        
        if (mysqli_num_rows($result) > 0) {
            // Salva todos os setores em no vetor $setores referenciando sua posição ao id so setor
            while ($row = mysqli_fetch_assoc($result)) {
                $setores[$row["setor_id"]] = $row["setor_nome"];
            }

            // Adicionar ao vetor $dados o vetor com os setores do sistema obtidos
            array_push($dados, $setores);
            $setores = null;
        } else {
            throw new Exception("Nenhum setor encontrado no banco de dados");
        }

        // Criar a lista de usuários não deletados do sistema
        $usuarios = [];
        $sql = "SELECT `usuario_id` FROM `usuarios_tb` WHERE `usuario_deletado`=0";             //! Lista de todos os usuários não deletados
        $result = $db->request_query($sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $usuario = new ClassUsuario($row['usuario_id']);                                //! Obter o usuário do id
                // Salva todos os usuários em no vetor $usuarios
                array_push(
                    $usuarios,
                    [
                        'usuario_id' => $usuario->get_id(),
                        'usuario_nome' => $usuario->get_name(),
                        'setor_id' => $usuario->get_sector()->get_id(),
                        'usuario_login' => $usuario->get_login(),
                        'usuario_criacao_data' => date("d/m/Y H:i", strtotime($usuario->get_created_on_date()))
                    ]
                );
            }

            // Adicionar ao vetor $dados os usuários do sistema obtidos
            array_push($dados, $usuarios);
            $usuarios = null;
        } else {
            throw new Exception("Nenhum funcionário encontrado no banco de dados");
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
