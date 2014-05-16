<div class="sidebar-menu">
    <header class="logo-env">

        <!-- logo -->
        <div class="logo">
            <a href="index.html">
                <img src="http://localhost/geek/img/logo.png" width="120" alt="" />
            </a>
        </div>
        <!-- logo collapse icon -->

        <div class="sidebar-collapse">
            <a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                <i class="entypo-menu"></i>
            </a>
        </div>

    </header>
    <ul id="main-menu" class="" style="">
        <li class="root-level"></li>
        <li>
            <a href="#"><i class="entypo-home"></i><span>Dashboard home</span></a>
        </li>
        <li>
            <a href="#">
                <i class="glyphicon glyphicon-shopping-cart"></i>
                <span>Gerênciar produtos</span>
            </a>
            <ul>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-share"></i>
                        <span>Cadastrar Produto</span>
                    </a>
                    <ul>
                        <li>
                            <a href="admin.php?exe=produtos/novo/simples">
                                <span>Criar produto Simples</span>
                            </a>
                        </li>
                        <li>
                            <a href="admin.php?exe=produtos/novo/opcoes">
                                <span>Criar produto com opções</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="admin.php?exe=produtos/index">
                        <i class="glyphicon glyphicon-edit"></i>
                        <span>Listar produtos cadastrados</span>
                    </a>
                </li>
                <li>
                    <a href="admin.php?exe=produtos/categoria/index">
                        <i class="entypo-flow-tree"></i>
                        <span>Gerênciar categorias</span>
                    </a>
                </li>
                <li>
                    <a href="admin.php?exe=produtos/grades/index">
                        <i class="entypo-bookmarks"></i>
                        <span>Gerênciar Grade de Opções</span>
                    </a>
                </li>
                <li>
                    <a href="admin.php?exe=produtos/marcas/index">
                        <i class="entypo-flag"></i>
                        <span>Gerenciar Marcas</span>
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a href="#">
                <i class="entypo-chart-line"></i>
                <span>Contolador de fluxo</span>
            </a>
            <ul>
                <li>
                    <a href="#">
                        <i class="entypo-users"></i>
                        <span>Clientes cadastrados</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="entypo-publish"></i>
                        <span>Pedidos da loja</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>