<!--slider menu-->
<div class="sidebar-menu">
    <div class="logo"> 
        <a href="#" class="sidebar-icon"> 
            <span class="fa fa-bars"></span> 
        </a> 
        <a href="#">
            <span id="logo"></span>
            <!--<img id="logo" src="" alt="Logo"/>-->
        </a> 
    </div>
    <div class="menu">
        <ul id="menu">
            <li id="menu-home"><a href="/"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
            </li>
            <li><a href="#"><i class="fa fa-user"></i><span>Registros</span><span class="fa fa-angle-right" style="float: right"></span></a>
                <ul>
                    <li><a href="novoRegistro.php">Novo</a></li>
                    <li><a href="listaDocumentos.php">Lista</a></li>
                    <li><a href="pesquisaDocumentos.php">Pesquisar</a></li>
                    <!--li><a href="#">Pesquisar</a></li-->
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-cogs"></i><span>Usuários</span><span class="fa fa-angle-right" style="float: right"></span></a>
                <ul>
                    <li><a href="novoUsuario.php">Novo</a></li>
                    <li><a href="listaUsuarios.php">Lista</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script>
    var toggle = true;

    $(".sidebar-icon").click(function() {
        if (toggle) {
            $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
            $("#menu span").css({
                "position": "absolute"
            });
        } if(!toggle) {
            $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
            setTimeout(function() {
                $("#menu span").css({
                    "position": "relative"
                });
            }, 400);
        }
        toggle = !toggle;
    });
</script>