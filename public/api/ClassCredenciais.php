<?php

/**
 * @file ClassCredenciais.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe que gerencia a credencial do Funcionário
 * @version 1.0.0
 * @date 28-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassCredenciais
{
    private $user; //! Funcionário Logado no Sistema

    /**
     * @brief Construtor do Objeto ClassCredenciais
     * 
     * @param login Login do Funcionário
     * @param password Senha do Funcionário
     */
    public function __construct($login, $password)
    {
        try {
            $db = new ClassConnection();
            $sql = "SELECT `usuario_id` FROM `usuarios_tb` WHERE `usuario_login`='" . $login . "' AND `usuario_senha`='" . $password . "' AND `usuario_deletado`=0";
            $result = $db->request_query($sql);
            $db = null;
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $new_user = new ClassUsuario($row['usuario_id']);
                $this->set_user($new_user);
            } else {
                throw new Exception("LOGIN OU SENHA INVÁLIDO");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @brief Definir Funcionário do Sistema
     * 
     * @param value Funcionário do Sistema
     */
    private function set_user($value)
    {
        $this->user = $value;
    }

    /**
     * @brief Obter Funcionário do Sistema
     * 
     * @return ClassUsuario Duncionáriodo Sistema
     */
    public function get_user()
    {
        return $this->user;
    }
}
