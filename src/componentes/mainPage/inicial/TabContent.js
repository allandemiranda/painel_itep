/**
 * @file TabContent.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe da tabela de atendimento ao setor
 * @version 1.0.0
 * @date 11-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                        //! Componente básico
import { connect } from 'react-redux'                           //! Componente Redux
import axios from 'axios'                                       //! Componente Axios
import MaterialTable from 'material-table'                      //! Componente da tabela
import { forwardRef } from 'react'                              //! Componente da tabela
import ArrowDownward from '@material-ui/icons/ArrowDownward'    //! Componente da tabela
import Check from '@material-ui/icons/Check'                    //! Componente da tabela
import ChevronLeft from '@material-ui/icons/ChevronLeft'        //! Componente da tabela
import ChevronRight from '@material-ui/icons/ChevronRight'      //! Componente da tabela
import Clear from '@material-ui/icons/Clear'                    //! Componente da tabela
import Edit from '@material-ui/icons/Edit'                      //! Componente da tabela
import FilterList from '@material-ui/icons/FilterList'          //! Componente da tabela
import FirstPage from '@material-ui/icons/FirstPage'            //! Componente da tabela
import LastPage from '@material-ui/icons/LastPage'              //! Componente da tabela
import Remove from '@material-ui/icons/Remove'                  //! Componente da tabela
import Search from '@material-ui/icons/Search'                  //! Componente da tabela
import ViewColumn from '@material-ui/icons/ViewColumn'          //! Componente da tabela
import RecordVoiceOverIcon from '@material-ui/icons/RecordVoiceOver' //! Componente da tabela
import DoneIcon from '@material-ui/icons/Done'                  //! Componente da tabela

class TabContent extends Component {
    constructor() {
        super()
        this.state = {
            abaActive: "naoAtendidos",
            options: {
                pageSize: 5,
                pageSizeOptions: [5, 8, 10],
                sorting: true,
                actionsColumnIndex: -1,
                // cellStyle: {
                //     textAlign: "center"
                // },
                // rowStyle: {
                //     textAlign: "center"
                // },
                // headerStyle: {
                //     textAlign: "center"
                // }
            },
            components: {
                Toolbar: () => (
                    <div></div>
                )
            },
            localization: {
                body: {
                    emptyDataSourceMessage: 'Nenhuma ficha disponível',
                    addTooltip: 'Criar',
                    deleteTooltip: 'Deletar',
                    editTooltip: 'Editar',
                    filterRow: {
                        filterTooltip: 'Filtrar'
                    },
                    editRow: {
                        deleteText: 'Tem certeza de que deseja excluir esta ficha?',
                        cancelTooltip: 'Cancelar',
                        saveTooltip: 'Salvar'
                    }
                },
                header: {
                    actions: 'Ações'
                },
                pagination: {
                    labelDisplayedRows: '{from}-{to} de {count}',
                    labelRowsSelect: 'linhas',
                    firstTooltip: 'Primeira página',
                    previousTooltip: 'Página anterior',
                    nextTooltip: 'Próxima página',
                    lastTooltip: 'Última página'
                },
                toolbar: {
                    addRemoveColumns: 'Adicionar ou remover colunas',
                    searchTooltip: 'Procurar',
                    searchPlaceholder: 'Procurar'

                }
            },
            naoAtendido_columns: [
                {
                    title: 'Número',
                    field: 'ficha_numero',
                    editable: 'never'
                },
                {
                    title: 'Nome',
                    field: 'ficha_nome',
                    editable: 'never'
                },
                {
                    title: 'Telefone',
                    field: 'ficha_telefone',
                    editable: 'never'
                },
                {
                    title: 'Prioridade',
                    field: 'ficha_prioridade',
                    lookup: {
                        0: "NÃO",
                        1: "SIM"
                    },
                    editable: 'never'
                },
                {
                    title: 'Hora',
                    field: 'ficha_hora',
                    editable: 'never'
                }
            ],
            atendidos_columns: [
                {
                    title: 'Número',
                    field: 'ficha_numero'
                },
                {
                    title: 'Nome',
                    field: 'ficha_nome'
                },
                {
                    title: 'Telefone',
                    field: 'ficha_telefone'
                },
                {
                    title: 'Prioridade',
                    field: 'ficha_prioridade',
                    lookup: {
                        0: "NÃO",
                        1: "SIM"
                    }
                },
                {
                    title: 'Atendente',
                    field: 'ficha_atendente_nome'
                },
                {
                    title: 'Hora Chegada',
                    field: 'ficha_criacao_data'
                },
                {
                    title: 'Hora Finalizado',
                    field: 'ficha_atualizacao_data'
                }
            ]
        }
        this.naoAtendido_tick = this.naoAtendido_tick.bind(this)
        this.naoAtendido_after_tick = this.naoAtendido_after_tick.bind(this)
        this.proximaFicha = this.proximaFicha.bind(this)
        this.emAtendimento_tick = this.emAtendimento_tick.bind(this)
        this.fichaIndividual = this.fichaIndividual.bind(this)
        this.atendidos_tick = this.atendidos_tick.bind(this)
        this.encaminhar_ficha = this.encaminhar_ficha.bind(this)
        this.finalizarFicha = this.finalizarFicha.bind(this)
    }

    /**
     * @brief Chama ficha individual da lista de fichas não atendidas
     * 
     * @param {Number} id id da ficha a ser chamada individualemnte
     * @param {Object} event Evento do botão
     */
    fichaIndividual(id, event) {
        // Requisita a API a operação de chamar uma ficha específica
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/naoAtendidosProximoIndividual.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                ficha_id: id                            // id da ficha a ser chamada
            }, { method: 'POST' })
            .then(response => {
                this.naoAtendido_tick()
                this.emAtendimento_tick()
                // Verifica se a operação foi sucesso
                if (response.data.tipo === 'success') {
                    this.setState(prevState => ({
                        ...prevState,
                        abaActive: "emAtendimento"
                    }))
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: response.data.tipo,
                            mensagem: response.data.mensagem
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel chamar a ficha."
                        }
                    })
                }
            })
        event.preventDefault(); //! Cancela o submição do evendo do botão
    }

    /**
     * @breif Chama a próxima ficha da lista de fichas não atendidas de forma automática
     * 
     * @param event Evento criado pelo botão
     */
    proximaFicha(event) {
        // Requisita a API a operação de chamar a próxima ficha da fila de fichas em espera pelo setor
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/naoAtendidosProximo.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                this.naoAtendido_tick()
                this.emAtendimento_tick()
                // Verifica se a operação foi sucesso
                if (response.data[0].tipo === 'success') {
                    this.setState(prevState => ({
                        ...prevState,
                        abaActive: "emAtendimento"
                    }))
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: response.data[0].tipo,
                            mensagem: response.data[0].mensagem
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: response.data[0].tipo,
                            mensagem: response.data[0].mensagem
                        }
                    })
                }
            })
        event.preventDefault(); //! Cancela o submição do evendo do botão
    }

    /**
     * @brief Encaminha a ficha para outro setor
     * 
     * @param {Number} id id da ficha a ser encaminahda 
     * @param {Number} setor id do setor para onde a ficha vai ser encaminhada
     */
    encaminhar_ficha(id, setor) {
        // Requisita a API que encaminhe uma determinada ficha
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/encaminhar.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                ficha_id: id,                           // id da ficha que será encaminhada
                setor_id: setor                         // id do setor para onde a ficha será encaminhada
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.tipo === 'success') {
                    this.setState(prevState => ({
                        ...prevState,
                        abaActive: "naoAtendidos"
                    }))
                    this.emAtendimento_tick()
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: response.data.tipo,
                            mensagem: response.data.mensagem
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel encaminhar a ficha."
                        }
                    })
                }

            })
    }

    /**
     * @brief Finaliza ficha em atendimento peo usuário
     * 
     * @param {Number} id id da ficha a ser finalizada 
     * @param event Evento criado pelo botão
     */
    finalizarFicha(id, event) {
        // Requisita a API que finalize uma determinada ficha
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/finalizar.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                ficha_id: id                            // id da ficha que será finalizada
            }, { method: 'POST' })
            .then(response => {
                this.emAtendimento_tick()
                // Verifica se a operação foi sucesso
                if (response.data.tipo === 'success') {
                    this.setState(prevState => ({
                        ...prevState,
                        abaActive: "naoAtendidos"
                    }))
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: response.data.tipo,
                            mensagem: response.data.mensagem
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel finalizar a ficha."
                        }
                    })
                }
            })
        event.preventDefault(); //! Cancela o submição do evendo do botão
    }

    /**
     * @brief Gera lista de fichas não atendidas pelo setor do usuário
     * 
     */
    naoAtendido_tick() {
        // Requisita a API a lista de fichas em espera para o setor
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/naoAtendidos.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                this.setState(prevState => ({
                    ...prevState,
                    naoAtendido_data: response.data
                }))
            })
    }

    /**
     * @brief Gera lista de fichas não atendidas pelo setor do usuário
     * 
     */
    naoAtendido_after_tick() {
        // Requisita a API a lista de fichas em espera para o setor
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/naoAtendidos.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Se lista do banco de dados tem fichas
                if (response.data.length > 0) {
                    // Se já existem fichas no front
                    if (this.state.naoAtendido_data.length > 0) {
                        const event_state = new Date(this.state.naoAtendido_data[this.state.naoAtendido_data.length - 1].ficha_atualizacao_data)
                        const event_response = new Date(response.data[response.data.length - 1].ficha_atualizacao_data)
                        // Certifica se a ultima atualização é mais nova que as que existem no front
                        if (event_state < event_response) {
                            this.setState(prevState => ({
                                ...prevState,
                                naoAtendido_data: response.data
                            }))
                            new Notification("ITEP RN: Nova ficha disponível")
                        }
                    } else {
                        this.setState(prevState => ({
                            ...prevState,
                            naoAtendido_data: response.data
                        }))
                        new Notification("ITEP RN: Nova ficha disponível")
                    }
                } else {
                    this.setState(prevState => ({
                        ...prevState,
                        naoAtendido_data: []
                    }))
                }
            })
    }

    /**
     * @brief Gera lista de fichas em atendimento pelo usuário
     * 
     */
    emAtendimento_tick() {
        // Requisita a API a lista de fichas que estão em atendimento pelo usuário
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/emAtendimento.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                this.setState(prevState => ({
                    ...prevState,
                    emAtendimento_data: response.data[1],
                    emAtendimento_columns: [
                        {
                            title: 'Número',
                            field: 'ficha_numero',
                            editable: 'never'
                        },
                        {
                            title: 'Nome',
                            field: 'ficha_nome',
                            editable: 'never'
                        },
                        {
                            title: 'Telefone',
                            field: 'ficha_telefone',
                            editable: 'never'
                        },
                        {
                            title: 'Hora',
                            field: 'ficha_hora',
                            editable: 'never'
                        },
                        {
                            title: 'Encaminhar para',
                            field: 'ficha_encaminhar_setor',
                            lookup: response.data[0]
                        }
                    ]
                }))
            })
    }

    /**
     * @brief Gera lista de fichas atendidas pelo setor do usuário
     * 
     */
    atendidos_tick() {
        // Requisita a API a lista de fichas atendidas pelo setor
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/inicial/atendidos.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                this.setState(prevState => ({
                    ...prevState,
                    atendidos_data: response.data
                }))
            })
    }

    /**
     * @brief Carrega as listas de fichas antes do componente ser carregado
     * 
     */
    componentDidMount() {
        this.naoAtendido_tick()
        this.emAtendimento_tick()
        this.atendidos_tick()
        this.intervalID = setInterval(
            () => {
                this.naoAtendido_after_tick()
                this.atendidos_tick()
            },
            3000
        )
    }

    /**
     * @breif Destroi o objeto que atualiza as listas assim que o componente é fechado
     * 
     */
    componentWillUnmount() {
        clearInterval(this.intervalID);
    }

    /**
     * @brief Renderiza as listas de gerenciamento de fichas
     * 
     * @return {string} HTML das listas de gerenciamento de fichas
     */
    render() {
        // Icons usados no componente MaterialTable
        const tableIcons = {
            Check: forwardRef((props, ref) => <Check {...props} ref={ref} />),
            Clear: forwardRef((props, ref) => <Clear {...props} ref={ref} />),
            Edit: forwardRef((props, ref) => <Edit {...props} ref={ref} />),
            Filter: forwardRef((props, ref) => <FilterList {...props} ref={ref} />),
            FirstPage: forwardRef((props, ref) => <FirstPage {...props} ref={ref} />),
            LastPage: forwardRef((props, ref) => <LastPage {...props} ref={ref} />),
            NextPage: forwardRef((props, ref) => <ChevronRight {...props} ref={ref} />),
            PreviousPage: forwardRef((props, ref) => <ChevronLeft {...props} ref={ref} />),
            ResetSearch: forwardRef((props, ref) => <Clear {...props} ref={ref} />),
            Search: forwardRef((props, ref) => <Search {...props} ref={ref} />),
            SortArrow: forwardRef((props, ref) => <ArrowDownward {...props} ref={ref} />),
            ThirdStateCheck: forwardRef((props, ref) => <Remove {...props} ref={ref} />),
            ViewColumn: forwardRef((props, ref) => <ViewColumn {...props} ref={ref} />)
        }

        return (
            <div className="tool-tips widget-shadow">
                <button className="btn btn-primary" style={{ float: "right" }} onClick={(event) => this.proximaFicha(event)}>Chamar Próximo</button>
                <h4 style={{ fontSize: "1.4em", margin: "0 0 1em 0", color: "#777777" }}>Painel do Setor:</h4>
                <ul className="nav nav-tabs">
                    <li className={this.state.abaActive === "naoAtendidos" ? "active" : null}>
                        <a href="#nA" >
                            <button type="button" className="btn btn-danger" onMouseEnter={() => this.setState(prevState => ({ ...prevState, abaActive: "naoAtendidos" }))}>Não atendidos</button>
                        </a>
                    </li>
                    <li className={this.state.abaActive === "emAtendimento" ? "active" : null}>
                        <a href="#eA" >
                            <button type="button" className="btn btn-success" onMouseEnter={() => this.setState(prevState => ({ ...prevState, abaActive: "emAtendimento" }))}>Em antendimento</button>
                        </a>
                    </li>
                    <li className={this.state.abaActive === "atendidos" ? "active" : null}>
                        <a href="#A" >
                            <button type="button" className="btn btn-info" onMouseEnter={() => this.setState(prevState => ({ ...prevState, abaActive: "atendidos" }))}>Atendidos</button>
                        </a>
                    </li>
                </ul>
                <div className="tab-content" tabIndex="5000" style={{ overflow: "hidden", outline: "none" }}>
                    <div id="naoAtendidos" role="tabpanel" className={this.state.abaActive === "naoAtendidos" ? "tab-pane fade active in" : "tab-pane fade"} aria-labelledby="naoAtendidos-tab">
                        <MaterialTable
                            localization={this.state.localization}
                            icons={tableIcons}
                            columns={this.state.naoAtendido_columns}
                            data={this.state.naoAtendido_data}
                            options={this.state.options}
                            components={this.state.components}
                            actions={[
                                {
                                    icon: RecordVoiceOverIcon,
                                    tooltip: 'Chamar',
                                    onClick: (event, rowData) => (this.fichaIndividual(rowData.ficha_id, event))
                                }
                            ]}
                        />
                    </div>
                    <div id="emAtendimento" role="tabpanel" className={this.state.abaActive === "emAtendimento" ? "tab-pane fade active in" : "tab-pane fade"} aria-labelledby="emAtendimento-tab">
                        <MaterialTable
                            localization={this.state.localization}
                            icons={tableIcons}
                            columns={this.state.emAtendimento_columns}
                            data={this.state.emAtendimento_data}
                            options={this.state.options}
                            components={this.state.components}
                            editable={{
                                onRowUpdate: (newData) =>
                                    new Promise(resolve => {
                                        this.encaminhar_ficha(newData.ficha_id, newData.ficha_encaminhar_setor)
                                        setTimeout(() => {
                                            resolve()
                                        }, 600)
                                    })
                            }}
                            actions={[
                                {
                                    icon: DoneIcon,
                                    tooltip: 'Finalizar',
                                    onClick: (event, rowData) => (this.finalizarFicha(rowData.ficha_id, event))
                                }
                            ]}
                        />
                    </div>
                    <div id="atendidos" role="tabpanel" className={this.state.abaActive === "atendidos" ? "tab-pane fade active in" : "tab-pane fade"} aria-labelledby="atendidos-tab">
                        <MaterialTable
                            localization={this.state.localization}
                            icons={tableIcons}
                            columns={this.state.atendidos_columns}
                            data={this.state.atendidos_data}
                            options={this.state.options}
                            components={this.state.components}
                        />
                    </div>
                </div>
            </div>
        )
    }
}

export default connect(state => ({ modules: state }))(TabContent)