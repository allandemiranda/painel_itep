/**
 * @file Login.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe do componente que efetua o login no sistema
 * @version 1.0.0
 * @date 17-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente básico
import { connect } from 'react-redux'       //! Componente Redux
import axios from 'axios'                   //! Componente Axios

class Login extends Component {
    constructor() {
        super()
        this.state = {
            formulario: {
                login: "",
                senha: ""
            },
            status: "AGUARDANDO LOGIN"
        }
        this.handleChange = this.handleChange.bind(this)
        this.handleSubmit = this.handleSubmit.bind(this)
    }

    /**
     * @brief Modifica status dos input's do formulário de login
     * 
     * @param {object} event Evento do onChanger
     */
    handleChange(event) {
        const { name, value } = event.target
        this.setState(prevState => ({
            ...prevState,
            formulario: {
                ...prevState.formulario,
                [name]: value
            }
        }))
    }

    /**
     * @brief Envia formulário para validação do login
     * 
     * @param {object} event Evento do formulário
     */
    handleSubmit(event) {

        // Modifica o estado dos componentes para visualização de página solicitando o login
        this.setState(prevState => ({
            ...prevState,
            status: "SOLICITANDO LOGIN"
        }))

        // Requisita a API o login
        axios.post(this.props.modules.apiPage.host + "/api/login/", {
            login: this.state.formulario.login, // Login informado no formulário de login
            senha: this.state.formulario.senha  // Senha informada no formulário de login
        }, { method: 'POST' })
            .then(response => {

                // Verifica se o login foi efetuado
                if (response.data.mensagem === 'LOGIN EFETUADO') {

                    // Modifica o estado dos componentes para um login aprovado
                    this.setState(prevState => ({
                        ...prevState,
                        status: "LOGIN FEITO COM SUCESSO"
                    }))

                    // Verifica o tipo de usuário para abrir corretamente o componente Dashboard
                    if (response.data.ficha) {
                        this.props.dispatch({
                            type: "ABRIR_PAINEL_FICHA"
                        })
                    } else {
                        this.props.dispatch({
                            type: "ABRIR_DASHBOARD"
                        })
                    }

                    // Salva no Local Storage as credenciais do usuário
                    this.props.dispatch({
                        type: "LOGIN_APROVADO",
                        formulario: {
                            login: response.data.login,
                            senha: response.data.senha
                        }
                    })
                } else {
                    // Modifica o estado dos componentes para um login ou senha errado
                    this.setState(prevState => ({
                        ...prevState,
                        status: "ERRO AO FAZER LOGIN"
                    }))
                }
            })

        event.preventDefault() //! Cancela o evento do formulário
    }

    /**
     * @brief Renderiza formulário de login da página de login
     * 
     * @return {string} HTML do formulário de login
     */
    render() {
        return (
            <div className="main-page login-page ">
                {this.state.status === "ERRO AO FAZER LOGIN" ?
                    <div className="alert alert-danger" role="alert">
                        <strong>Erro!</strong> Login ou senha incoreto.
                    </div> : null}
                {(this.state.status === "AGUARDANDO LOGIN" || this.state.status === "SOLICITANDO LOGIN") ?
                    <div className="alert alert-info" role="alert">
                        <strong>Atenção!</strong> Digite corretamente seu login e senha para acessar o chamador.
                    </div> : null}
                {this.state.status === "LOGIN FEITO COM SUCESSO" ?
                    <div className="alert alert-success" role="alert">
                        <strong>Muito bem!</strong> Você fez o login com sucesso.
                    </div> : null}
                <h2 className="title1">Login Chamador {this.props.modules.menu.nomeEmpresa}</h2>
                <div className="widget-shadow">
                    <div className="login-body">
                        <form onSubmit={this.handleSubmit}>
                            <div className="col-md-12 row">
                                <div className="input-group">
                                    {(this.state.status === "AGUARDANDO LOGIN" || this.state.status === "LOGIN FEITO COM SUCESSO") ?
                                        <span className="input-group-addon">
                                            <i className="fa fa-user"></i>
                                        </span> : null}
                                    {this.state.status === "SOLICITANDO LOGIN" ?
                                        <span className="input-group-addon">
                                            <i className="fa fa-fw fa-spin fa-spinner"></i>
                                        </span> : null}
                                    {this.state.status === "ERRO AO FAZER LOGIN" ?
                                        <span className="input-group-addon" style={{ backgroundColor: "rgb(242, 222, 222)" }}>
                                            <i className="fa fa-user" ></i>
                                        </span> : null}
                                    <input type="text" className="form-control1" name="login" placeholder="Login" required="" value={this.state.login} onChange={this.handleChange} />
                                </div>
                            </div>
                            <div className="col-md-12 row" >
                                <div className="input-group" >
                                    {(this.state.status === "AGUARDANDO LOGIN" || this.state.status === "LOGIN FEITO COM SUCESSO") ?
                                        <span className="input-group-addon">
                                            <i className="fa fa-key"></i>
                                        </span> : null}
                                    {this.state.status === "SOLICITANDO LOGIN" ?
                                        <span className="input-group-addon">
                                            <i className="fa fa-fw fa-spin fa-spinner"></i>
                                        </span> : null}
                                    {this.state.status === "ERRO AO FAZER LOGIN" ?
                                        <span className="input-group-addon" style={{ backgroundColor: "rgb(242, 222, 222)" }}>
                                            <i className="fa fa-key" ></i>
                                        </span> : null}
                                    <input type="password" name="senha" className="form-control1" placeholder="Senha" required="" value={this.state.senha} onChange={this.handleChange} />
                                </div>
                            </div>
                            <input type="submit" name="Entrar" value="Entrar" />
                        </form>
                    </div>
                </div>
            </div>
        )
    }
}

export default connect(state => ({ modules: state }))(Login)