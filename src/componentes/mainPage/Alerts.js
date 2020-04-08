/**
 * @file Alerts.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe para criação de novos banners de alerta
 * @version 1.0.0
 * @date 11-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente básico
import { connect } from 'react-redux'       //! Componente Redux
import parse from 'html-react-parser'       //! Componente para texto em HTML


class Alerts extends Component {
    constructor() {
        super()
        this.successDiv = this.successDiv.bind(this)
        this.infoDiv = this.infoDiv.bind(this)
        this.warningDiv = this.warningDiv.bind(this)
        this.dangerDiv = this.dangerDiv.bind(this)
    }

    /**
     * @brief Obter banner de sucesso
     * 
     * @param {string} mensagem Mensagem do banner
     */
    successDiv(mensagem) {
        return (
            <div className="alert alert-success" role="alert">
                <strong>Sucesso!</strong> {parse(mensagem)} 
                <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" onClick={() =>
                        this.props.dispatch({
                            type: "REMOVER_ALERTA"
                        })
                    }>&times;</span>
                </button>
            </div>
        )
    }

    /**
     * @brief Obter banner de informações
     * 
     * @param {string} mensagem Mensagem do banner
     */
    infoDiv(mensagem) {
        return (
            <div className="alert alert-info" role="alert">
                <strong>Informação!</strong> {parse(mensagem)}
                <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" onClick={() =>
                        this.props.dispatch({
                            type: "REMOVER_ALERTA"
                        })
                    }>&times;</span>
                </button>
            </div>
        )
    }

    /**
     * @brief Obter banner de atenção
     * 
     * @param {string} mensagem Mensagem do banner
     */
    warningDiv(mensagem) {
        return (
            <div className="alert alert-warning" role="alert">
                <strong>Atenção!</strong> {parse(mensagem)}
                <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" onClick={() =>
                        this.props.dispatch({
                            type: "REMOVER_ALERTA"
                        })
                    }>&times;</span>
                </button>
            </div>
        )
    }

    /**
     * @brief Obter banner de erro fatal
     * 
     * @param {string} mensagem Mensagem do banner
     */
    dangerDiv(mensagem) {
        return (
            <div className="alert alert-danger" role="alert">
                <strong>Erro!</strong> {parse(mensagem)}
                <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" onClick={() =>
                        this.props.dispatch({
                            type: "REMOVER_ALERTA"
                        })
                    }>&times;</span>
                </button>
            </div>
        )
    }

    /**
     * @brief Renderiza banner de alerta
     * 
     * @return {string} HTML do banner de alerta solicitado
     */
    render() {
        switch (this.props.modules.alerta.tipo) {
            case "success":
                return (this.successDiv(this.props.modules.alerta.mensagem))
            case "info":
                return (this.infoDiv(this.props.modules.alerta.mensagem))
            case "warning":
                return (this.warningDiv(this.props.modules.alerta.mensagem))
            case "danger":
                return (this.dangerDiv(this.props.modules.alerta.mensagem))
            default:
                return (this.dangerDiv("Erro ao abrir o alerta."))
        }

    }
}

export default connect(state => ({ modules: state }))(Alerts)
