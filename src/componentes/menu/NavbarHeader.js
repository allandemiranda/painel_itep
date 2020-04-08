/**
 * @file NavbarHeader.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe com a caixa da Logo da Empresa
 * @version 1.0.0
 * @date 06-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente fundamental
import { connect } from 'react-redux'       //! Componente Redux
import axios from 'axios'                   //! Componente Axios

class NavbarHeader extends Component {
    constructor() {
        super()
        this.state = {
            miniLogo: "",
            nomeEmpresa: ""
        }
    }

    /**
     * @brief Carrega os dados da empresa antes de montar o componente
     * 
     */
    componentDidMount() {
        // Requisita a API os dados da empresa
        axios.post(this.props.modules.apiPage.host + "/api/menu/header/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "DADOS DA EMPRESA OBTIDOS") {
                    this.setState(prevState => ({
                        ...prevState,
                        miniLogo: response.data.logo,
                        nomeEmpresa: response.data.nome
                    }))
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Recarregue a página."
                        }
                    })
                }
            })
    }

    /**
     * @brief Renderiza caixa superior do menu pricipal
     * 
     * @return {string} HTML da caixa superior do menu pricipal
     */
    render() {

        // Style fixo da imagem da logo
        const StyleLogoImagem = {
            width: '30%',
            float: 'left'
        }

        // Style fixo com o nome da empresa
        const StyleNomeEmpresa = {
            marginTop: '5%'
        }

        return (
            <div className="navbar-header">
                <img src={this.state.miniLogo} style={StyleLogoImagem} alt={"Logo"} />
                <h1 className="navbar-brand" style={StyleNomeEmpresa}> {this.state.nomeEmpresa}</h1>
            </div>
        )
    }
}

export default connect(state => ({ modules: state }))(NavbarHeader);
