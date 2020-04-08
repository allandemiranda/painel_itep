/**
 * @file App.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a Classe com a aplicação inicial
 * @version 1.0.0
 * @date 06-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React, { Component } from 'react'                      //! Compoennte básico React
import { connect } from 'react-redux'                         //! Componente Redux
import Login from './login/Login.js'                          //! Componente com a tela de login
import Menu from './menu/Menu.js'                             //! Componente com a barra de menu lateral
import MainPage from './mainPage/MainPage.js'                 //! Componete com a área de trabalho dos componentes
import StickyHeader from './mainPage/header/StickyHeader.js'  //! Componente com o cabeçalho da página


class App extends Component {

  /**
   * @brief Renderiza o sistema
   * 
   * @return {string} HTML do sistema
   */
  render() {
    return (
      <div>
        {this.props.modules.login.active ? <Login></Login> : null}
        {this.props.modules.menu.active ? <Menu></Menu> : null}
        {this.props.modules.menu.active ? <StickyHeader></StickyHeader> : null}
        {this.props.modules.mainPage.active ? <MainPage></MainPage> : null}
      </div>
    )
  };
}

export default connect(state => ({ modules: state }))(App)
