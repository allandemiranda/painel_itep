/**
 * @file Menu.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe com o Menu principal do sistema
 * @version 1.0.0
 * @date 06-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                        //! Componente fundamental
import NavbarHeader from './NavbarHeader.js'                    //! Logo da empresa
import SidebarMenu from './SidebarMenu.js'                      //! Opções do menu

class Menu extends Component {
    
    /**
     * @brief Renderiza o menu principal
     * 
     * @return {string} HTML do menu principal
     */
    render() {
        return (
            <div className="sidebar-left cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
                <nav className="navbar navbar-inverse">
                    <NavbarHeader></NavbarHeader>
                    <SidebarMenu></SidebarMenu>
                </nav>
            </div>
        )
    };
}

export default Menu;
