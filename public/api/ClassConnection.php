<?php

/**
 * @file ClassConnection.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com a conexão ao banco de dados
 * @version 1.0.0
 * @date 21-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassConnection
{
    private $servername;    //! Host do servidor
    private $username;      //! Usuário do banco de dados
    private $password;      //! Senha do usuário do banco de dados
    private $dbname;        //! Nome do banco de dados
    private $conn;          //! Conexão com o banco de dados

    /**
     * @brief Construtor da classe atribui as informações da conexão
     * 
     */
    public function __construct()
    {
        $this->set_servername("localhost");     //! Host do servidor
        $this->set_username("admin");           //! Usuário do banco de dados
        $this->set_password("password");        //! Senha do usuário do banco de dados
        $this->set_dbname("chamador");          //! Nome do banco de dados
        $this->connection();                    //! Conectar ao banco da dados
    }

    /**
     * @brief Destrutor da classe dando commit em query aberta e fecha a conexão
     * 
     */
    public function __destruct()
    {
        $this->close_connection();
        $this->set_servername(null);
        $this->set_username(null);
        $this->set_password(null);
        $this->set_dbname(null);
        $this->set_conn(null);
    }

    /**
     * @brief Definir nome do Host do Serviço MySQL
     * 
     * @param value host do Serviço MySQL
     */
    private function set_servername($value)
    {
        $this->servername = $value;
    }

    /**
     * @brief Obter o host do Serviço MySQL
     * 
     * @return String Host que está se usando
     */
    private function get_servername()
    {
        return $this->servername;
    }

    /**
     * @brief Definir o Usuário do Serviço MySQL
     * 
     * @param value O Usuário do Serviço MySQL
     */
    private function set_username($value)
    {
        $this->username = $value;
    }

    /**
     * @brief Obter o Usuário do Serviço MySQL
     * 
     * @return String O Usuário que está se usando
     */
    private function get_username()
    {
        return $this->username;
    }

    /**
     * @brief Definir a Senha do Usuário do Serviço MySQL
     * 
     * @param value Senha do Usuário do Serviço MySQL
     */
    private function set_password($value)
    {
        $this->password = $value;
    }

    /**
     * @brief Obter a Senha do Usuário do Serviço MySQL
     * 
     * @return String Senha do Usuário que está se usando
     */
    private function get_password()
    {
        return $this->password;
    }

    /**
     * @brief Definir o nome do Banco de Dados do Serviço MySQL
     * 
     * @param String value Nome do Banco de Dados do Serviço MySQL
     */
    private function set_dbname($value)
    {
        $this->dbname = $value;
    }

    /**
     * @brief Obter o nome do Banco de Dados do Serviço MySQL
     * 
     * @return String Nome do Banco de dados que está se usando
     */
    private function get_dbname()
    {
        return $this->dbname;
    }

    /**
     * @brief Definir a Conexão Aberta com o Banco de Dados
     * 
     * @param value Objeto com a conexão aberta com o banco de dados
     */
    private function set_conn($value)
    {
        $this->conn = $value;
    }

    /**
     * @brief Obter a Conexão Aberta com o Banco da Dados
     * 
     * @return Object Conexão aberta com o Banco de Dados que está sendo usada
     */
    private function get_conn()
    {
        return $this->conn;
    }

    /**
     * @brief Conecta a classe ao banco de dados para operar as querys SQL
     * 
     */
    private function connection()
    {
        try {
            $this->set_conn(mysqli_connect(
                $this->get_servername(),
                $this->get_username(),
                $this->get_password(),
                $this->get_dbname()
            )); //! Criando conexão com o banco de dados

            if (!$this->get_conn()) {
                throw new Exception(
                    "Falha na conexão com o banco de dados: " . mysqli_connect_error()
                );
            } else {
                mysqli_begin_transaction(
                    $this->get_conn(),
                    MYSQLI_TRANS_START_READ_WRITE
                ); //! Bloqueando entradas de leitura e escrita de outras conexões
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Solicite uma SQL ao bando de dados e veja sua resposta
     * 
     * @param sql Query SQL
     */
    public function request_query($sql)
    {
        try {
            $result = mysqli_query($this->get_conn(), $sql);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Remover todas as solicitações SQL já feitas nessa conexão
     * 
     */
    public function rollback_querys()
    {
        try {
            mysqli_rollback($this->get_conn());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Commita as chamadas já apresentadas
     * 
     */
    private function commit_querys()
    {
        try {
            mysqli_commit($this->get_conn());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Retorna o id gerado automaticamente na última consulta
     * 
     * @return Int id gerado automaticamente na última consulta
     */
    public function last_insert_id()
    {
        try {
            return mysqli_insert_id($this->get_conn());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Fecha a conexão com o banco de dados e destroi o objeto
     * 
     */
    private function close_connection()
    {
        try {
            $this->commit_querys();
            mysqli_close($this->get_conn());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
