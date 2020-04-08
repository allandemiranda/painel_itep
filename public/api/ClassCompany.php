<?php

/**
 * @file ClassCompany.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com as informações da Empresa
 * @version 1.0.0
 * @date 27-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

class ClassCompany
{
    private $name;          //! Nome da empresa
    private $company_logo;  //! Logo da Empresa
    private $footer_print;  //! Rodapé de impressão 

    /**
     * @brief Construtor da class atribuindo os valores
     * 
     */
    public function __construct()
    {
        $this->set_name("ITEP RN");
        $this->set_company_logo('/api/imagens/itep-logo-mini.png');
        $this->set_footer_print("&copy; 2020 All Rights Reserved DIGETI | ITEP/RN | http://www.itep.rn.gov.br/ Tel.(84)3232.6916");
    }

    /**
     * @brief Destrutor da class atribuindo os valores
     * 
     */
    public function __destruct()
    {
        $this->name = null;
        $this->company_logo = null;
    }

    /**
     * @brief Obter nome da Empresa
     * 
     * @return String Nomde da Empresa
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @brief Definir nome da Empresa
     * 
     * @param value Novo Nome da Empresa
     */
    private function set_name($value)
    {
        $this->name = $value;
    }

    /**
     * @brief Obter Logo da Empresa
     * 
     * @return Object Logo da Empresa
     */
    public function get_company_logo()
    {
        return $this->company_logo;
    }

    /**
     * @brief Definir Logo da Empresa
     * 
     * @param value Objeto com a logo da empresa
     */
    private function set_company_logo($value)
    {
        $this->company_logo = $value;
    }

    /**
     * @brief Obter texto de rodapé da impressão
     * 
     * @return Object Texto de rodapé da impressão
     */
    public function get_footer_print()
    {
        return $this->footer_print;
    }

    /**
     * @brief Definir texto de rodapé da impressão
     * 
     * @param value Objeto com o texto de rodapé da impressão
     */
    public function set_footer_print($value)
    {
        $this->footer_print = $value;
    }
}
