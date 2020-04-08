/**
 * @file WidgetStatus.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe com os widget do status do chamador
 * @version 1.0.0
 * @date 10-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'    //! Componente básico
import { connect } from 'react-redux'       //! Componente Redux
import axios from 'axios'                   //! Componente Axios

class WidgetStatus extends Component {
    constructor() {
        super()
        this.state = {
            naoAtendidos: 0,
            encaminhado: 0,
            emAtendimento: 0,
            finalizado: 0
        }
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Recupera números para os indicadores do componente
     * 
     */
    tick() {
        // Requisuta a API a quantidade de fichas para cada indicador
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                this.setState(prevState => ({
                    ...prevState,
                    naoAtendidos: response.data.naoAtendidos,
                    encaminhado: response.data.encaminhado,
                    emAtendimento: response.data.emAtendimento,
                    finalizado: response.data.finalizado
                }))
            })
    }

    /**
     * @brief Carrega os números dos indicadores antes do componente ser carregado
     * 
     */
    componentDidMount() {
        this.tick()

        // Atualiza os dados do componente a cada 5 segundos
        this.intervalID = setInterval(
            () => {
                this.tick()
            },
            5000
        )
    }

    /**
     * @breif Destroi o objeto que atualiza os indicadores assim que o componente é fechado
     * 
     */
    componentWillUnmount() {
        clearInterval(this.intervalID);
    }

    /**
     * @brief Renderiza os indicadores do chamador
     * 
     * @return {string} HTML dos indicadores do chamador
     */
    render() {
        return (
            <div className="col_3">
                <div className="col-md-3 widget-shadow">
                    <div className="r3_counter_box">
                        <i className="pull-left fa fa-exclamation-triangle user1 icon-rounded"></i>
                        <div className="stats">
                            <h5><strong>{this.state.naoAtendidos}</strong></h5>
                            <span>Não Atendidos</span>
                        </div>
                    </div>
                </div>
                <div className="col-md-3 widget-shadow">
                    <div className="r3_counter_box">
                        <i className="pull-left fa fa-flag dollar1 icon-rounded"></i>
                        <div className="stats">
                            <h5><strong>{this.state.encaminhado}</strong></h5>
                            <span>Encaminhados</span>
                        </div>
                    </div>
                </div>
                <div className="col-md-3 widget-shadow">
                    <div className="r3_counter_box">
                        <i className="pull-left fa fa-pencil-square-o dollar2 icon-rounded"></i>

                        <div className="stats">
                            <h5><strong>{this.state.emAtendimento}</strong></h5>
                            <span>Em Atendimento</span>
                        </div>
                    </div>
                </div>
                <div className="col-md-3 widget-shadow">
                    <div className="r3_counter_box">
                        <i className="pull-left fa fa-check-square-o user2 icon-rounded"></i>
                        <div className="stats">
                            <h5><strong>{this.state.finalizado}</strong></h5>
                            <span>Atendidos</span>
                        </div>
                    </div>
                </div>
                <div className="clearfix"> </div>
            </div>
        )
    };
}

export default connect(state => ({ modules: state }))(WidgetStatus)