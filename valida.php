<?php
// Inclui o arquivo com o sistema de segurança
require_once("seguranca.php");
// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Salva duas variáveis com o que foi digitado no formulário
    // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
    $usuario = (isset($_POST['usuario_login'])) ? $_POST['usuario_login'] : '';
    $senha = (isset($_POST['usuario_senha'])) ? $_POST['usuario_senha'] : '';
    $senha = md5($senha);
    // Utiliza uma função criada no seguranca.php pra validar os dados digitados
    if (validaUsuario($usuario, $senha) == true) {
        // O usuário e a senha digitados foram validados, manda pra página interna
        log_up("warning", "Usuário " . $usuario . " fez o login com ip " . $_SERVER["REMOTE_ADDR"]);
        header("Location: index.php");
    } else {
        // O usuário e/ou a senha são inválidos, manda de volta pro form de login
        // Para alterar o endereço da página de login, verifique o arquivo seguranca.php
        log_up("danger", "Erro ao vazer login com o " . $usuario . " ip " . $_SERVER["REMOTE_ADDR"]);
        expulsaVisitanteErro();
    }
}