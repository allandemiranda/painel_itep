/**
 * @file Perfil.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe das informações do usuário
 * @version 1.0.0
 * @date 13-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente básico
import { connect } from 'react-redux'       //! Componente Redux
import axios from 'axios'                   //! Componente Axios

class NovoUsuario extends Component {
    constructor() {
        super()
        this.state = {
            nome: '',
            setor: '',
            setorId: '',
            login: '',
            formulario: {
                senha: ''
            }
        }
        this.handleChange = this.handleChange.bind(this)
        this.handleSubmit = this.handleSubmit.bind(this)
    }

    /**
     * @breif Carrega as informações do usuário antes de montar o componente
     */
    componentDidMount() {
        // Requisita a API as informações do usuário
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/perfil/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "INFORMAÇÕES DO FUNCIONÁRIO DISPONIBILIZADAS") {
                    this.setState(prevState => ({
                        ...prevState,
                        nome: response.data.usuario_nome,
                        setor: response.data.setor_nome,
                        setorId: response.data.setor_id,
                        login: response.data.usuario_login
                    }))
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Recarregue a página! Não foi possivel carregar as informações do Perfil."
                        }
                    })
                }
            })
    }

    /**
     * @brief Obter modificações de valores de inputs do formulário
     * 
     * @param {Object} event Evento do formulário
     */
    handleChange(event) {
        const { name, value } = event.target
        this.setState(prevState => ({
            formulario: {
                ...prevState.formulario,
                [name]: value
            }
        }))
    }

    /**
     * @brief Submeter formulário do perfil do funcionário logado
     * 
     * @param {Object} event Evento do formulário
     */
    handleSubmit(event) {
        // Verifica se a senha tem mais que 5 caracteres
        if (this.state.formulario.senha.length >= 5) {
            axios.post(this.props.modules.apiPage.host + "/api/mainPage/perfil/formulario.php",
                {
                    login: this.props.modules.perfil.login, // Credencial de login do usuário
                    senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                    novaSenha: this.state.formulario.senha  // Nova senha para o usuário
                }, { method: 'POST' })
                .then(response => {
                    if (response.data.mensagem === "SENHA DO FUNCIONÁRIO ATUALIZADA") {
                        this.setState(prevState => ({
                            ...prevState,
                            senha: response.data.senha
                        }))
                        this.props.dispatch({
                            type: "MODIFICAR_PERFIL",
                            formulario: {
                                senha: response.data.senha
                            }
                        })
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'success',
                                mensagem: "Usuário modificou a senha"
                            }
                        })
                    } else {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'danger',
                                mensagem: "Não foi possível atualizar perfil."
                            }
                        })
                    }
                })
        } else {
            this.props.dispatch({
                type: "ADICIONAR_ALERTA",
                alerta: {
                    tipo: 'danger',
                    mensagem: "Digite uma senha com 5 ou mais caracteres."
                }
            })
        }
        event.preventDefault(); //! Cancela o submição do evendo do formulário
    }

    /**
     * @brief Renderiza formulário das informações do usuário logado
     * 
     * @return {string} HTML do formulário das informações do usuário logado
     */
    render() {
        return (
            <div className="forms">
                <div className="form-grids row widget-shadow">
                    <div className="form-title">
                        <h4>Perfil Usuário </h4>
                    </div>
                    <div className="form-body">
                        <form onSubmit={this.handleSubmit}>
                            <div className="col-md-12 form-group">
                                <label>Nome</label>
                                <input type="text" className="col-md-12 form-control" value={this.state.nome} required disabled />
                            </div>
                            <div className="col-md-12 form-group">
                                <label>Setor</label>
                                <select name="setor" className="col-md-12 form-control" type="text" disabled>
                                    <option key={this.state.setorId} value={this.state.setor}>{this.state.setor}</option>
                                </select>
                            </div>
                            <div className="col-md-2 form-group">
                                <label>Login</label>
                                <input name="login" type="text" className="form-control" placeholder="Login" value={this.state.login} required disabled />
                            </div>
                            <div className="col-md-2 form-group" style={{ paddingLeft: "10%" }}>
                                <label>Senha</label>
                                <input name="senha" type="password" minLength="5" className="form-control" placeholder="Senha" value={this.state.formulario.senha} onChange={this.handleChange} />
                            </div>
                            <div className="col-md-12">
                                <button type="submit" className="btn btn-success" value="salvar">Modificar</button>
                                <br /><br />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        )
    }
}

export default connect(state => ({ modules: state }))(NovoUsuario)