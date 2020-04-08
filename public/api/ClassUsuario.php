<?php

/**
 * @file ClassUsuario.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem os metodos para interação do usuário com o sistema
 * @version 1.0.0
 * @date 17-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassUsuario
{
    private $id;                //! id do Funcionário
    private $name;              //! Nome do Funcionário
    private $sector;            //! Objeto Setor do Funcionário
    private $login;             //! Login do Funcionário
    private $password;          //! Senha do Funcionário criptografada em MD5
    private $deleted;           //! Se o Funcionário foi deletado do sistema
    private $created_on_date;   //! Data da criação do Funcionário no sistema

    /**
     * @brief Construtor do Objeto ClassUsuario 
     *
     * @param id id do Funcionário
     * @param name Nome do Funcionário
     * @param sector Setor que o Funcionário trabalha
     * @param login Login do Funcionário no Sistema
     * @param password Senha do Funcionário no Sistema
     * @param deleted Se o Funcionário foi deletado do sistema
     * @param created_on_date Data da criação do Funcionário no Sistema
     */
    public function __construct($id = null, $name = null, $sector = null, $login = null, $password = null)
    {
        try {
            $db = new ClassConnection();
            if ($id == null) {
                if (($name == null) or ($sector == null) or ($login == null) or ($password == null)) {
                    throw new Exception("Erro ao criar um Objeto ClassUsuario (parâmetros de entrada incorretos)");
                } else {
                    $result = $db->request_query("INSERT INTO `usuarios_tb` (`usuario_nome`, `usuario_setor_id`, `usuario_login`, `usuario_senha`) VALUES ('" . $name . "', " . $sector->get_id() . ", '" . $login . "','" . $password . "')");
                    if ($result == TRUE) {
                        $result = $db->request_query("SELECT * FROM `usuarios_tb` WHERE `usuario_id`=" . $db->last_insert_id());
                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                            if ($row['usuario_nome'] == $name) {
                                $this->id = $row['usuario_id'];
                                $this->name = $row['usuario_nome'];
                                $this->sector = $sector;
                                $this->login = $row['usuario_login'];
                                $this->password = $row['usuario_senha'];
                                $this->delete = $row['usuario_deletado'];
                                $this->created_on_date = $row['usuario_criado_data'];
                            } else {
                                throw new Exception("Erro ao criar um Objeto ClassUsuario (nome inválido)");
                            }
                        } else {
                            throw new Exception("Erro ao criar um Objeto ClassUsuario (id inválido)");
                        }
                    } else {
                        throw new Exception("Erro ao criar um Objeto ClassUsuario (erro no banco de dados)");
                    }
                }
            } else {
                $result = $db->request_query("SELECT * FROM `usuarios_tb` WHERE `usuario_id`=" . $id);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $this->id = $row['usuario_id'];
                    $this->name = $row['usuario_nome'];
                    $this->sector = new ClassSetor($row['usuario_setor_id']);
                    $this->login  = $row['usuario_login'];
                    $this->password = $row['usuario_senha'];
                    $this->delete = $row['usuario_deletado'];
                    $this->created_on_date = $row['usuario_criado_data'];
                } else {
                    throw new Exception("Erro ao criar um Objeto ClassUsuario (id inválido)");
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Destrutor do Objeto ClassUsuario
     * 
     */
    public function __destruct()
    {
        $this->id = null;
        $this->name = null;
        $this->sector = null;
        $this->login = null;
        $this->password = null;
        $this->deleted = null;
        $this->created_on_date = null;
    }

    /**
     * @brief Obter o id do Funcionário
     * 
     * @return Int id do Funcionário
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @brief Obter Nome do Funcionário
     * 
     * @return String Nome do Funcionário
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @brief Definir Nome do Funcionário
     * 
     * @param value Novo Nome do Funcionário
     */
    public function set_name($value)
    {
        try {
            $this->name = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `usuarios_tb` SET `usuario_nome`='" . $this->get_name() . "' WHERE `usuario_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Nome do Funcionário " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter Setor associado ao Funcionário
     * 
     * @return ClassSetor Setor do Funcionário
     */
    public function get_sector()
    {
        return $this->sector;
    }

    /**
     * @brief Definir o Setor associado ao Funcionário
     * 
     * @param value Setor do Funcionário
     */
    public function set_sector($value)
    {
        try {
            //$this->sector->__destruct();
            $this->sector = null;
            $this->sector = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `usuarios_tb` SET `usuario_setor_id`='" . $this->get_sector()->get_id() . "' WHERE `usuario_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar id do Setor do Funcionário " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o Login do Funcionário
     * 
     * @return String Login do Funcionário
     */
    public function get_login()
    {
        return $this->login;
    }

    /**
     * @brief Definir o Login do Funcioário
     * 
     * @param value Novo Login do Funcionário
     */
    public function set_login($value)
    {
        try {
            $this->login = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `usuarios_tb` SET `usuario_login`='" . $this->get_login() . "' WHERE `usuario_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Login do Funcionário " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a Senha do Funcionário na criptografia md5
     * 
     * @return md5 Senha do Funcionário na criptografia md5
     */
    public function get_password()
    {
        return $this->password;
    }

    /**
     * @brief Definir a Senha do Funcionário na criptografia md5
     * 
     * @param value Nova Senha do Funcionário na criptografia md5
     */
    public function set_password($value)
    {
        try {
            $this->password = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `usuarios_tb` SET `usuario_senha`='" . $this->get_password() . "' WHERE `usuario_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Senha do Funcionário " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a informação se o Funcionário já foi deletado
     * 
     * @return Bool Se o Funcionário já foi deletado
     */
    public function get_deleted()
    {
        return $this->deleted;
    }

    /**
     * @brief Definir se o Funcionário foi deletado
     * 
     * @param value Se o Funcionário foi deletado
     */
    public function set_deleted(bool $value)
    {
        try {
            if ($value == false) {
                $value = 0;
            }
            $this->deleted = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `usuarios_tb` SET `usuario_deletado`=" . $this->get_deleted() . " WHERE `usuario_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar se o Funcionário " . $this->get_name() . " foi Deletado");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a data que o Funcionário foi criado
     * 
     * @return Timestamp Data da criação do Funcionário
     */

    public function get_created_on_date()
    {
        return $this->created_on_date;
    }

    /**
     * @brief Definir a data que o Funcionário foi criado
     * 
     * @param value Data de criação do Funcionário no Sistema em TIMESTAMP
     */
    public function set_created_on_date($value)
    {
        $this->created_on_date = $value;
    }
}
