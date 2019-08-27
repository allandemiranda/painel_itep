<?php
$sql = "SELECT `usuario_id`, `usuario_nome`, `usuario_cargo` FROM `usuarios_tb` WHERE usuario_id='" . $_SESSION['usuarioID'] . "'";
$result = mysqli_query($_SG['link'], $sql);
if (mysqli_num_rows($result) == 1) {
    $_SG['topBar'] = mysqli_fetch_assoc($result);
} else {

    //expulsaVisitanteErro();
}
?>
<!-- header-starts -->
<div class="sticky-header header-section ">
    <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <div class="clearfix"> </div>
    </div>
    <div class="header-right">
        <div class="profile_details">
            <ul>
                <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile_img">
                            <div class="user-name">
                                <p>
                                    <?php
                                    $nome_usuario_slin = explode(" ", $_SG['topBar']['usuario_nome']);
                                    echo $nome_usuario_slin[0] . " " . end($nome_usuario_slin);
                                    ?>
                                </p>
                                <span>
                                    <?php
                                    echo $_SG['topBar']['usuario_cargo'];
                                    ?>
                                </span>
                            </div>
                            <i class="fa fa-angle-down lnr"></i>
                            <i class="fa fa-angle-up lnr"></i>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu drp-mnu">
                        <li> <a href="perfilUsuario.php"><i class="fa fa-suitcase"></i> Perfil</a> </li>
                        <li> <a href="index.php?status=logout"><i class="fa fa-sign-out"></i> Logout </a> </li>                        
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix" style="margin-bottom: 5%;"></div>
    </div>
    <div class="clearfix"> </div>
</div>
<!-- //header-ends -->