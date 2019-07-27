<?php
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = true;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
$_SG['servidor'] = 'localhost';    // Servidor MySQL
$_SG['usuario'] = 'allandemiranda';          // Usuário MySQL
$_SG['senha'] = 'senha1234';                // Senha MySQL
$_SG['banco'] = 'sistema_itep';            // Banco de dados MySQL
$_SG['paginaLogin'] = 'login.php'; // Página de login
$_SG['tabela'] = 'usuarios_tb';       // Nome da tabela onde os usuários são salvos
// ==============================
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
    $_SG['link'] = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']) or die("MySQL: Não foi possível conectar-se ao servidor [" . $_SG['servidor'] . "].");
    //mysqli_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [" . $_SG['banco'] . "].");
}
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
    session_start();
/**
 * Função que valida um usuário e senha
 *
 * @param string $usuario - O usuário a ser validado
 * @param string $senha - A senha a ser validada
 *
 * @return bool - Se o usuário foi validado ou não (true/false)
 */
function validaUsuario($usuario, $senha)
{
    global $_SG;
    $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
    // Usa a função addslashes para escapar as aspas
    $nusuario = addslashes($usuario);
    $nsenha = $senha;
    // Monta uma consulta SQL (query) para procurar um usuário
    $sql = "SELECT `usuario_id`, `usuario_nome` , `usuario_cadastrado` FROM `" . $_SG['tabela'] . "` WHERE " . $cS . " `usuario_login` = '" . $nusuario . "' AND " . $cS . " `usuario_senha` = '" . $nsenha . "' LIMIT 1";
    $query = mysqli_query($_SG['link'], $sql);
    $resultado = mysqli_fetch_assoc($query);
    // Verifica se encontrou algum registro
    if (empty($resultado)) {
        // Nenhum registro foi encontrado => o usuário é inválido
        return false;
    } else {
        // Definimos dois valores na sessão com os dados do usuário
        $_SESSION['usuarioID'] = $resultado['usuario_id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
        $_SESSION['usuarioNome'] = $resultado['usuario_nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
        $_SESSION['usuario_cadastrado'] = $resultado['usuario_cadastrado'];
        // Verifica a opção se sempre validar o login
        if ($_SG['validaSempre'] == true) {
            // Definimos dois valores na sessão com os dados do login
            $_SESSION['usuarioLogin'] = $usuario;
            $_SESSION['usuarioSenha'] = $senha;
        }
        return true;
    }
}
/**
 * Função que protege uma página
 */
function protegePagina()
{
    global $_SG;
    if (!isset($_SESSION['usuarioID']) or !isset($_SESSION['usuarioNome'])) {
        // Não há usuário logado, manda pra página de login
        expulsaVisitanteOff();
    } else if (!isset($_SESSION['usuarioID']) or !isset($_SESSION['usuarioNome'])) {
        // Há usuário logado, verifica se precisa validar o login novamente
        if ($_SG['validaSempre'] == true) {
            // Verifica se os dados salvos na sessão batem com os dados do banco de dados
            if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
                // Os dados não batem, manda pra tela de login
                expulsaVisitanteErro();
            }
        }
    }
    if ($_REQUEST["status"] == "logout") {
        expulsaVisitanteOff();
    }
    if ($_REQUEST["status"] == "") {
        if ($_SESSION["usuario_cadastrado"] == 0) {
            header("Location: cadastro.php?status=on");
        }
    }
}
/**
 * Função para expulsar um visitante
 */
function expulsaVisitanteOff()
{
    global $_SG;
    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
    // Manda pra tela de login
    header("Location: " . $_SG['paginaLogin'] . "?status=off");
}
/**
 * Função para expulsar um visitante
 */
function expulsaVisitanteErro()
{
    global $_SG;
    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
    // Manda pra tela de login
    header("Location: " . $_SG['paginaLogin'] . "?status=erro");
}
/**
 * Função para expulsar um visitante
 */
function expulsaVisitanteCadastro()
{
    global $_SG;
    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
    // Manda pra tela de login
    header("Location: " . $_SG['paginaLogin'] . "?status=cadastroOK");
}

function exigirAdmin()
{
    global $_SG;
    $sql_exigirAdmin = "SELECT `setor_admin` FROM `setores_tb` WHERE `setor_id`=(SELECT`usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
    $query_exigirAdmin = mysqli_query($_SG['link'], $sql_exigirAdmin);
    $row_exigirAdmin = mysqli_fetch_assoc($query_exigirAdmin);
    if ($row_exigirAdmin['setor_admin'] == "0") {
        header("Location: 404.php");
    }
}
