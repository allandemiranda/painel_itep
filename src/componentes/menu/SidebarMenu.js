/**
 * @file SidebarMenu.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com as abas de navegação do menu
 * @version 1.0.0
 * @date 06-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                                //! Componente fundamental
import SidebarMenuHeader from './SidebarMenuHeader.js'                  //! Componente das abas de menu
import TreeviewMenuConfiguracao from './TreeviewMenuConfiguracao.js'    //! Abas do menu para área de configuração (super usuário)
import TreeviewDashboard from './TreeviewDashboard.js'                  //! Aba Dashboard
import { connect } from 'react-redux'                                   //! Componente Redux
import axios from 'axios'                                               //! Componente Axios

class SidebarMenu extends Component {
    constructor() {
        super()
        this.state = {
            configuracoes: {
                active: false
            }
        }
    }

    /**
     * @brief Carrega o esqueleto de abas do menu principal
     * 
     */
    componentDidMount() {
        // Requisita a API a informação sobre a disponibilidade do menu de contigurações
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuári
            }, { method: 'POST' })
            .then(response => {
                if (response.data.configuracao) {
                    this.setState(prevState => ({
                        ...prevState,
                        configuracoes: {
                            ...prevState.configuracoes,
                            active: true
                        }
                    }))
                }
            })
    }

    /**
     * @brief Renderiza abas do menu principal
     * 
     * @return {string} HTML das abas do menu principal
     */
    render() {
        return (
            <div className="sidebar-menu">
                <SidebarMenuHeader nome="NAVEGAÇÃO"></SidebarMenuHeader>
                <TreeviewDashboard></TreeviewDashboard>
                {this.state.configuracoes.active ?
                    <TreeviewMenuConfiguracao></TreeviewMenuConfiguracao> : null
                }
            </div>
        )
    }
}

export default connect(state => ({ modules: state }))(SidebarMenu)
