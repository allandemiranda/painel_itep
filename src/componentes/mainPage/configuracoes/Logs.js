/**
 * @file Logs.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe para listar os logs do sistema
 * @version 1.0.0
 * @date 12-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                        //! Componente básico
import { connect } from 'react-redux'                           //! Componente Redux
import axios from 'axios'                                       //! Componente Axios
import * as moment from 'moment'                                //! Métodos para manipular horas
import 'moment/locale/pt-br'                                    //! Biblioteca pt-BR para 'moment'
import MaterialTable from 'material-table'                      //! Componente da tabela
import { forwardRef } from 'react'                              //! Componente da tabela
import ArrowDownward from '@material-ui/icons/ArrowDownward'    //! Componente da tabela
import ChevronLeft from '@material-ui/icons/ChevronLeft'        //! Componente da tabela
import ChevronRight from '@material-ui/icons/ChevronRight'      //! Componente da tabela
import Clear from '@material-ui/icons/Clear'                    //! Componente da tabela
import FilterList from '@material-ui/icons/FilterList'          //! Componente da tabela
import FirstPage from '@material-ui/icons/FirstPage'            //! Componente da tabela
import LastPage from '@material-ui/icons/LastPage'              //! Componente da tabela
import SaveAlt from '@material-ui/icons/SaveAlt'                //! Componente da tabela
import Search from '@material-ui/icons/Search'                  //! Componente da tabela
import ViewColumn from '@material-ui/icons/ViewColumn'          //! Componente da tabela

class Logs extends Component {
    constructor(props) {
        super(props)
        this.state = {
            columns: [
                {
                    title: 'id',
                    field: 'log_id',
                    type: 'numeric',
                    defaultSort: 'desc',
                    cellStyle: {
                        textAlign: "center"
                    },
                    headerStyle: {
                        textAlign: "center"
                    }
                },
                {
                    title: 'Ação',
                    field: 'log_acao'
                },
                {
                    title: 'Usuário',
                    field: 'log_usuario_nome'
                },
                {
                    title: 'Data',
                    field: 'log_data_criacao'
                },
                {
                    title: 'Endereço',
                    field: 'log_ip'
                }
            ],
            data: []
        }
        this.tick = this.tick.bind(this)
        this.tick_after = this.tick_after.bind(this)
    }

    /**
     * @brief Carrega a lista de logs do sistema antes dele ser montado e atualiza a lista caso haja alteração
     * 
     */
    componentDidMount() {
        this.tick() //! Solicita a lista dos logs do sistema

        // Solicida a cada 3 segundo a lista de logs do sistema para atualizar caso haja alteração
        this.intervalID = setInterval(
            () => this.tick_after(),
            3000
        );
    }

    /**
     * @breif Destroi o objeto que atualiza a lista de logs assim que o componente é fechado
     * 
     */
    componentWillUnmount() {
        clearInterval(this.intervalID);
    }

    /**
     * @brief Obtém a lista de logs atualizando o estado do componente para depois da lista já ter elementos
     * 
     */
    tick_after() {
        // Requisita a API a lista de logs criadas no sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/logs/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                var newData = response.data;

                // Verifica se a lista nova tem mais elementos
                const position_initial = newData.length - this.state.data.length
                if (position_initial !== 0) {
                    const position_final = newData.length - 1
                    newData.splice(position_initial, position_final)

                    // Concatenar novas informações com a lista antiga
                    this.setState(prevState => ({
                        ...prevState,
                        data: this.state.data.concat(newData)
                    }))
                }
            })
    }

    /**
     * @brief Obtém lista de logs do sistema
     *  
     */
    tick() {
        // Requisita a API a lista de logs criadas no sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/logs/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Criar a lista de logs para a tabela
                this.setState(prevState => ({
                    ...prevState,
                    data: response.data
                }))
            })
    }

    /**
     * @brief Renderiza tabela de logs do sistema
     * 
     * @return {string} HTML da tabela de logs do sistema
     */
    render() {
        // Icons usados no componente MaterialTable
        const tableIcons = {
            DetailPanel: forwardRef((props, ref) => <ChevronRight {...props} ref={ref} />),
            Export: forwardRef((props, ref) => <SaveAlt {...props} ref={ref} />),
            Filter: forwardRef((props, ref) => <FilterList {...props} ref={ref} />),
            FirstPage: forwardRef((props, ref) => <FirstPage {...props} ref={ref} />),
            LastPage: forwardRef((props, ref) => <LastPage {...props} ref={ref} />),
            NextPage: forwardRef((props, ref) => <ChevronRight {...props} ref={ref} />),
            PreviousPage: forwardRef((props, ref) => <ChevronLeft {...props} ref={ref} />),
            ResetSearch: forwardRef((props, ref) => <Clear {...props} ref={ref} />),
            Search: forwardRef((props, ref) => <Search {...props} ref={ref} />),
            SortArrow: forwardRef((props, ref) => <ArrowDownward {...props} ref={ref} />),
            ViewColumn: forwardRef((props, ref) => <ViewColumn {...props} ref={ref} />)
        };

        // Style do texto que aprenseta a descrição completa do log
        const text_muted = {
            color: "inherit",
            opacity: ".6",
            fontSize: "14px"
        }

        // Style do texto que apresenta a infomação do tempo passado da criação do log
        const sl_content = {
            marginLeft: "24px",
            boxSizing: "border-box",
            outline: "0 !important"
        }

        return (
            <MaterialTable
                localization={{
                    body: {
                        emptyDataSourceMessage: 'Não foi possivel carregar lista',
                        filterRow: {
                            filterTooltip: 'Filtrar'
                        }
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
                        searchTooltip: 'Procurar',
                        searchPlaceholder: 'Procurar',
                        exportTitle: 'Exportar',
                        exportAriaLabel: 'Exportar',
                        exportName: 'Exportar como CSV'
                    }
                }}
                detailPanel={[
                    {
                        tooltip: 'Detalhes',
                        render: rowData => {
                            var textLog = null;
                            switch (rowData.log_acao) {
                                case "CRIOU USUÁRIO":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} criou usuário {rowData.log_de_nome} no setor {rowData.log_de_setor_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "CRIOU SETOR":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} criou setor {rowData.log_de_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "EXCLUIU USUÁRIO":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} excluiu usuário {rowData.log_de_nome} do setor {rowData.log_de_setor_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "EXCLUIU SETOR":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} excluiu setor {rowData.log_de_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "ATUALIZOU USUÁRIO":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} atualizou usuário {rowData.log_de_nome} do setor {rowData.log_de_setor_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "ATUALIZOU SETOR":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} atualizou setor {rowData.log_de_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "ATUALIZOU PERFIL":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} atualizou seu perfil na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "CRIOU FICHA":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} criou ficha de número {rowData.log_de_numero}, nome {rowData.log_de_nome} e telefone {rowData.log_de_telefone} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "CHAMOU FICHA":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} chamou ficha de número {rowData.log_de_numero}, nome {rowData.log_de_nome} e telefone {rowData.log_de_telefone} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "ENCAMINHOU FICHA":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} encaminhou ficha de número {rowData.log_de_numero}, nome {rowData.log_de_nome} e telefone {rowData.log_de_telefone} para o setor {rowData.log_para_nome} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                case "FINALIZOU FICHA":
                                    textLog = (<p>Usuário {rowData.log_usuario_nome} do setor {rowData.log_usuario_setor_nome} finalizou ficha de número {rowData.log_de_numero}, nome {rowData.log_de_nome} e telefone {rowData.log_de_telefone} na data {rowData.log_data_criacao} no endereço ip {rowData.log_ip}</p>)
                                    break
                                default:
                                    textLog = (<p>Erro ao carregar informações do Log!</p>)
                                    break
                            }

                            moment().locale('pt-BR')
                            return (
                                <div>
                                    <div style={sl_content}>
                                        <small style={text_muted}>{moment(rowData.log_data_criacao, "DD/MM/YYYY HH:mm:ss").fromNow()}</small>
                                        {textLog}
                                    </div>
                                </div>
                            )
                        },
                    }
                ]}
                icons={tableIcons}
                title="Logs do Sistema"
                columns={this.state.columns}
                data={this.state.data}
                options={{
                    exportButton: true,
                    pageSize: 10,
                    pageSizeOptions: [10, 20, 50]
                }}
            />
        )
    }
}

export default connect(state => ({ modules: state }))(Logs)