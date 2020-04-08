/**
 * @file StickyHeader.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe com o menu da barra de cabeçalho do sistema
 * @version 1.0.0
 * @date 10-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente básico
import { connect } from 'react-redux'       //! Componente Redux
import axios from 'axios'                   //! Componente Axios

class StickyHeader extends Component {
    constructor() {
        super()
        this.state = {
            nome: null,
            setor: null,
            activeProfile: false
        }
    }

    /**
     * @brief Carrega as informações do usuário para o cabeçalho da página
     * 
     */
    componentDidMount() {
        // Requisita a API as informações do usuário logado para o cabeçalho da página
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/header/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === 'INFORMAÇÕES PARA O CABEÇALHO') {
                    this.setState(prevState => ({
                        ...prevState,
                        nome: response.data.nome,
                        setor: response.data.setor
                    }))
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Recarregue a página! Não foi possivel carregar cabeçalho da págia."
                        }
                    })
                }
            })
    }

    /**
     * @brief Renderiza cabeçalho da página
     * 
     * @return {string} HTML do cabeçalho da página
     */
    render() {
        // Style fixo para separação da borda inferior
        const StyleFinal = {
            marginBottom: '5%'
        }

        return (
            <div className="sticky-header header-section ">
                <div className="header-right">
                    <div className="profile_details">
                        <ul>
                            <li className={this.state.activeProfile ? "dropdown profile_details_drop open" : "dropdown profile_details_drop"}>
                                <a href="#stih" className="dropdown-toggle" data-toggle="dropdown"
                                    onMouseEnter={() =>
                                        this.setState(prevState => ({
                                            ...prevState,
                                            activeProfile: true
                                        }))
                                    }
                                >
                                    <div className="profile_img">
                                        <div className="user-name">
                                            <p>{this.state.nome}</p>
                                            <span>{this.state.setor}</span>
                                        </div>
                                        <i className="fa fa-angle-down lnr"></i>
                                        <i className="fa fa-angle-up lnr"></i>
                                        <div className="clearfix"></div>
                                    </div>
                                </a>
                                <ul className="dropdown-menu drp-mnu"
                                    onMouseLeave={() =>
                                        this.setState(prevState => ({
                                            ...prevState,
                                            activeProfile: false
                                        }))
                                    }
                                >
                                    <li> <a href="#pref" style={{ cursor: "pointer" }} onClick={
                                        () =>
                                            this.props.dispatch({ type: "ABRIR_PERFIL" })
                                            &&
                                            this.setState(prevState => ({
                                                ...prevState,
                                                activeProfile: !this.state.activeProfile
                                            }))
                                    }><i className="fa fa-suitcase"></i> Perfil</a> </li>
                                    <li> <a href="#logf" style={{ cursor: "pointer" }} onClick={() => this.props.dispatch({ type: "LOGOUT" })}><i className="fa fa-sign-out"></i> Logout</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div className="clearfix" style={StyleFinal}></div>
                </div>
                <div className="clearfix"> </div>
            </div >
        )
    };
}

export default connect(state => ({ modules: state }))(StickyHeader)