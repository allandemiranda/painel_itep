<?php

/**
 * @file Header.php
 * @author Allan de Miranda Silva (allandemiranda@gmail.com)
 * @brief Contem todo o cabeçalho necessário para página ser de conteudo json
 * @version 1.0.0
 * @date 02-03-2020
 *
 * @copyright Copyright (c) 2020 DIGETI ITEP/RN
 *
 */
?>
<?php

// Header necessário para converter a página em um conteudo JSON
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
