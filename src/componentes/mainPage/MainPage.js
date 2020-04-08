/**
 * @file MainPage.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com área de trabalho do sistema
 * @version 1.0.0
 * @date 10-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                //! Componente básico
import { connect } from 'react-redux'                   //! Componente Redux
import axios from 'axios'                               //! Componente Axios
import Alerts from './Alerts.js'                        //! Componente com os banners de alerta
import Perfil from './header/perfil/Perfil.js'          //! Componente com o pefil do usuário logado
import Usuarios from './configuracoes/Usuarios.js'      //! Componente com a lista de usuários do sistema e suas possiveis edições
import Setores from './configuracoes/Setores.js'        //! Componente com a lista de setores
import Logs from './configuracoes/Logs.js'              //! Componente com a lista de logs do sistema
import PainelGeral from './painel/PainelGeral.js'       //! Painel para criar fichas
import WidgetStatus from './inicial/WidgetStatus.js'    //! Componente de status do chamador
import TabContent from './inicial/TabContent.js'        //! Componente com a tabela de status das pessoas em espera
import Fichas from './configuracoes/Fichas.js'          //! Componente com a lista de fichas

class MainPage extends Component {
    constructor() {
        super()
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Obtém a confirmação que o usuário ainda não foi deletado do sistema enquanto estava logado
     * 
     */
    tick() {
        // Requisita a API se a credencial é válida
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                if (response.data.mensagem !== 'USUÁRIO ATIVO') {
                    this.props.dispatch({
                        type: "LOGOUT"
                    })
                }
            })
    }

    componentDidUpdate() {
        this.tick()
    }

    /**
     * @brief Renderiza a main page do sistema
     * 
     * @return {string} HTML da main page do sistema
     */
    render() {
        return (
            <div id="page-wrapper">
                {this.props.modules.alerta.active ? <Alerts></Alerts> : null}
                {this.props.modules.perfil.active ? <Perfil></Perfil> : null}
                {this.props.modules.usuarios.active ? <Usuarios></Usuarios> : null}
                {this.props.modules.setores.active ? <Setores></Setores> : null}
                {this.props.modules.logs.active ? <Logs></Logs> : null}
                {this.props.modules.fichas.active ? <Fichas></Fichas> : null}
                {this.props.modules.painelFichas.active ? <PainelGeral></PainelGeral> : null}
                {this.props.modules.widgetStatus.active ? <WidgetStatus></WidgetStatus> : null}
                {this.props.modules.tabContent.active ? <TabContent></TabContent> : null}
            </div>
        )
    };
}

export default connect(state => ({ modules: state }))(MainPage)