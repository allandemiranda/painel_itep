/**
 * @file Usuarios.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @briefContem a classe para listar, criar, editar e excluir os usuários cadastrados no sistema
 * @version 1.0.0
 * @date 13-02-2020
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
import VpnKeyIcon from '@material-ui/icons/VpnKey'              //! Componente da tabela

class Usuarios extends Component {
    constructor() {
        super()
        this.state = {
            columns: [
                {
                    title: 'Nome',
                    field: 'usuario_nome',
                    editable: 'onAdd'
                },
                {
                    title: 'Setor',
                    field: 'setor_id',
                    lookup: {}
                },
                {
                    title: 'Login',
                    field: 'usuario_login',
                    editable: 'never'
                },
                {
                    title: 'Data Criação',
                    field: 'usuario_criacao_data',
                    editable: 'never'
                }
            ]
        }
        this.changerPassword = this.changerPassword.bind(this)
        this.userDelete = this.userDelete.bind(this)
        this.userUpdate = this.userUpdate.bind(this)
        this.userNew = this.userNew.bind(this)
        this.tick = this.tick.bind(this)
    }

    /**
     * @brief Obtém lista de usuários do sistema
     * 
     */
    tick() {
        // Requisita a API a lista de usuários ativos do sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/usuarios/",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha  // Credencial de senha criptografada do usuário
            }, { method: 'POST' })
            .then(response => {
                // Criar a lista de usários para a tabela
                this.setState(prevState => ({
                    ...prevState,
                    // colunas usadas na tabela
                    columns: [
                        {
                            title: 'Nome',
                            field: 'usuario_nome',
                            editable: 'onAdd'
                        },
                        {
                            title: 'Setor',
                            field: 'setor_id',
                            lookup: response.data[0]
                        },
                        {
                            title: 'Login',
                            field: 'usuario_login',
                            editable: 'never'
                        },
                        {
                            title: 'Data Criação',
                            field: 'usuario_criacao_data',
                            editable: 'never'
                        }
                    ],
                    data: response.data[1]
                }))
            })
    }

    /**
     * @brief Carrega a lista de usuários do sistema antes dele ser montado
     * 
     */
    componentDidMount() {
        this.tick()
    }

    /**
     * @brief Reseta a senha de um determinado usuário do sistema
     *  
     * @param {Number} usuario_id id do Usuário que terá sua senha reiniciada 
     * @param {Object} event Evento do botão
     */
    changerPassword(usuario_id, event) {
        // Requisita a API a modificação de uma senha de um usuário do sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/usuarios/password.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                id: usuario_id                          // id do usuário que terá sua senha resetada
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "SENHA MODIFICADA COM SUCESSO") {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'success',
                            mensagem: "Usuário <b>" + response.data.usuario + "</b> restaurou a senha para <b>" + response.data.novaSenha
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel restaurar senha do Usuário."
                        }
                    })
                }
            })
        event.preventDefault(); //! Cancela o submição do evendo do botão
    }

    /**
     * @brief Deleta um usuário do sistema
     * 
     * @param {Number} usuario_id id do usuário a ser deletado
     */
    userDelete(usuario_id) {
        // Requisita a API que delete um usuário do sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/usuarios/delete.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                id: usuario_id                          // id do usuário que será deletado do sistema
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "FUNCIONÁRIO DELETADO") {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'success',
                            mensagem: "Usuário <b>" + response.data.usuario_nome + "</b> deletado."
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel Deletar Usuário."
                        }
                    })
                }
                this.tick()
            })
    }

    /**
     * @brief Atualiza dados de um usuário
     * 
     * @param {Number} usuario_id id do Usuário que será atualizado
     * @param {String} usuario_nome Nome do Usuário que será atualizado
     * @param {Number} setor_id id do Setor do Usuário que será atualizado
     */
    userUpdate(usuario_id, usuario_nome, setor_id) {
        // Requisita a API que delete um usuário do sistema
        axios.post(this.props.modules.apiPage.host + "/api/menu/configuracoes/usuarios/update.php",
            {
                login: this.props.modules.perfil.login, // Credencial de login do usuário
                senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                id: usuario_id,                         // id do usuário que será atualizado do sistema
                setor: setor_id                         // id do novo setor para o usuário
            }, { method: 'POST' })
            .then(response => {
                // Verifica se a operação foi sucesso
                if (response.data.mensagem === "FUNCIONÁRIO ATUALIZADO") {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'success',
                            mensagem: "Usuário <b>" + usuario_nome + "</b> editado."
                        }
                    })
                } else {
                    this.props.dispatch({
                        type: "ADICIONAR_ALERTA",
                        alerta: {
                            tipo: 'danger',
                            mensagem: "Não foi possivel editar <b>" + usuario_nome + "</b>."
                        }
                    })
                }
                this.tick()
            })
    }

    /**
     * @brief Cria um novo usuário
     * 
     * @param {String} usuario_nome Nome do novo Usuário
     * @param {Number} setor_id id do Setor no novo Usuário
     */
    userNew(usuario_nome, setor_id) {
        // Verifica se o usuário preencheu todos os campos
        if ((usuario_nome === undefined) || (setor_id === undefined)) {
            this.props.dispatch({
                type: "ADICIONAR_ALERTA",
                alerta: {
                    tipo: 'danger',
                    mensagem: "Necessário preencher todos os dados."
                }
            })
        } else {
            // Requisita a API que crie um novo usuário no sistema
            axios.post(
                this.props.modules.apiPage.host + "/api/menu/configuracoes/usuarios/new.php",
                {
                    login: this.props.modules.perfil.login, // Credencial de login do usuário
                    senha: this.props.modules.perfil.senha, // Credencial de senha criptografada do usuário
                    nome: usuario_nome.toUpperCase(),       // Nome do novo usuário
                    setor: setor_id                         // id do setor do novo usuário
                },
                { method: 'POST' })
                .then(response => {
                    // Verifica se a operação foi sucesso
                    if (response.data.mensagem === "FUNCIONÁRIO ADICIONADO") {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'success',
                                mensagem: "Usuário <b>" + response.data.login + "</b> com senha <b>" + response.data.password + "</b>"
                            }
                        })
                    } else {
                        this.props.dispatch({
                            type: "ADICIONAR_ALERTA",
                            alerta: {
                                tipo: 'danger',
                                mensagem: "Não foi possivel adicionar um novo Usuários."
                            }
                        })
                    }
                    this.tick()
                })
        }
    }

    /**
     * @brief Renderiza tabela de usuários do sistema
     * 
     * @return {string} HTML da tabela de usuários do sistema
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
                            deleteText: 'Tem certeza de que deseja excluir este usuário?',
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
                title="Usuarios do Sistema"
                columns={this.state.columns}
                data={this.state.data}
                actions={[
                    rowData => (
                        {
                            icon: VpnKeyIcon,
                            tooltip: 'Modificar Senha',
                            onClick: (event, rowData) => this.changerPassword(rowData.usuario_id, event), // Modifica a senha do usuário
                            disabled: rowData.usuario_login === this.props.modules.perfil.login // Caso o usuário seja o da tabela
                        }
                    )
                ]}
                editable={{
                    onRowAdd: newData =>
                        new Promise(resolve => {
                            this.userNew(newData.usuario_nome, newData.setor_id)
                            this.tick()
                            setTimeout(() => {
                                resolve();
                            }, 600);
                        }),
                    onRowUpdate: (newData) =>
                        new Promise(resolve => {
                            this.userUpdate(newData.usuario_id, newData.usuario_nome.toUpperCase(), newData.setor_id)
                            this.tick()
                            setTimeout(() => {
                                resolve();
                            }, 600);
                        }),
                    onRowDelete: oldData =>
                        new Promise(resolve => {
                            this.userDelete(oldData.usuario_id)
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

export default connect(state => ({ modules: state }))(Usuarios)