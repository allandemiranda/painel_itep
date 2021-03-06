/**
 * @file index.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem toda a interação da store do redux com os demais componentes
 * @version 1.0.0
 * @date 13-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import { createStore } from 'redux'                             //! Componente básico do redux
import { persistStore, persistReducer } from 'redux-persist'    //! Componente do Redux
import storage from 'redux-persist/lib/storage'                 //! defaults to localStorage for web
import createEncryptor from 'redux-persist-transform-encrypt'   //! Componente para criptografar o redux 

// Contem todo o estado inicial da aplicação
const INITIAL_STATE = {
    version: {
        number: '1.0.0' // Versão atual do sistema
    },
    apiPage: {
        host: "https://chamador.itep.govrn/"     // Domínio da API
    },
    login: {
        active: true    // Tela de login
    },
    menu: {
        active: false   // Componente do menu principal
    },
    mainPage: {
        active: false   // Componente da área de trabalho
    },
    widgetStatus: {
        active: false   // Indicadores do chamador
    },
    tabContent: {
        active: false   // Gerenciador de fichas
    },
    painelFichas: {
        active: false   // Gerenciador do criador de fichas
    },
    usuarios: {
        active: false   // Componente com a lista de usuários
    },
    setores: {
        active: false   // Componente com a lista de setores
    },
    fichas: {
        active: false   // Componente com criador de fichas
    },
    logs: {
        active: false   // Componente com a lista de logs
    },
    perfil: {
        active: false,  // Componente com o prfil do usuário logado
        login: "",      // Credencial de login do usuário
        senha: ""       // Credencial de senha criptografada do usuário
    },
    alerta: {
        active: false   // Componente de alertas
    }
}

/**
 * @brief Copntem interações de solicitações do Redux
 * 
 * @param {Object} state State dos componentes
 * @param {Object} action Mensagem das ações
 */
function rootReducer(state = INITIAL_STATE, action) {
    // Verifica a versão do sistema
    if (state.version.number !== INITIAL_STATE.version.number) {
        state = INITIAL_STATE
        return state
    } else {
        // Lista de ações do Reducer
        switch (action.type) {
            case "ABRIR_PAINEL_FICHA":
                return abrirPainelFichas(state)
            case "ABRIR_DASHBOARD":
                return abrirDashboard(state)
            case "LOGIN_APROVADO":
                return loginAprovado(state, action.formulario)
            case "LOGOUT":
                return INITIAL_STATE
            case "ABRIR_PERFIL":
                return abrirPerfil(state)
            case "MODIFICAR_PERFIL":
                return modificarPerfil(state, action.formulario)
            case "ABRIR_USUARIOS":
                return abrirUsuarios(state)
            case "ADICIONAR_ALERTA":
                return adicionarAlerta(state, action.alerta)
            case "REMOVER_ALERTA":
                return removerAlerta(state)
            case "ABRIR_SETORES":
                return abrirSetores(state)
            case "ABRIR_LOGS":
                return abrirLogs(state)
            case "ABRIR_FICHAS":
                return abrirFichas(state)
            default:
                return state
        }
    }
}

