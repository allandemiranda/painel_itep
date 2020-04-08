/**
 * @file PainelGeral.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe que lista e adiciona uma nova ficha
 * @version 1.0.0
 * @date 23-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                        //! Componente básico
import { connect } from 'react-redux'                           //! Componente Redux
import axios from 'axios'                                       //! Componente Axios
import MaterialTable from 'material-table'                      //! Componente da tabela
import { forwardRef } from 'react'                              //! Componente da tabela
import AddBox from '@material-ui/icons/AddBox'                  //! Componente da tabela
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
import PrintIcon from '@material-ui/icons/Print'                //! Componente da tabela

class PainelGeral extends Component {
    constructor() {
        super()
        this.state = {
            columns: [
                {
                    title: 'Número',
                    field: 'ficha_numero',
                    editable: 'never',
                    defaultSort: 'desc',
                    cellStyle: {
                        textAlign: "center"
                    }
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
                    title: 'Status',
                    field: 'ficha_status',
                    editable: 'never'
                },
                {
                    title: 'Setor',
                    field: 'ficha_setor_id',
                    lookup: {}
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
                    title: 'Hora',
                    field: 'ficha_hora',
                    editable: 'never'
                }
            ]
        }
        this.fichaNew = this.fichaNew.bind(this)
        this.tick_after = this.tick_after.bind(this)
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Carrega a lista de fichas geradas no dia, mantendo ela atualizada
     * 
     */
    componentDidMount() {
        this.tick()

        // Atualiza a lista de fichas a cada 5 segundo
        this.intervalID = setInterval(
            () => this.tick_after(),
            5000
        );
    }

    /**
     * @breif Destroi o objeto que atualiza a lista de fichas assim que o componente é fechado
     * 
     */
    componentWillUnmount() {
        clearInterval(this.intervalID);
    }

    /**
     * @brief Obter a lista de fichas do dia
     * 
     */
    tick() {
        // Requisita a API a lista de fichas do dia
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/painelGeral/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                this.setState(prevState => ({
                    ...prevState,
                    data: response.data[1],
                    columns: [
                        {
                            title: 'Número',
                            field: 'ficha_numero',
                            editable: 'never',
                            defaultSort: 'desc',
                            cellStyle: {
                                textAlign: "center"
                            }
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
                            title: 'Status',
                            field: 'ficha_status',
                            editable: 'never'
                        },
                        {
                            title: 'Setor',
                            field: 'ficha_setor_id',
                            lookup: response.data[0]
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
                            title: 'Hora',
                            field: 'ficha_hora',
                            editable: 'never'
                        }
                    ]
                }))
            })
    }

    /**
     * @brief Atualiza lista de fichas
     * 
     */
    tick_after() {
        // Requisita a API a lista de fichas do dia
        axios.post(this.props.modules.apiPage.host + "/api/mainPage/painelGeral/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Atualiza a lista de fichas atual
                this.setState(prevState => ({
                    ...prevState,
                    data: response.data[1]
                }))
            })
    }

    /**
     * @brief Cria uma nova ficha
     * 
     * @param {String} ficha_nome Nome da Ficha
     * @param {String} ficha_telefone Telefone da Ficha
     * @param {Number} ficha_setor_id id do Setor da Ficha
     * @param {Boolean} ficha_prioridade Se é prioridade
     */
    fichaNew(ficha_nome, ficha_telefone, ficha_setor_id, ficha_prioridade) {
        // Verifica se o usuário preencheu todos os campor necessários
        if ((ficha_nome === undefined) || (ficha_telefone === undefined) || (ficha_setor_id === undefined) || (ficha_prioridade === undefined)) {
            this.props.dispatch({
                type: "ADICIONAR_ALERTA",
                alerta: {
                    tipo: 'danger',
                    mensagem: "Necessário preencher todos os dados."
                }
            })
        } else {
            // Requisita a API a criação de uma nova ficha
            axios.post(
                this.props.modules.apiPage.host + "/api/mainPage/painelGeral/new.php",
                {
                    login: this.props.modules.perfil.login, // Credencial de login do usuário
                    senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                    nome: ficha_nome.toUpperCase(),         // Nome da ficha
                    telefone: ficha_telefone,               // Telefone da ficha
                    setor_id: ficha_setor_id,               // id do setor para onde a ficha vai
                    prioridade: ficha_prioridade            // Se é uma ficha de prioridade
                },
                { method: 'POST' })
                .then(response => {
                    if (response.data.mensagem === "FICHA CRIADA") {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'success',
                                mensagem: "Ficha número <b>" + response.data.numero + "</b> para o setor <b>" + response.data.setor + "</b> criada."
                            }
                        })
                    } else {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'danger',
                                mensagem: "Não foi possivel criar uma nova Ficha."
                            }
                        })
                    }
                })
        }
    }

    /**
     * @brief Renderiza tabela de fichas do sistema
     * 
     * @return {string} HTML da tabela de fichas do sistema
     */
    render() {
        // Icons usados no componente MaterialTable
        const tableIcons = {
            Add: forwardRef((props, ref) => <AddBox {...props} ref={ref} />),
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
            <MaterialTable
                localization={{
                    body: {
                        emptyDataSourceMessage: 'Nenhuma ficha foi criada hoje',
                        addTooltip: 'Criar',
                        filterRow: {
                            filterTooltip: 'Filtrar'
                        },
                        editRow: {
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
                }}
                icons={tableIcons}
                title="Fichas do Sistema"
                columns={this.state.columns}
                data={this.state.data}
                actions={[
                    {
                        icon: PrintIcon,
                        tooltip: 'Imprimir',
                        onClick: (event, rowData) => (window.open(this.props.modules.apiPage.host + '/api/imprimir/ficha/index.php?id=' + rowData.ficha_id))
                    }
                ]}
                editable={{
                    onRowAdd: newData =>
                        new Promise(resolve => {
                            setTimeout(() => {
                                this.fichaNew(newData.ficha_nome, newData.ficha_telefone, newData.ficha_setor_id, newData.ficha_prioridade)
                                resolve();
                                this.componentDidMount();
                            }, 600);
                        })
                }}
                options={{
                    pageSize: 5,
                    pageSizeOptions: [5, 10, 30],
                    sorting: true,
                    cellStyle: {
                        textAlign: "lefth"
                    },
                    headerStyle: {
                        textAlign: "lefth"
                    },
                    actionsColumnIndex: -1
                }}
            />
        )
    }
}

export default connect(state => ({ modules: state }))(PainelGeral)