<div class="row">
    <div class="col-lg-12">
        <ul class="user-info pull-left pull-none-xsm">
            <!-- Profile Info -->
            <li class="profile-info dropdown">
                <!-- add class "pull-right" if you want to place this from right -->
                <a href="#"> <img src="<?=  Check::gravatar($_SESSION['userlogin']['email'])?>" class="img-circle" height="44" width="44"><?=$_SESSION['userlogin']['nome']?> ( <?=$_SESSION['userlogin']['funcao']?>  )</a>
            </li>
        </ul>
        <ul class="list-inline links-list pull-right">
            <li>
                <a href="#"> <i class="fa fa-gears"></i> Editar Perfil </a>
            </li>
            <li class="sep"></li>
            <li>
                <a href="admin.php?logoff=true"> <i class="entypo-lock"></i> Sair do painel </a>
            </li>
        </ul>
    </div>
</div>