/**
* @brief Abre lista de fichas do sistema
* 
* @param {Object} state State dos componentes
*/
function abrirFichas(state) {
    return {
        ...state,
        widgetStatus: {
            ...state.widgetStatus,
            active: false   // Indicadores do chamador
        },
        tabContent: {
            ...state.tabContent,
            active: false   // Gerenciador de fichas
        },
        painelFichas: {
            ...state.painelFichas,
            active: false   // Gerenciador do criador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: false   // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: false   // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: true    // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: false   // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: false   // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

/**
* @brief Abre lista de logs do sistema
* 
* @param {Object} state State dos componentes
*/
function abrirLogs(state) {
    return {
        ...state,
        widgetStatus: {
            ...state.widgetStatus,
            active: false   // Indicadores do chamador
        },
        tabContent: {
            ...state.tabContent,
            active: false   // Gerenciador de fichas
        },
        painelFichas: {
            ...state.painelFichas,
            active: false   // Gerenciador do criador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: false   // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: false   // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: false   // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: true    // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: false   // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

/**
* @brief Abre lista de setres do sistema
* 
* @param {Object} state State dos componentes
*/
function abrirSetores(state) {
    return {
        ...state,
        widgetStatus: {
            ...state.widgetStatus,
            active: false   // Indicadores do chamador
        },
        tabContent: {
            ...state.tabContent,
            active: false   // Gerenciador de fichas
        },
        painelFichas: {
            ...state.painelFichas,
            active: false   // Gerenciador do criador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: false   // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: true    // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: false   // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: false   // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: false   // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

/**
* @brief Remove alerta da tela
* 
* @param {Object} state State dos componentes
*/
function removerAlerta(state) {
    return {
        ...state,
        alerta: {
            ...state.alerta,
            active: false       // Componente de alertas
        }
    }
}

/**
* @brief Adiciona alerta a página
* 
* @param {Object} state State dos componentes
* @param {Object} dados Dados enviados da requisição
*/
function adicionarAlerta(state, dados) {
    return {
        ...state,
        alerta: {
            ...state.alerta,
            active: true,               // Componente de alertas
            tipo: dados.tipo,           // Tipo da mensagem
            mensagem: dados.mensagem    // Conteudo da mensagem
        }
    }
}

/**
 * @brief Abre lista de usuários do sistema
 * 
 * @param {Object} state State dos componentes
 */
function abrirUsuarios(state) {
    return {
        ...state,
        widgetStatus: {
            ...state.widgetStatus,
            active: false   // Indicadores do chamador
        },
        tabContent: {
            ...state.tabContent,
            active: false   // Gerenciador de fichas
        },
        painelFichas: {
            ...state.painelFichas,
            active: false   // Gerenciador do criador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: true    // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: false   // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: false   // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: false   // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: false   // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

/**
* @brief Ação para atualizar a credencial do funcionário logado
* 
* @param {Object} state State dos componentes
* @param {Object} dados Dados enviados da requisição
*/
function modificarPerfil(state, dados) {
    return {
        ...state,
        perfil: {
            ...state.perfil,
            senha: dados.senha  // Credencial de senha criptografada do usuário
        }
    }
}

/**
* @brief Abre componente do Perfil do Funcionário Logado
* 
* @param {Object} state State dos componentes
*/
function abrirPerfil(state) {
    return {
        ...state,
        widgetStatus: {
            ...state.widgetStatus,
            active: false   // Indicadores do chamador
        },
        tabContent: {
            ...state.tabContent,
            active: false   // Gerenciador de fichas
        },
        painelFichas: {
            ...state.painelFichas,
            active: false   // Gerenciador do criador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: false   // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: false   // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: false   // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: false   // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: true    // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

/**
 * @brief Modifica componentes ao logar no sistema
 * 
 * @param {object} state Estado dos componentes
 * @param {Object} dados Dados enviados da requisição
 */
function loginAprovado(state, dados) {
    return {
        ...state,
        login: {
            ...state.login,
            active: false       // Tela de login
        },
        menu: {
            ...state.menu,
            active: true        // Componente do menu principal
        },
        mainPage: {
            ...state.mainPage,  // Componente da área de trabalho
            active: true,
        },
        perfil: {
            ...state.perfil,
            login: dados.login, // Credencial de login do usuário
            senha: dados.senha  // Credencial de senha criptografada do usuário
        }
    }
}

/**
* @brief Abre componente da tela inicial Dashboard
* 
* @param {Object} state Estado dos componentes
*/
function abrirDashboard(state) {
    return {
        ...state,
        widgetStatus: {
            ...state.widgetStatus,
            active: true    // Indicadores do chamador
        },
        tabContent: {
            ...state.tabContent,
            active: true    // Gerenciador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: false   // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: false   // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: false   // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: false   // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: false   // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

/**
 * @brief Abre componente do Painel para gerar Fichas
 * 
 * @param {Object} state Estado dos componentes
 */
function abrirPainelFichas(state) {
    return {
        ...state,
        painelFichas: {
            ...state.painelFichas,
            active: true    // Gerenciador do criador de fichas
        },
        usuarios: {
            ...state.usuarios,
            active: false   // Componente com a lista de usuários
        },
        setores: {
            ...state.setores,
            active: false   // Componente com a lista de setores
        },
        fichas: {
            ...state.fichas,
            active: false   // Componente com criador de fichas
        },
        logs: {
            ...state.logs,
            active: false   // Componente com a lista de logs
        },
        perfil: {
            ...state.perfil,
            active: false   // Componente com o prfil do usuário logado
        },
        alerta: {
            ...state.alerta,
            active: false   // Componente de alertas
        }
    }
}

// Criptografa todo o local storage
const encryptor = createEncryptor({
    secretKey: '19d2d126356c88a9eac92f6a31345f62'
})

// Configurações do persist 
const persistConfig = {
    key: 'root',
    storage,
    transforms: [encryptor]
}

const persistedReducer = persistReducer(persistConfig, rootReducer)
const store = createStore(persistedReducer)
const persistor = persistStore(store)
export { store, persistor }