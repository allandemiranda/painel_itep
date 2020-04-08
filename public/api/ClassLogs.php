<?php

/**
 * @file ClassLogs.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem os metodos para interação dos logs do sistema
 * @version 1.0.0
 * @date 12-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassLogs
{
    private $id;                            //! id do log registrado
    private $log_usuario_nome;              //! Nome do Usuário que criou o Log 
    private $log_usuario_setor_nome;        //! Nome do Setor do Usuário que criou o Log 
    private $log_acao;                      //! Ação do Log 
    private $log_de_nome = null;            //! Nome do Usuário ou do Setor que sofreu a Ação 
    private $log_de_setor_nome = null;      //! Caso a Ação seja para um Usuário, este é o nome do Setor dele 	
    private $log_de_numero = null;          //! Número da Ficha que sofreu a Ação 
    private $log_de_telefone = null;        //! Telefone da Ficha que sofreu a Ação 
    private $log_para_nome = null;          //! Nome do Setor para onde foi encaminhado a Ficha 
    private $log_ip;                        //! ip do Usuário 
    private $log_data_criacao;              //! Data de criação do Log 

    /**
     * @brief Construtor do Objeto ClassLogs 
     * 
     * @param id id do Log
     * @param user Usuário que gerou o log
     * @param action Ação aplicada pelo Usuário que gerou o log ["CRIOU USUÁRIO","CRIOU SETOR","EXCLUIU USUÁRIO",
     *              "EXCLUIU SETOR","ATUALIZOU USUÁRIO","ATUALIZOU SETOR","ATUALIZOU PERFIL","CRIOU FICHA",
     *              "CHAMOU FICHA","ENCAMINHOU FICHA","FINALIZOU FICHA"] 
     * @param first Sujeito que sofreu a ação 
     * @param second Possivel segundo Sujeito que sofreu a ação
     */
    public function __construct($id, $user = null, $action = null, $first = null, $second = null)
    {
        try {
            if ($id == null) {
                if ($this->check_action($action) == false) {
                    throw new Exception("Erro ao criar um Objeto ClassLogs (parâmetros action incorreto)");
                } else {
                    $this->set_log_acao($action);
                    $this->set_log_ip($_SERVER['REMOTE_ADDR']);

                    if (get_class($user) == "ClassUsuario") {
                        $this->set_log_usuario_nome($user->get_name());
                        $this->set_log_usuario_setor_nome($user->get_sector()->get_name());
                    } else {
                        throw new Exception("Erro ao criar um Objeto ClassLogs (parâmetros user incorreto)");
                    }

                    if ($first != null) {
                        switch (get_class($first)) {
                            case "ClassUsuario":
                                $this->set_log_de_nome($first->get_name());
                                $this->set_log_de_setor_nome($first->get_sector()->get_name());
                                break;
                            case "ClassSetor":
                                $this->set_log_de_nome($first->get_name());
                                break;
                            case "ClassFicha":
                                $this->set_log_de_nome($first->get_name());
                                $this->set_log_de_numero($first->get_number());
                                $this->set_log_de_setor_nome($first->get_attendant_sector()->get_name());
                                $this->set_log_de_telefone($first->get_phone());
                                break;
                            default:
                                throw new Exception("Erro ao criar um Objeto ClassLogs (parâmetros first incorreto)");
                                break;
                        }
                    }

                    if ($second != null) {
                        if (get_class($second) == "ClassSetor") {
                            $this->set_log_para_nome($second->get_name());
                        } else {
                            throw new Exception("Erro ao criar um Objeto ClassLogs (parâmetros second incorreto)");
                        }
                    }

                    $db = new ClassConnection();
                    $sql = "INSERT INTO `logs_tb`(`log_usuario_nome`, `log_usuario_setor_nome`, `log_acao`, `log_de_nome`, `log_de_setor_nome`, `log_de_numero`, `log_de_telefone`, `log_para_nome`, `log_ip`) VALUES ('" . $this->get_log_usuario_nome() . "', '" . $this->get_log_usuario_setor_nome() . "', '" . $this->get_log_acao() . "','" . $this->get_log_de_nome() . "','" . $this->get_log_de_setor_nome() . "','" . $this->get_log_de_numero() . "','" . $this->get_log_de_telefone() . "','" . $this->get_log_para_nome() . "','" . $this->get_log_ip() . "')";
                    if ($db->request_query($sql) == TRUE) {
                        $result = $db->request_query("SELECT `log_data_criacao` FROM `logs_tb` WHERE `log_id`=" . $db->last_insert_id());
                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                            $this->set_log_data_criacao($row['log_data_criacao']);
                        } else {
                            throw new Exception("Erro ao criar um Objeto ClassLogs (erro no banco de dados)");
                        }
                    } else {
                        throw new Exception("Erro ao criar um Objeto ClassLogs (erro no banco de dados)");
                    }
                    $db = null;
                }
            } else {
                $db = new ClassConnection();
                $sql = "SELECT `log_id`, `log_usuario_nome`, `log_usuario_setor_nome`, `log_data_criacao`, `log_acao`, `log_de_nome`, `log_de_setor_nome`, `log_de_numero`, `log_de_telefone`, `log_para_nome`, `log_ip` FROM `logs_tb` WHERE `log_id`=" . $id;
                $result = $db->request_query($sql);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $this->set_log_id($row['log_id']);
                    $this->set_log_usuario_nome($row['log_usuario_nome']);
                    $this->set_log_usuario_setor_nome($row['log_usuario_setor_nome']);
                    $this->set_log_acao($row['log_acao']);
                    $this->set_log_de_nome($row['log_de_nome']);
                    $this->set_log_de_setor_nome($row['log_de_setor_nome']);
                    $this->set_log_de_numero($row['log_de_numero']);
                    $this->set_log_de_telefone($row['log_de_telefone']);
                    $this->set_log_para_nome($row['log_para_nome']);
                    $this->set_log_ip($row['log_ip']);
                    $this->set_log_data_criacao($row['log_data_criacao']);
                } else {
                    throw new Exception("Erro ao criar um Objeto ClassLogs (id inválido)");
                }

                $db = null;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Destrutor do Objeto ClassLogs 
     * 
     */
    public function __destruct()
    {
        $this->id = null;
        $this->log_usuario_nome = null;
        $this->log_usuario_setor_nome = null;
        $this->log_acao = null;
        $this->log_de_nome = null;
        $this->log_de_setor_nome = null;
        $this->log_de_numero = null;
        $this->log_de_telefone = null;
        $this->log_para_nome = null;
        $this->log_ip = null;
        $this->log_data_criacao = null;
    }

    /**
     * @brief Obter o id do Log
     * 
     * @return Int id do Log
     */
    public function get_log_id()
    {
        return $this->id;
    }

    /**
     * @brief definir o id do Log
     * 
     * @param id id do Log
     */
    private function set_log_id($id)
    {
        $this->id = $id;
    }

    /**
     * @brief Verificar se a Ação é válida
     * 
     * @param action Ação gerada
     * @return Boolean Se a Ação é válida  
     */
    private function check_action($action)
    {
        /**
         * @param messenger Contem todas as possiveis ações do sistema
         */
        $messenger = array(
            "CRIOU USUÁRIO",
            "CRIOU SETOR",
            "EXCLUIU USUÁRIO",
            "EXCLUIU SETOR",
            "ATUALIZOU USUÁRIO",
            "ATUALIZOU SETOR",
            "ATUALIZOU PERFIL",
            "CRIOU FICHA",
            "CHAMOU FICHA",
            "ENCAMINHOU FICHA",
            "FINALIZOU FICHA"
        );
        if (in_array($action, $messenger)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @brief Obter a Ação do Log
     * 
     * @return String Ação do Log
     */
    public function get_log_acao()
    {
        return $this->log_acao;
    }

    /**
     * @brief Definir a Ação do Log
     * 
     * @param action Ação gerada
     */
    private function set_log_acao($action)
    {
        try {
            if ($this->check_action($action)) {
                $this->log_acao = $action;
            } else {
                throw new Exception("Erro ao inserir Ação em um Log");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o nome do Usuário que criou o Log
     * 
     * @return String Nome do Usuário que criou o Log 
     */
    public function get_log_usuario_nome()
    {
        return $this->log_usuario_nome;
    }

    /**
     * @brief Definir o nome do Usuário que criou o Log
     * 
     * @param name Nome do Usuário que criou o Log
     */
    private function set_log_usuario_nome($name)
    {
        $this->log_usuario_nome = $name;
    }

    /**
     * @brief Obter o nome do Setor do Usuário que criou o Log
     * 
     * @return String Nome do Setor do Usuário que criou o Log  
     */
    public function get_log_usuario_setor_nome()
    {
        return $this->log_usuario_setor_nome;
    }

    /**
     * @brief Definir o nome do Setor do Usuário que criou o Log 
     * 
     * @param name Nome do Setor do Usuário que criou o Log 
     */
    private function set_log_usuario_setor_nome($name)
    {
        $this->log_usuario_setor_nome = $name;
    }

    /**
     * @brief Obter a data de criação do Log
     * 
     * @return String Data de criação do Log
     */
    public function get_log_data_criacao()
    {
        return $this->log_data_criacao;
    }

    /**
     * @brief Definir a data de criação do Log
     * 
     * @param date Data de criação do Log
     */
    private function set_log_data_criacao($date)
    {
        $this->log_data_criacao = $date;
    }

    /**
     * @brief Obter o nome do Usuário ou do Setor que sofreu a Ação 
     * 
     * @return String Nome do Usuário ou do Setor que sofreu a Ação 
     */
    public function get_log_de_nome()
    {
        return $this->log_de_nome;
    }

    /**
     * @brief Definir o nome do Usuário ou do Setor que sofreu a Ação 
     * 
     * @param name Nome do Usuário ou do Setor que sofreu a Ação 
     */
    private function set_log_de_nome($name)
    {
        $this->log_de_nome = $name;
    }

    /**
     * @brief Obter o nome do Setor caso a Ação seja para um Usuário, se não retorna null
     * 
     * @return String Nome do Setor
     */
    public function get_log_de_setor_nome()
    {
        return $this->log_de_setor_nome;
    }

    /**
     * @brief Definir o nome do Setor caso a Ação seja para um Usuário, se não retorna null
     * 
     * @param name Nome do Setor
     */
    private function set_log_de_setor_nome($name)
    {
        $this->log_de_setor_nome = $name;
    }

    /**
     * @brief Obter o número da Ficha que sofreu a Ação 
     * 
     * @return String Número da Ficha que sofreu a Ação 
     */
    public function get_log_de_numero()
    {
        return $this->log_de_numero;
    }

    /**
     * @brief Definir o número da Ficha que sofreu a Ação
     * 
     * @param number Número da Ficha que sofreu a Ação
     */
    private function set_log_de_numero($number)
    {
        $this->log_de_numero = $number;
    }

    /**
     * @brief Obter o Telefone da Ficha que sofreu a Ação 
     * 
     * @return String Telefone da Ficha que sofreu a Ação 
     */
    public function get_log_de_telefone()
    {
        return $this->log_de_telefone;
    }

    /**
     * @brief Definir o Telefone da Ficha que sofreu a Ação 
     * 
     * @param phone Telefone da Ficha que sofreu a Ação 
     */
    private function set_log_de_telefone($phone)
    {
        $this->log_de_telefone = $phone;
    }

    /**
     * @brief Obter o Nome do Setor para onde foi encaminhado a Ficha
     * 
     * @return String Nome do Setor para onde foi encaminhado a Ficha 
     */
    public function get_log_para_nome()
    {
        return $this->log_para_nome;
    }

    /**
     * @brief Definir o Nome do Setor para onde foi encaminhado a Ficha
     * 
     * @param name Nome do Setor para onde foi encaminhado a Ficha 
     */
    private function set_log_para_nome($name)
    {
        $this->log_para_nome = $name;
    }

    /**
     * @brief Obter ip do Usuário
     * 
     * @return String ip do Usuário
     */
    public function get_log_ip()
    {
        return $this->log_ip;
    }

    /**
     * @brief Definir o ip do Usuário 
     * 
     * @param ip ip do Usuário  
     */
    private function set_log_ip($ip)
    {
        $this->log_ip = $ip;
    }
}