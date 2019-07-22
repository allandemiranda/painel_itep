<!DOCTYPE HTML>
<html>

<head>
    <title>Glance Design Dashboard an Admin Panel Category Flat Bootstrap Responsive Website Template | Login Page ::
        w3layouts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script
        type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <!-- font-awesome icons CSS-->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons CSS-->

    <!-- side nav css file -->
    <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
    <!-- side nav css file -->

    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet">
    <!--//webfonts-->

    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->

</head>

<body class="">
    <div class="main-content">
        <!-- main content start-->
        <div id="page-wrapper">
            <div class="tables">
                <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                    <h4>
                        Painel Geral
                        <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal"
                            data-target="#novaFichaModal">
                            Nova Ficha
                        </button>
                    </h4>
                    <!-- Modal -->
                    <div class="modal fade" id="novaFichaModal" tabindex="-1" role="dialog"
                        aria-labelledby="novaFichaModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="forms">
                                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                                        <div class="form-title">
                                            <h4>Nova Ficha </h4>
                                        </div>
                                        <div class="form-body">
                                            <form action="" method="">
                                                <div class="form-group">
                                                    <label>Nome </label>
                                                    <input name="ficha_nome" type="text" class="form-control"
                                                        placeholder="Nome Completo"
                                                        onChange="javascript:this.value=this.value.toUpperCase();"
                                                        value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input name="ficha_telefone" type="tel" class="form-control"
                                                        value="" placeholder="(84) 00000-0000" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Atendiemnto em</label>
                                                    <select name="ficha_setor" class="form-control" type="text">
                                                        <option value="SETOR UM" selected>SETOR UM</option>
                                                        <option value="SETOR DOIS">SETOR DOIS</option>
                                                        <option value="SETOR TRÊS">SETOR TRÊS</option>
                                                    </select>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="ficha_preferencial" type="checkbox"
                                                            class="checkbox" placeholder="Sala do Setor"
                                                            onChange="javascript:this.value=this.value.toUpperCase();">
                                                        Preferencial (idosos, gestantes e deficientes)
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-success">Imprimir</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Cancelar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Modal -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;">#</th>
                                <th style="text-align: center;">Nome</th>
                                <th style="text-align: center;">Telefone</th>
                                <th style="text-align: center;">Setor</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Data</th>
                                <th style="text-align: center;">Preferencial</th>
                                <th style="text-align: center;">Imprimir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" style="text-align: center;">1</th>
                                <td style="text-align: center;">ALLAN DE MIRANDA</td>
                                <td style="text-align: center;">(84)991151610</td>
                                <td style="text-align: center;">R.H.</td>
                                <td style="text-align: center;"><button type="button" class="btn btn-danger">Não
                                        atendido</button></td>
                                <td style="text-align: center;">00/00/0000 00:00</td>
                                <td style="text-align: center;"><span class="label label-warning">SIM</span></td>
                                <td style="text-align: center;"><a class="fa fa-print"></a></td>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align: center;">1</th>
                                <td style="text-align: center;">ALLAN DE MIRANDA</td>
                                <td style="text-align: center;">(84)991151610</td>
                                <td style="text-align: center;">R.H.</td>
                                <td style="text-align: center;"><button type="button" class="btn btn-warning"
                                        data-toggle="tooltip" data-placement="top" title="SECRETARIA"
                                        data-original-title="">Encaminhado</button></td>
                                <td style="text-align: center;">00/00/0000 00:00</td>
                                <td style="text-align: center;"><span class="label label-success">NÃO</span></td>
                                <td style="text-align: center;"><a class="fa fa-print"></a></td>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align: center;">1</th>
                                <td style="text-align: center;">ALLAN DE MIRANDA</td>
                                <td style="text-align: center;">(84)991151610</td>
                                <td style="text-align: center;">R.H.</td>
                                <td style="text-align: center;"><button type="button" class="btn btn-success">Em
                                        antendimento</button></td>
                                <td style="text-align: center;">00/00/0000 00:00</td>
                                <td style="text-align: center;"><span class="label label-success">NÃO</span></td>
                                <td style="text-align: center;"><a class="fa fa-print"></a></td>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align: center;">1</th>
                                <td style="text-align: center;">ALLAN DE MIRANDA</td>
                                <td style="text-align: center;">(84)991151610</td>
                                <td style="text-align: center;">R.H.</td>
                                <td style="text-align: center;"><button type="button"
                                        class="btn btn-info">Atendido</button></td>
                                <td style="text-align: center;">00/00/0000 00:00</td>
                                <td style="text-align: center;"><span class="label label-warning">SIM</span></td>
                                <td style="text-align: center;"><a class="fa fa-print"></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--footer-->
        <div class="footer">
            <p>&copy; 2018 Glance Design Dashboard. All Rights Reserved | Design by <a href="https://w3layouts.com/"
                    target="_blank">w3layouts</a></p>
        </div>
        <!--//footer-->
    </div>

    <!-- side nav js -->
    <script src='js/SidebarNav.min.js' type='text/javascript'></script>
    <script>
        $('.sidebar-menu').SidebarNav()
    </script>
    <!-- //side nav js -->

    <!-- Classie -->
    <!-- for toggle left push menu script -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function () {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <!-- //Classie -->
    <!-- //for toggle left push menu script -->

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
    <!-- //Bootstrap Core JavaScript -->

</body>

</html>