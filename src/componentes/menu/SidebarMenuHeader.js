/**
 * @file SidebarMenuHeader.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe o divisor cabeçalho de um grupo de abas de navegação
 * @version 1.0.0
 * @date 07-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente fundamental

class SidebarMenuHeader extends Component {
    /**
     * @brief Renderiza um divisor do menu
     * 
     * @return {string} HTML do divisor do menu
     */
    render() {
        return (
            <li className="header">{this.props.nome}</li>
        )
    };
}

export default SidebarMenuHeader;
