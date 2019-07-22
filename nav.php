<!--header start here-->
<div class="header-main">
    <div class="header-left">
        <div class="logo-name">
            <a href="index.html">
                <h1>Necropapiloscopia</h1>
                <!--<img id="logo" src="" alt="Logo"/>-->
            </a>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="header-right">
        <!--search-box--
        <div class="search-box">
            <form>
                <input type="text" placeholder="Busca..." required="">
                <input type="submit" value="">
            </form>
        </div>
        --//end-search-box-->
        <div class="profile_details">
            <ul>
                <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile_img">
                            <div class="user-name">
                                <p><?php echo $_SESSION['usuarioNome']; ?></p>
                                <span><?php echo $_SESSION['usuarioMatricula']; ?></span>
                            </div>
                            <i class="fa fa-angle-down lnr"></i>
                            <i class="fa fa-angle-up lnr"></i>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu drp-mnu">
                        <li> <a href="perfilUsuario.php"><i class="fa fa-user"></i> Perfil</a> </li>
                        <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="clearfix"> </div>
</div>
<!--heder end here-->
<!-- script-for sticky-nav -->
<script>
    $(document).ready(function() {
        var navoffeset = $(".header-main").offset().top;
        $(window).scroll(function() {
            var scrollpos = $(window).scrollTop();
            if (scrollpos >= navoffeset) {
                $(".header-main").addClass("fixed");
            } else {
                $(".header-main").removeClass("fixed");
            }
        });

    });
</script>
<!-- /script-for sticky-nav -->