/**
 * @file TreeviewDashboard.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com a abasde navegação Dashboard
 * @version 1.0.0
 * @date 12-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente fundamental
import { connect } from 'react-redux'       //! Componente Redux
import axios from 'axios'                   //! Componente Axios

class TreeviewDashboard extends Component {
    constructor() {
        super()
        this.state = {
            configuracoes: {
                active: false
            }
        }
    }

    /**
     * @brief Carrega a informação se é necessário abrir o painel de fichas antes do componente ser montado
     */
    componentDidMount() {
        axios.post(this.props.modules.apiPage.host + "/api/menu/dashboard/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
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
     * @brief Renderiza o botão Dashboard
     * 
     * @return {string} HTML do botão Dashboard
     */
    render() {
        return (
            <li className="treeview">
                <a href="#dash" style={{ cursor: "pointer" }} onClick={() => this.state.configuracoes.active ? this.props.dispatch({ type: "ABRIR_PAINEL_FICHA" }) : this.props.dispatch({ type: "ABRIR_DASHBOARD" })}>
                    <i className="fa fa-dashboard"></i>
                    <span> Dashboard</span>
                </a>
            </li>
        )
    }
}

export default connect(state => ({ modules: state }))(TreeviewDashboard)