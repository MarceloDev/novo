
<div class="page-container">

    <?php include '_inc/menu.php'; ?>

    <div class="main-content">

        <?php include '_inc/topo.php'; ?>

        <hr />

        <ol class="breadcrumb bc-3">
            <li>
                <a href="admin.php?exe=painel/home"><i class="entypo-home"></i>Dashboard home</a>
            </li>						
            <li class="active">
                <strong>Clientes</strong>
            </li>

            <a class="btn btn-success btn-sm btn-icon icon-left j_novo" style="float: right;margin-top: -5px;">
                <i class="entypo-archive"></i>Cadastrar novo
            </a>

        </ol>

        <script src="_ajax/clientes/controlador.js" type="text/javascript"></script>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary panel-table">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3>Clientes Agência Geek</h3>
                            <span>Gerênciamento de todos clientes que utilizam o painel Geek</span>
                        </div>


                    </div>
                    <table class="table table-bordered table-responsive">


                        <thead>
                            <tr>
                                <th style="width: 80px;">Site Code</th>
                                <th>Integração</th>
                                <th>Responsavel</th>
                                <th>Tel. Contato</th>
                                <th style="width: 76px;">Ação</th>
                            </tr>
                        </thead>

                        <tbody style="background:#fff !important;">

                            <?php
                            $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
                            $Pager = new Pager('admin.php?exe=clientes/index&page=');
                            $Pager->ExePager($getPage, 10);

                            $read = new Read();
                            $read->ExeRead('all_cadastro', "WHERE site_code != :code ORDER BY id DESC LIMIT :limit OFFSET :offset", "code=ADMIN&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                            if (!$read->getResult()):
                                $Pager->ReturnPage();
                                echo '<tr class="NullCadastro"><td colspan="5"><h4 style="text-align: center; margin: 15px 0;">Nenhum cliente cadastrado no sistema</h4></td></tr>';
                            else:

                                foreach ($read->getResult() as $clientes):
                                    extract($clientes);
                                    ?>
                                    <tr id="<?= $site_code ?>">
                                        <td><?= $site_code ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($data)); ?> Hs</td>
                                        <td><?= $nome ?></td>
                                        <td><?= $telefone ?></td>
                                        <td><a href="#" class="btn btn-blue btn-sm btn-icon icon-left j_edit" id="<?= $site_code ?>">
                                                <i class="entypo-pencil"></i>Editar
                                            </a></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>

                        </tbody>
                    </table>

                </div>

                <?php
                $Pager->ExePaginator("all_cadastro");
                echo $Pager->getPaginator();
                ?>

            </div>

        </div><!-- Footer -->
        <footer class="main">
            &copy; 2014 <strong>Painel Geek </strong> developed by: <a href="#">Marcelo Martins </a> 
        </footer>	
    </div>
</div>

<div id="mensagemAlert" class="toast-top-right">

</div>	

<!-- Modal 1 (Basic)-->
<div class="modal fade" data-backdrop="static">

</div>

<script type="text/javascript" src="_assets/js/jquery.mask.min.js"></script>   	
<script type="text/javascript" src="_assets/js/jquery.form.js"></script>
