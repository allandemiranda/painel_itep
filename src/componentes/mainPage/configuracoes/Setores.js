/**
 * @file Setores.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a classe para listar, criar, editar e excluir os setores cadastrados no sistema
 * @version 1.0.0
 * @date 14-02-2020
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
import DeleteOutline from '@material-ui/icons/DeleteOutline'    //! Componente da tabela
import Edit from '@material-ui/icons/Edit'                      //! Componente da tabela
import FilterList from '@material-ui/icons/FilterList'          //! Componente da tabela
import FirstPage from '@material-ui/icons/FirstPage'            //! Componente da tabela
import LastPage from '@material-ui/icons/LastPage'              //! Componente da tabela
import Remove from '@material-ui/icons/Remove'                  //! Componente da tabela
import Search from '@material-ui/icons/Search'                  //! Componente da tabela
import ViewColumn from '@material-ui/icons/ViewColumn'          //! Componente da tabela

class Setores extends Component {
    constructor(props) {
        super(props)
        this.state = {
            columns: [
                {
                    title: 'Nome',
                    field: 'setor_nome'
                },
                {
                    title: 'Ger. Fichas',
                    field: 'setor_ficha',
                    lookup: {
                        0: "NÃO",
                        1: "SIM"
                    }
                },
                {
                    title: 'Administrador',
                    field: 'setor_admin',
                    lookup: {
                        0: "NÃO",
                        1: "SIM"
                    }
                },
                {
                    title: 'Data Criação',
                    field: 'setor_criado_data',
                    editable: 'never'
                }
            ]
        }
        this.sectorDelete = this.sectorDelete.bind(this)
        this.sectorUpdate = this.sectorUpdate.bind(this)
        this.sectorNew = this.sectorNew.bind(this)
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Obtém lista de setores do sistema
     * 
     */
    tick() {
        // Requisita a API a lista de setores ativos do sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/setores/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Criar a lista de setores para a tabela
                this.setState(prevState => ({
                    ...prevState,
                    data: response.data
                }))
            })
    }

    /**
     * @brief Carrega a lista de setores do sistema antes dele ser montado
     * 
     */
    componentDidMount() {
        this.tick()
    }

    /**
     * @brief Deleta um setor do sistema
     * 
     * @param {Number} setor_id id do setor a ser deletado
     */
    sectorDelete(setor_id) {
        // Requisita a API para deletar um setor
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/setores/delete.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                id: setor_id                            // id do setor a ser deletado
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "SETOR DELETADO") {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'success',
                            mensagem: "Setor <b>" + response.data.setor_nome + "</b> deletado."
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel deletar o Setor."
                        }
                    })
                }
                this.tick()
            })
    }

    /**
     * @brief Atualiza dados de um setor
     * 
     * @param {Number} setor_id id do Setor que será modificado
     * @param {String} setor_nome Nome do Setor que será modificado
     * @param {Boolean} setor_ficha Se o setor gerencia as fichas
     * @param {Boolean} setor_admin Se o setor é admin
     */
    sectorUpdate(setor_id, setor_nome, setor_ficha, setor_admin) {
        // Requisita a API para editar um setor
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/setores/update.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                id: setor_id,                           // id do setor
                nome: setor_nome,                       // novo nome do setor
                ficha: setor_ficha,                     // se o setor é criador de fichas
                admin: setor_admin                      // se o setor tem permição admin
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "SETOR ATUALIZADO") {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'success',
                            mensagem: "Setor <b>" + setor_nome + "</b> editado."
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel editar <b>" + setor_nome + "</b>."
                        }
                    })
                }
                this.tick()
            })
    }

    /**
     * @brief Cria um novo setor para o sistema
     * 
     * @param {String} setor_nome Nome do novo Setor
     * @param {Boolean} setor_ficha Se o setor gerencia as fichas
     * @param {Boolean} setor_admin Se o setor é admin
     */
    sectorNew(setor_nome, setor_ficha, setor_admin) {
        // Verifica se o usuário preencheu todos os campos
        if ((setor_nome === undefined) || (setor_admin === undefined) || (setor_ficha === undefined)) {
            this.props.dispatch({
                type: "ADICIONAR_ALERTA",
                alerta: {
                    tipo: 'danger',
                    mensagem: "Necessário preencher todas as opções."
                }
            })
        } else {
            // Requisita a API a criação de um novo setor para o sistema
            axios.post(
                this.props.modules.apiPage.host + "/api/menu/configuracoes/setores/new.php",
                {
                    login: this.props.modules.perfil.login, // Credencial de login do usuário
                    senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                    nome: setor_nome.toUpperCase(),         // Nome do novo setor
                    ficha: setor_ficha,                     // Se o novo setor cria fichas
                    admin: setor_admin                      // Se o novo setor é do tipo administrador
                },
                { method: 'POST' })
                .then(response => {
                    // Verifica se a operação foi sucesso
                    if (response.data.mensagem === "FUNCIONÁRIO ADICIONADO") {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'success',
                                mensagem: "Setor <b>" + response.data.nome + "</b> adicionado."
                            }
                        })
                    } else {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'danger',
                                mensagem: "Não foi possivel adicionar um novo Setor."
                            }
                        })
                    }
                    this.tick()
                })
        }
    }

    /**
     * @brief Função de renderização
     * 
     * @return {String} Componente com a lista de usuários e suas possiveis manipulações
     */
    render() {
        // Icons usados no componente MaterialTable
        const tableIcons = {
            Add: forwardRef((props, ref) => <AddBox {...props} ref={ref} />),
            Check: forwardRef((props, ref) => <Check {...props} ref={ref} />),
            Clear: forwardRef((props, ref) => <Clear {...props} ref={ref} />),
            Delete: forwardRef((props, ref) => <DeleteOutline {...props} ref={ref} />),
            DetailPanel: forwardRef((props, ref) => <ChevronRight {...props} ref={ref} />),
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
                        emptyDataSourceMessage: 'Não foi possivel carregar lista',
                        addTooltip: 'Adicionar',
                        deleteTooltip: 'Deletar',
                        editTooltip: 'Editar',
                        filterRow: {
                            filterTooltip: 'Filtrar'
                        },
                        editRow: {
                            deleteText: 'Tem certeza de que deseja excluir este setor?',
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
                title="Setores do Sistema"
                columns={this.state.columns}
                data={this.state.data}
                editable={{
                    onRowAdd: newData =>
                        new Promise(resolve => {
                            this.sectorNew(newData.setor_nome, newData.setor_ficha, newData.setor_admin)
                            this.tick()
                            setTimeout(() => {
                                resolve();
                            }, 600);
                        }),
                    onRowUpdate: (newData) =>
                        new Promise(resolve => {
                            this.sectorUpdate(newData.setor_id, newData.setor_nome.toUpperCase(), newData.setor_ficha, newData.setor_admin)
                            this.tick()
                            setTimeout(() => {
                                resolve();
                            }, 600);
                        }),
                    onRowDelete: oldData =>
                        new Promise(resolve => {
                            this.sectorDelete(oldData.setor_id)
                            this.tick()
                            setTimeout(() => {
                                resolve();
                            }, 600);
                        }),
                }}
            />
        )
    }
}

export default connect(state => ({ modules: state }))(Setores)