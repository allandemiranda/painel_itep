<?php

/**
 * @file Header.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem todo o cabeçalho com classes e funções gerais do sistema
 * @version 1.0.0
 * @date 02-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */
?>
<?php

// Classes existentes no sistema
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassConnection.php');    //! ClassConnection
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassUsuario.php');       //! ClassUsuario
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassSetor.php');         //! ClassSetor
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassFicha.php');         //! ClassFicha
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassCompany.php');       //! ClassCompany
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassCredenciais.php');   //! ClassCredenciais
include($_SERVER['DOCUMENT_ROOT'] . '/api/ClassLogs.php');          //! ClassLogs


/**
 * @brief Criptografa a Senha do Funcionário para o padrão adotado no sistema
 * 
 * @return String Senha criptografada
 */
function encrypt_password($value)
{
    try {
        return md5($value);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

/**
 * @brief Validar entradas para evitar injeção de código errado
 *
 * @param valor Um valor de entrada a ser analisado
 * @return String Valor validado para interação
 */
function input_check($valor)
{
    try {
        $valor = trim($valor);
        $valor = stripslashes($valor);
        $valor = htmlspecialchars($valor);
        return $valor;
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

/**
 * @brief Função para gerar senhas aleatórias
 *
 * @param tamanho Tamanho da senha a ser gerada
 * @param minusculas Se terá letras minusculas
 * @param numeros Se terá números
 * @param simbolos Se terá símbolos
 *
 * @return String A senha gerada
 */
function generatorPassword($tamanho = 5, $minusculas = false, $numeros = true, $simbolos = false)
{
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';

    $caracteres .= $lmai;
    if ($minusculas) $caracteres .= $lmin;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;

    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
}
