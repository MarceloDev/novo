<?php
if (!empty($_SESSION['marca_create'])):
    ?>
    <script type="text/javascript">
        $(function($) {
            myCallback('', 'success', 'Sucesso!', 'Marca cadastrada com sucesso no sistema!');
        });
    </script>
    <?php
    unset($_SESSION['marca_create']);
endif;
?>

<div class="page-container">

    <?php include '_inc/menu.php'; ?>

    <div class="main-content">

        <?php include '_inc/topo.php'; ?>

        <hr />

        <ol class="breadcrumb bc-3">
            <li>
                <a href="admin.php?exe=painel/home"><i class="entypo-home"></i>Dashboard home</a>
            </li>		
            <li>
                <a href="admin.php?exe=produtos/index"><i class="glyphicon glyphicon-shopping-cart"></i>Produtos</a>
            </li>		
            <li class="active">
                <strong><i class="entypo-flag"></i>Gerênciar Marcas</strong>
            </li>

            <a class="btn btn-success btn-sm j_novo" style="float: right; margin-top: -5px;">
                <i class="fa fa-plus" style="padding:3px 1px; margin-right: 5px"></i> Cadastrar nova marca
            </a>

        </ol>

        <script src="_ajax/produtos/marcas/controlador.js" type="text/javascript"></script>
        <style>
            td{vertical-align: middle !important;}
            .select2-drop{box-shadow: 1px 3px 6px #ccc !important;}
            .table-bordered > tbody > tr > td > b{ color: #0F0F0F;font-size: 13px;text-shadow: 2px 2px 2px #C2C2C2;}
        </style>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary panel-table">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3>Marcas produtos</h3>
                            <span>Gerênciamento de marcas de produos</span>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 200px;"></th>
                                <th style="width: 120px;"></th>
                                <th style="width: 10px;"></th>
                                <th style="width: 94px; text-align: center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $idLoja = $_SESSION['userlogin']['site_code'];
                            $ReadMarca = new Read();
                            $ReadMarca->ExeRead('Wstore_marcas', "WHERE id_loja = :id ORDER BY nome ASC", "id={$idLoja}");
                            //Verifica se a loja tem categorias Cadastradas
                            if (!$ReadMarca->getResult()) {
                                echo '<tr class="NullCadastro"><td colspan="3"><h4 style="text-align: center; margin: 15px 0;">Nenhuma marca cadastrada no sistema</h4></td></tr>';
                            } else {
                                foreach ($ReadMarca->getResult() as $marca) {
                                    extract($marca);
                                    //nome da marca
                                    echo "<tr id=\"{$id}\">
                                            <td>
                                                <i class=\"entypo-flag\" style=\"font-size: 16px; margin:0 5px 0 0;\"></i>
                                                <b>{$nome}</b>
                                            </td>";
                                    //produtos vinculados com a marca
                                    echo '<td>';
                                    $ReadProd = clone $ReadMarca;
                                    $ReadProd->ExeRead("Wstore_produtos", "WHERE marca = :id", "id={$id}");
                                    if ($ReadProd->getResult()):
                                        $qtdeP = $ReadProd->getRowCount();
                                    else:
                                        $qtdeP = 0;
                                    endif;
                                    echo'<a class="btn btn-green btn-xs">' . $qtdeP . '</a>
                                          Produtos Vinculados
                                     </td>';
                                    // status da marca
                                    if ($status == 'sim'):
                                        echo "<td>
                                                <a class=\"btn btn-green btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Ativa
                                             </td>";
                                    else:
                                        echo "<td>
                                                <a class=\"btn btn-red btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Inativa
                                              </td>";
                                    endif;
                                    // destaque do produto
                                    if ($destaque == 'sim'):
                                        echo "<td> 
                                                <a class=\"btn btn-gold\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Marca em Destaque\"><i class=\"entypo-star\" style=\"padding:3px 0;\"></i></a>
                                            </td>";
                                    else:
                                        echo "<td> 
                                                <a class=\"btn btn-primary\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Marca fora de Destaque\"><i class=\"entypo-flag\" style=\"padding:3px 0;\"></i></a>
                                            </td>";
                                    endif;
                                    // ações da marca
                                    echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editMac tooltip-primary\" id=\"{$id}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Marca\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn btn-red j_removeMac tooltip-primary\"  id=\"{$id}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Remover Marca\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- Footer -->
        <footer class="main">
            &copy; 2014 <strong>Painel Geek </strong> developed by: <a href="#">Marcelo Martins </a> 
        </footer>	
    </div>
</div>

<div id="mensagemAlert" class="toast-top-right ">

</div>	

<!-- Modal 1 (Basic)-->
<div class="modal fade" data-backdrop="static">

</div>

<script type="text/javascript" src="_assets/js/jquery.form.js"></script>
<script type="text/javascript" src="_assets/js/fileinput.js"></script>



