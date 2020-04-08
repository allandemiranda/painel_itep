/**
 * @file Fichas.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe para listar as fichas do sistema
 * @version 1.0.0
 * @date 30-03-2020
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
import ChevronLeft from '@material-ui/icons/ChevronLeft'        //! Componente da tabela
import ChevronRight from '@material-ui/icons/ChevronRight'      //! Componente da tabela
import Clear from '@material-ui/icons/Clear'                    //! Componente da tabela
import FilterList from '@material-ui/icons/FilterList'          //! Componente da tabela
import FirstPage from '@material-ui/icons/FirstPage'            //! Componente da tabela
import LastPage from '@material-ui/icons/LastPage'              //! Componente da tabela
import SaveAlt from '@material-ui/icons/SaveAlt'                //! Componente da tabela
import Search from '@material-ui/icons/Search'                  //! Componente da tabela
import ViewColumn from '@material-ui/icons/ViewColumn'          //! Componente da tabela

class Fichas extends Component {
    constructor() {
        super()
        this.state = {
            columns: [
                {
                    title: 'Ficha id',
                    field: 'ficha_id',
                    type: 'numeric',
                    defaultSort: 'desc'
                },
                {
                    title: 'Número',
                    field: 'ficha_numero',
                    type: 'numeric'
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
                    title: 'Setor',
                    field: 'ficha_setor_nome'
                },
                {
                    title: 'Status',
                    field: 'ficha_status'
                },
                {
                    title: 'Hora Chegada',
                    field: 'ficha_criacao_data'
                },
                {
                    title: 'Hora Atualização',
                    field: 'ficha_atualizacao_data'
                }
            ]
        }
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Carrega a lista de fichas do sistema antes do componente ser montado e atualiza a lista caso haja alteração
     * 
     */
    componentDidMount() {
        this.tick() //! Solicita a lista de fichas do sistema

        // Solicita a cada 3 segundos a lista de fichas do sistema para atualizar caso haja alteração
        this.intervalID = setInterval(
            () => this.tick(),
            3000
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
     * @brief Obtém a lista de fichas criadas no sistema e seu status atual
     * 
     */
    tick() {
        // Requisita a API a lista de fichas criadas no sistema e seu status atual
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/fichas/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Salva os dados da lista de fichas no state da classe
                this.setState(prevState => ({
                    ...prevState,
                    data: response.data
                }))
            })
    }

    /**
     * @brief Renderiza formulário de login da página de login
     * 
     * @return {string} HTML do formulário de login
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
                icons={tableIcons}
                title="Fichas do Sistema"
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

export default connect(state => ({ modules: state }))(Fichas)