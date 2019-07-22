<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
global $_SG;
// Remove as variáveis da sessão (caso elas existam)
unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
// Manda pra tela de login
header("Location: " . $_SG['paginaLogin'] . "?status=logout");
