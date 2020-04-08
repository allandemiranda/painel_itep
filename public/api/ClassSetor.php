<?php

/**
 * @file ClassSetor.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem os metodos para interação dos setores da empresa com o sistema
 * @version 1.0.0
 * @date 18-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassSetor
{
    private $id;                 //! id do Setor
    private $name;               //! Nome do Setor
    private $admin;              //! Se o Setor tem acesso as configurações do sistema
    private $ficha;              //! Se o Setor é quem emite fichas
    private $deleted;            //! Se o Setor foi deletado do sistema
    private $created_on_date;    //! Data da criaçãodo Setor

    /**
     * @brief Construtor do Objeto ClassSetor 
     *
     * @param id                id do Setor
     * @param name              Nome do Setor
     * @param ficha             Se o Setor tem acesso as configurações do sistema
     * @param admin             Se o Setor tem acesso as configurações do sistema
     * @param deleted           Se o Setor foi deletado do sistema
     * @param created_on_date   Data da criação do Setor
     */
    public function __construct($id = null, $name = null, $ficha = null, $admin = null)
    {
        try {
            $db = new ClassConnection();
            if ($id == null) {
                if (($name == null) or ($admin == null) or ($ficha == null)) {
                    throw new Exception("Erro ao criar um Objeto ClassSetor (parâmetros de entrada incorretos)");
                } else {
                    $result = $db->request_query("INSERT INTO `setores_tb`(`setor_nome`, `setor_ficha`, `setor_admin`) VALUES ('" . $name . "'," . $ficha . "," . $admin . ")");
                    if ($result == TRUE) {
                        $result = $db->request_query("SELECT * FROM `setores_tb` WHERE `setor_id`=" . $db->last_insert_id());
                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                            if ($row['setor_nome'] == $name) {
                                $this->id = $row['setor_id'];
                                $this->name = $row['setor_nome'];
                                $this->ficha = $row['setor_ficha'];
                                $this->admin = $row['setor_admin'];
                                $this->created_on_date = $$row['setor_criado_data'];
                                $this->delete = $row['setor_deletado'];
                            } else {
                                throw new Exception("Erro ao criar um Objeto ClassSetor (nome inválido)");
                            }
                        } else {
                            throw new Exception("Erro ao criar um Objeto ClassSetor (id inválido)");
                        }
                    } else {
                        throw new Exception("Erro ao criar um Objeto ClassSetor (erro no banco de dados)");
                    }
                }
            } else {
                $result = $db->request_query("SELECT * FROM `setores_tb` WHERE `setor_id`=" . $id);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $this->id = $row['setor_id'];
                    $this->name = $row['setor_nome'];
                    $this->ficha = $row['setor_ficha'];
                    $this->admin = $row['setor_admin'];
                    $this->created_on_date = $row['setor_criado_data'];
                    $this->delete = $row['setor_deletado'];
                } else {
                    throw new Exception("Erro ao criar um Objeto ClassSetor (id inválido)");
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Destrutor do Objeto ClassSetor 
     * 
     */
    public function __destruct()
    {
        $this->id = null;
        $this->name = null;
        $this->ficha = null;
        $this->admin = null;
        $this->created_on_date = null;
        $this->delete = null;
    }

    /**
     * @brief Obter o id do Setor
     * 
     * @return id do Setor
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @brief Obter o Nome do Setor
     * 
     * @return Nome do Setor
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @brief Definir o Nome do Setor
     * 
     * @param value Valor do Nome a ser definido
     */
    public function set_name($value)
    {
        try {
            $this->name = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `setores_tb` SET `setor_nome`='" . $this->get_name() . "' WHERE `setor_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Nome do Setor " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter se o Setor e do tipo Administrador
     * 
     * @return Bool Se o Setor é administrador
     */
    public function get_admin()
    {
        return $this->admin;
    }

    /**
     * @brief Definir se o Setor é do tipo Administrador
     * 
     * @param value Se o setor é do tipo Administrador
     */
    public function set_admin(bool $value)
    {
        try {
            if ($value == false) {
                $value = 0;
            }
            $this->admin = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `setores_tb` SET `setor_admin`=" . $this->get_admin() . " WHERE `setor_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Admin do Setor " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a data de criação do Setor
     * 
     * @return Timestamp Data de criação do setor no formato TIMESTAMP
     */
    public function get_created_on_date()
    {
        return $this->created_on_date;
    }

    /**
     * @brief Definir a data de criação do Setor
     * 
     * @param value Data de criação do Setor no formato TIMESTAMP
     */
    public function set_created_on_date($value)
    {
        try {
            $this->created_on_date = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `setores_tb` SET `setor_criado_data`=" . $this->get_created_on_date() . " WHERE `setor_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar data de criação do Setor " . $this->get_name());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a informação se o setor já foi deletado Setor
     * 
     * @return Bool Se o setor já foi deletado
     */
    public function get_deleted()
    {
        return $this->deleted;
    }

    /**
     * @brief Definir se o Setor foi deletado
     * 
     * @param value Se o setor foi deletado
     */
    public function set_deleted(bool $value)
    {
        try {
            if ($value == false) {
                $value = 0;
            }
            $this->deleted = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `setores_tb` SET `setor_deletado`=" . $this->get_deleted() . " WHERE `setor_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar se o Setor " . $this->get_name() . " foi Deletado");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a informação se o setor gerencia as fichas
     * 
     * @return Bool Se o setor gerencia as fichas
     */
    public function get_ficha()
    {
        return $this->ficha;
    }

    /**
     * @brief Definir se o Setor gerencia as fichas
     * 
     * @param value Se o setor gerencia as fichas
     */
    public function set_ficha($value)
    {
        try {
            if ($value == false) {
                $value = 0;
            }
            $this->ficha = $value;
            $db = new ClassConnection();
            $sql = "UPDATE `setores_tb` SET `setor_ficha`=" . $this->get_ficha() . " WHERE `setor_id`=" . $this->get_id();
            $result = $db->request_query($sql);
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar se o Setor " . $this->get_name() . " é Ficha");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
