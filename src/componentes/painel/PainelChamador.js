/**
 * @file PainelChamador.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe para o painel principal do chamador
 * @version 1.0.0
 * @date 14-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                        //! Componente básico
import { VoicePlayer } from 'react-voice-components'            //! Componente da reprodução de voz da ficha
import axios from 'axios'                                       //! Componente Axios
import { connect } from 'react-redux'                           //! Componente Redux

class PainelChamador extends Component {
    constructor() {
        super()
        this.state = {
            fichas: [
                { ficha_numero: 0, ficha_setor_nome: '' },
                { ficha_numero: 0, ficha_setor_nome: '' },
                { ficha_numero: 0, ficha_setor_nome: '' },
                { ficha_numero: 0, ficha_setor_nome: '' }
            ],
            alerta: false,
            voice: 'Ficha 0'
        }
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Verifica se existem fichas a ser chamada pelo chamado
     * 
     */
    tick() {
        // Desative o alerta para poder chamar outra ficha e o efeito sonoro funcionar corretamente
        setTimeout(() => {
            this.setState(prevState => ({
                ...prevState,
                alerta: false
            }))
        }, 4500);

        // Requisite a API se existe alguma ficha a ser chamada 
        axios.get(this.props.modules.apiPage.host + "/api/painel/")
            .then(response => {
                // Caso exista ficha a ser chamada
                if (response.data.ficha === 1) {
                    const fichas_old = this.state.fichas
                    fichas_old.unshift(response.data)
                    this.setState(prevState => ({
                        ...prevState,
                        fichas: fichas_old,
                        alerta: true,
                        voice: 'Ficha ' + fichas_old[0].ficha_numero
                    }))
                }
            })
    }

    /**
     * @brief Carrega a proxima ficha ser chamada, e atualiza a cada 5 segundo
     * 
     */
    componentDidMount() {
        this.tick()

        // Verifica a cada 5 segundos se tem alguma ficha a ser chamada
        this.intervalID = setInterval(
            () => this.tick(),
            5000
        )
    }

    /**
     * @breif Destroi o objeto da ação de verificação de uma nova ficha a ser chamada assim que o componente é fechado
     * 
     */
    componentWillUnmount() {
        clearInterval(this.intervalID);
    }

    /**
     * @brief Renderiza o painel do chamador
     * 
     * @return {string} HTML do painel do chamador
     */
    render() {

        // Style para quando a ficha for chamada
        const alerta_style = {
            paddingTop: "2%",
            backgroundColor: '#19d518'
        }

        // Style para quando a ficha não for chamada (momentos normais)
        const normal_style = {
            paddingTop: "2%"
        }

        return (
            <div className="col-lg-12" style={{ paddingTop: "3%" }}>
                <div className="form-group" style={{ padding: "3%" }}>
                    <div className="row">
                        <div className="col-md-12 text-center widget-shadow" style={this.state.alerta ? alerta_style : normal_style}>
                            <div className="col-lg-12 " style={{ padding: "3%", scale: "400%" }}>
                                <h1 style={{ fontWeight: "bold", fontSize: "1000%" }}>{this.state.fichas[0].ficha_numero}</h1>
                                {this.state.alerta ? <VoicePlayer
                                    play
                                    text={this.state.voice}
                                    lang='pt-BR'
                                    rate='0.9'
                                    pitch='0.8'
                                /> : null}
                            </div>
                            <div className="col-lg-12" style={{ padding: "3%", scale: "200%" }}>
                                <h1 style={{ fontWeight: "bold", fontSize: "700%" }}>{this.state.fichas[0].ficha_setor_nome}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="form-group" style={{ padding: "3%", marginBottom: '0px' }}>
                    <div className="row">
                        <div className="col-md-3 text-center widget-shadow" style={{ padding: "2%", marginRight: "7%" }}>
                            <div className="col-lg-12 ">
                                <h1 style={{ fontWeight: "bold", scale: "200%" }}>{this.state.fichas[1].ficha_numero}</h1>
                            </div>
                        </div>
                        <div className="col-md-3 text-center widget-shadow" style={{ padding: "2%", marginRight: "6%" }}>
                            <div className="col-lg-12 ">
                                <h1 style={{ fontWeight: "bold", scale: "200%" }}>{this.state.fichas[2].ficha_numero}</h1>
                            </div>
                        </div>
                        <div className="col-md-3 text-center widget-shadow" style={{ padding: "2%" }}>
                            <div className="col-lg-12 ">
                                <h1 style={{ fontWeight: "bold", scale: "200%" }}>{this.state.fichas[3].ficha_numero}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        )
    }
}

export default connect(state => ({ modules: state }))(PainelChamador)