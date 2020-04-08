/**
 * @file TreeviewMenuConfiguracao.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com as abas de navegação da opção configuração
 * @version 1.0.0
 * @date 11-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente básico
import { connect } from 'react-redux'       //! Componente Redux

class TreeviewMenuConfiguracao extends Component {
    constructor() {
        super()
        this.state = {
            activeAbaConfiguracoes: false
        }
    }

    /**
     * @brief Renderiza abas de configuração do menu
     * 
     * @return {string} HTML das abas de configuração do menu
     */
    render() {
        return (
            <li className={this.state.activeAbaConfiguracoes ? 'active' : null}>
                <a href="#conf" onClick={() => this.setState({ activeAbaConfiguracoes: !this.state.activeAbaConfiguracoes })}>
                    <i className="fa fa-gears"></i>
                    <span> Configurações</span>
                    <i className="fa fa-angle-left pull-right"></i>
                </a>
                <ul className="treeview-menu">
                    <li><a href="#user" style={{ cursor: "pointer" }} onClick={() => this.props.dispatch({ type: "ABRIR_USUARIOS" })}><i className="fa fa-angle-right"></i> Usuários</a></li>
                    <li><a href="#sect" style={{ cursor: "pointer" }} onClick={() => this.props.dispatch({ type: "ABRIR_SETORES" })}><i className="fa fa-angle-right"></i> Setores</a></li>
                    <li><a href="#fics" style={{ cursor: "pointer" }} onClick={() => this.props.dispatch({ type: "ABRIR_FICHAS" })}><i className="fa fa-angle-right"></i> Fichas</a></li>
                    <li><a href="#logs" style={{ cursor: "pointer" }} onClick={() => this.props.dispatch({ type: "ABRIR_LOGS" })}><i className="fa fa-angle-right"></i> Logs</a></li>
                </ul>
            </li>
        )
    };
}

export default connect()(TreeviewMenuConfiguracao)
