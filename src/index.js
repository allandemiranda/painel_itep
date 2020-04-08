/**
 * @file index.js
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem a renderização do componente inicial
 * @version 1.0.0
 * @date 10-02-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */

import React from 'react'                                           //! Componente do react
import ReactDOM from 'react-dom'                                    //! Componente do react
import App from './componentes/App.js'                              //! Componente do app do sistema
import * as serviceWorker from './serviceWorker'                    //! Componente do react
import { Provider } from 'react-redux'                              //! Componente Redux
import { store, persistor } from './store'                          //! Componente do store do react
import { PersistGate } from 'redux-persist/integration/react'       //! Componente ligado ao store do react
import { BrowserRouter, Switch, Route } from 'react-router-dom'     //! Componente de rotas do react
import PainelChamador from './componentes/painel/PainelChamador'    //! Componente do painel chamador

import './css/bootstrap.css'        //! css importado
import './css/custom.css'           //! css importado
import './css/font-awesome.css'     //! css importado
import './css/SidebarNav.min.css'   //! css importado
import './css/style.css'            //! css importado

ReactDOM.render(
    <Provider store={store}>
        <PersistGate loading={null} persistor={persistor}>
            <BrowserRouter>
                <Switch>
                    <Route path="/" exact={true} component={App} />
                    <Route path="/painel" component={PainelChamador} />
                </Switch>
            </ BrowserRouter>
        </PersistGate>
    </Provider>,
    document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
