<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
    <!--left-fixed -navigation-->
    <aside class="sidebar-left">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <img src="images/itep-logo-mini.png" style="width: 30%; float: left;" />
                <h1 class="navbar-brand" href="/" style="margin-top: 5%;"> ITEP RN</h1>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="sidebar-menu">
                    <li class="header">NAVEGAÇÃO</li>
                    <li class="treeview">
                        <a href="/">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-envelope"></i> <span>Mailbox </span>
                            <i class="fa fa-angle-left pull-right"></i><small name="mailInbox" class="label label-primary1 pull-right">02</small></a>
                        <ul class="treeview-menu">
                            <li><a href=""><i class="fa fa-angle-right"></i> Mail Inbox </a></li>
                            <li><a href=""><i class="fa fa-angle-right"></i> Mail Outbox </a></li>
                            <li><a href=""><i class="fa fa-angle-right"></i> Enviar Mail </a></li>
                        </ul>
                    </li>
                    <?php
                    $sql_menu_configuracos_aba_pegarSetor = "SELECT `setor_admin` FROM `setores_tb` WHERE `setor_id`=(SELECT`usuario_setor_id` FROM `usuarios_tb` WHERE `usuario_id`='" . $_SESSION['usuarioID'] . "')";
                    $query_menu_configuracos_aba_pegarSetor = mysqli_query($_SG['link'], $sql_menu_configuracos_aba_pegarSetor);
                    $row_menu_configuracos_aba_pegarSetor = mysqli_fetch_assoc($query_menu_configuracos_aba_pegarSetor);
                    if ($row_menu_configuracos_aba_pegarSetor['setor_admin']) {
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-gears"></i>
                                <span>Configurações</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="listaUsuario.php"><i class="fa fa-angle-right"></i> Usuários </a></li>
                                <li><a href="adicionarUsuario.php"><i class="fa fa-angle-right"></i> Novo Usuário </a></li>
                                <li><a href="listaSetor.php"><i class="fa fa-angle-right"></i> Setores </a></li>
                                <li><a href="adicionarSetor.php"><i class="fa fa-angle-right"></i> Novo Setor </a></li>
                                <li><a href=""><i class="fa fa-angle-right"></i> Logs </a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </aside>
</div>
<!--left-fixed -navigation-->