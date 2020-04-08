<?php

/**
 * @file ClassFicha.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem os metodos para interação da Ficha do chamador com o sistema
 * @version 1.0.0
 * @date 27-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassFicha
{
    private $id;                    //! id da Ficha
    private $number;                //! Número da Ficha
    private $name;                  //! Nome da Ficha
    private $phone;                 //! Telefone da Ficha
    private $attendant_status;      //! Status da Ficha
    private $attendant_sector;      //! Setor a ser atendido
    private $attendant_user;        //! Funcionário responsável pelo atendimento
    private $priority;              //! Se a Ficha tem prioridade na chamada
    private $date;                  //! Data de criação da Ficha
    private $date_update;           //! Data da última atualização da Ficha

    /**
     * @brief Construtor do Objeto ClassFicha
     * 
     * @param id                    id da Ficha
     * @param number                Número da Ficha
     * @param name                  Nome da Ficha
     * @param phone                 Telefone da Ficha
     * @param attendant_status      Status da Ficha
     * @param attendant_sector      Setor a ser atendido
     * @param attendant_user        Funcionário responsável pelo atendimento
     * @param priority              Se a Ficha tem prioridade na chamada
     * @param date                  Data de criação da Ficha
     * @param date_update           Data da ultima atualização da Ficha
     */
    public function __construct($id = null, $name = null, $phone = null, $attendant_sector = null, $priority = null)
    {
        try {
            $db = new ClassConnection();
            if ($id == null) {
                if (($name == null) or ($phone == null) or ($attendant_sector == null) or ($priority == null)) {
                    throw new Exception("Erro ao criar um Objeto ClassFicha (parâmetros de entrada incorretos)");
                } else {
                    $number = $this->get_next_number($db);
                    $result = $db->request_query("INSERT INTO `fichas_tb`(`ficha_numero`, `ficha_nome`, `ficha_telefone`, `ficha_setor_id`, `ficha_prioridade`) VALUES (" . $number . ",'" . $name . "','" . $phone . "'," . $attendant_sector->get_id() . "," . $priority . ")");
                    if ($result == TRUE) {
                        $result = $db->request_query("SELECT * FROM `fichas_tb` WHERE `ficha_id`=" . $db->last_insert_id());
                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                            if ($row['ficha_nome'] == $name) {
                                $this->id = $row['ficha_id'];
                                $this->number = $row['ficha_numero'];
                                $this->name = $row['ficha_nome'];
                                $this->phone = $row['ficha_telefone'];
                                $this->attendant_status = $row['ficha_status'];
                                $this->attendant_sector = $attendant_sector;
                                $this->attendant_user = null;
                                $this->priority = $row['ficha_prioridade'];
                                $this->date = $row['ficha_criacao_data'];
                                $this->date_update = $row['ficha_atualizacao_data'];
                            } else {
                                throw new Exception("Erro ao criar um Objeto ClassFicha (nome inválido)");
                            }
                        } else {
                            throw new Exception("Erro ao criar um Objeto ClassFicha (id inválido)");
                        }
                    } else {
                        throw new Exception("Erro ao criar um Objeto ClassFicha (erro no banco de dados)");
                    }
                }
            } else {
                $result = $db->request_query("SELECT * FROM `fichas_tb` WHERE `ficha_id`=" . $id);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $this->id = $row['ficha_id'];
                    $this->number = $row['ficha_numero'];
                    $this->name = $row['ficha_nome'];
                    $this->phone = $row['ficha_telefone'];
                    $this->attendant_status = $row['ficha_status'];
                    $this->attendant_sector = new ClassSetor($row['ficha_setor_id']);
                    if ($this->attendant_status == "NÃO ATENDIDO") {
                        $this->attendant_user = null;
                    } else {
                        $this->attendant_user = new ClassUsuario($row['ficha_usuario_id']);
                    }
                    $this->priority = $row['ficha_prioridade'];
                    $this->date = $row['ficha_criacao_data'];
                    $this->date_update = $row['ficha_atualizacao_data'];
                } else {
                    throw new Exception("Erro ao criar um Objeto ClassFicha (id inválido)");
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Destrutor do Objeto ClassFicha
     * 
     */
    public function __destruct()
    {
        $this->id = null;
        $this->number = null;
        $this->name = null;
        $this->phone = null;
        $this->attendant_status = null;
        $this->attendant_sector = null;
        $this->attendant_user = null;
        $this->priority = null;
        $this->date = null;
        $this->date_update = null;
    }

    /**
     * @brief Obter próximo número da Ficha do chamador
     * 
     * @param conn Conexão com o Banco de Dados já aberta
     */
    private function get_next_number($conn)
    {
        try {
            $result = $conn->request_query("SELECT `ficha_numero`, `ficha_criacao_data` FROM `fichas_tb` ORDER BY `ficha_id` DESC LIMIT 1");
            switch (mysqli_num_rows($result)) {
                case 1:
                    $row = mysqli_fetch_assoc($result);
                    $last_date = $row['ficha_criacao_data'];
                    $array_last_date = explode(" ", $last_date);
                    $array_last_day = explode("-", $array_last_date[0]);
                    $last_day = $array_last_day[2];
                    $today_day = date('d');
                    if ($last_day != $today_day) {
                        return 1;
                    } else {
                        $last_number = $row['ficha_numero'];
                        $next_number = $last_number + 1;
                        return $next_number;
                    }
                    break;

                case 0:
                    return 1;
                    break;

                default:
                    throw new Exception("Erro ao gerar próximo número na Ficha");
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o id da Ficha
     * 
     * @return Int id da Ficha
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @brief Obter o Número da Ficha
     * 
     * @return Int Número da Ficha
     */
    public function get_number()
    {
        return $this->number;
    }

    /**
     * @brief Definir o Número da Ficha
     * 
     * @param value Número da Ficha
     */
    public function set_number(int $value)
    {
        try {
            $this->number = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_numero`='" . $this->get_number() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Número da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o Nome da Ficha
     * 
     * @return String Nome da Ficha
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @brief Definir o Nome da Ficha
     * 
     * @param value Nome da Ficha
     */
    public function set_name($value)
    {
        try {
            $this->name = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_nome`='" . $this->get_name() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Nome da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o número do Telefone da Ficha
     * 
     * @return String Número do Telefone da Ficha
     */
    public function get_phone()
    {
        return $this->phone;
    }

    /**
     * @brief Definir o Número do Telefone da Ficha
     * 
     * @param value Número do Telefone da Ficha
     */
    public function set_phone($value)
    {
        try {
            $this->phone = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_telefone`='" . $this->get_phone() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Telefone da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o Status da Ficha
     * 
     * @return String Status da Ficha
     */
    public function get_attendant_status()
    {
        return $this->attendant_status;
    }

    /**
     * @brief Definir o Status da Ficha
     * 
     * @param value Status da Ficha [NÃO ATENDIDO, EM ATENDIMENTO, ENCAMINHADO, FINALIZADO, CHAMAR]
     */
    public function set_attendant_status($value)
    {
        try {
            $this->attendant_status = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_status`='" . $this->get_attendant_status() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Status da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o Setor de atendimento da Ficha
     * 
     * @return ClassSetor Setor de atendimento da Ficha
     */
    public function get_attendant_sector()
    {
        return $this->attendant_sector;
    }

    /**
     * @brief Definir o Setor de atendimento da Ficha
     * 
     * @param ClassSetor Setor de atendimento da Ficha
     */
    public function set_attendant_sector($value)
    {
        try {
            //$this->get_attendant_sector()->__destruct();
            $this->attendant_sector = null;
            $this->attendant_sector = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_setor_id`='" . $this->get_attendant_sector()->get_id() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar o Setor de atendimento da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter o Funcionário de Atendimento da Ficha
     * 
     * @return ClassUsuario Funcionário de Atendimento da Ficha
     */
    public function get_attendant_user()
    {
        return $this->attendant_user;
    }

    /**
     * @brief Definir o Funcionário de Atendimento da Ficha
     * 
     * @param ClassUsuario Funcionário de Atendimento da Ficha
     */
    public function set_attendant_user($value)
    {
        try {
            //$this->get_attendant_user()->__destruct();
            $this->attendant_user = null;
            $this->attendant_user = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_usuario_id`='" . $this->get_attendant_user()->get_id() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar Funcionário que está atendendo da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a Prioridade da Ficha
     * 
     * @return Bool Se a Ficha é do tipo prioritária
     */
    public function get_priority()
    {
        return $this->priority;
    }

    /**
     * @brief Definir a Prioridade da Ficha
     * 
     * @param value Se a Ficha é do tipo prioritária
     */
    public function set_priority(bool $value)
    {
        try {
            //$this->get_attendant_user()->__destruct();
            $this->attendant_user = null;
            $this->attendant_user = $value;
            $db = new ClassConnection();
            $result = $db->request_query("UPDATE `fichas_tb` SET `ficha_prioridade`='" . $this->get_priority() . "' WHERE `ficha_id`=" . $this->get_id());
            if ($result != TRUE) {
                throw new Exception("Erro ao atualizar prioridade da Ficha " . $this->get_number());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @brief Obter a Data de criação da Ficha em TIMESTAMP
     * 
     * @return Timestamp Data de criação da Ficha em TIMESTAMP
     */
    public function get_date()
    {
        return $this->date;
    }

    /**
     * @brief Obter a data da última atualização da Ficha
     * 
     * @return Timestamp Data da última atualização da Ficha em TIMESTAMP
     */
    public function get_date_update()
    {
        return $this->date_update;
    }
}
