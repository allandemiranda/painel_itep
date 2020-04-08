<?php

/**
 * @file new.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a lógica para criar um novo Funcionário do Sistema
 * @version 1.0.0
 * @date 09-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */
?>
<?php

include($_SERVER['DOCUMENT_ROOT'] . '/api/HeaderJSON.php'); //! Cabeçalho para conteudo json
include($_SERVER['DOCUMENT_ROOT'] . '/api/Header.php');     //! Cabeçalho com as classes e funções gerias

/**
 * @brief Gera um login válido a partir do nome do Usuário
 * 
 * @param name Nome do usuário do sistema
 * @return String login válido para o usuário
 */
function makeLogin($name)
{
    try {
        $login_pieces = explode(" ", $name);                //! Explode o nome do usuário

        $login_new = $login_pieces[0];                      //! Adiciona o primeiro nome a um novo login
        $login_new = $login_new . ".";                      //! Adiciona um ponto ao novo login
        $login_new = $login_new . end($login_pieces);       //! Adiciona o último nome do usuário ano novo login

        $db = new ClassConnection();
        $sql = "SELECT `usuario_id` FROM `usuarios_tb` WHERE `usuario_login`='" . $login_new . "'";     //! Verifica se algum usuário já possui este login

        // Lógica para adicionar uma ordem numérica caso o login pré definido já exista
        $login_fast = $login_new;
        $number = 1;
        $login_new = $login_new . ".";
        $login_new = $login_new . $number;
        while (mysqli_num_rows($db->request_query($sql)) > 0) {
            $sql = "SELECT `usuario_id` FROM `usuarios_tb` WHERE `usuario_login`='" . $login_new . "'";
            $login_fast = $login_new;
            $login_temp = explode($number, $login_new);
            $login_new = $login_temp[0];
            $number++;
            $login_new = $login_new . $number;
        }

        return $login_fast;
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

$dados = [];                                    //! Contem todos os dados a serem enviados

$body = file_get_contents('php://input');       //! Obtém todas as informações requisitadas POST
$json = json_decode($body, true);               //! Decodifica as informações requisitadas

$login = $json['login'];                        //! Login do usuário que requisitou a informação
$senha = $json['senha'];                        //! Senha criptografada do usuário que requisitou a informação

$nome = $json['nome'];                          //! Nome do novo usuário do sistema
(int) $setor_id = intval($json['setor']);       //! id do setor do novo usuário do sistema

$password = generatorPassword();                //! Nova senha do novo usuário do sistema
$password_crypt = encrypt_password($password);  //! Criptografando a nova senha

try {
    $credenciais = new ClassCredenciais($login, $senha);    //! Obter a credencial do usário

    // Verificar se a credencial tem permição para criar um novo setor no sistema
    if ($credenciais->get_user()->get_sector()->get_admin() == false) {
        throw new Exception("Usuário não possui credencial para esta operação!");
    } else {
        $login_user = makeLogin(strtolower($nome));         //! Criar um login para o novo usuário

        $setor = new ClassSetor($setor_id);                 //! Obter o setor do id

        $usuario = new ClassUsuario(null, strtoupper($nome), $setor, $login_user, $password_crypt);     //! Criado um novo usuário

        // Mensagem de alerta que tudo deu certo
        array_push($dados, [
            "mensagem" => "FUNCIONÁRIO ADICIONADO",
            "login" => $login_user,
            "password" => $password
        ]);

        $log = new ClassLogs(null, $credenciais->get_user(), "CRIOU USUÁRIO", $usuario);                //! Criar um log desta operação no sistema
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    array_push($dados, [
        "mensagem" => $msg
    ]);
} finally {
    echo json_encode($dados[0]);                //! Imprime os dados obtidos da requisição
}
