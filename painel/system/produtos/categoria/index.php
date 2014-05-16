<?php
if (!empty($_SESSION['categoria_create'])):
    ?>
    <script type="text/javascript">
        $(function($) {
            myCallback('', 'success', 'Sucesso!', 'Categoria cadastrada com sucesso no sistema!');
        });
    </script>
    <?php
    unset($_SESSION['categoria_create']);
elseif (!empty($_SESSION['categoria_update'])):
    ?>
    <script type="text/javascript">
        $(function($) {
            myCallback('', 'success', 'Sucesso!', 'Categoria atualizada com sucesso no sistema!');
        });
    </script>
    <?php
    unset($_SESSION['categoria_update']);
elseif (!empty($_SESSION['categoria_delet'])):
    ?>
    <script type="text/javascript">
        $(function($) {
            myCallback('', 'success', 'Sucesso!', 'Categoria removida com sucesso do sistema!');
        });
    </script>
    <?php
    unset($_SESSION['categoria_delet']);    
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
                <strong><i class="entypo-flow-tree"></i>Gerênciar Categorias</strong>
            </li>

            <a class="btn btn-success btn-sm j_novo" style="float: right; margin-top: -5px;">
                <i class="fa fa-plus" style="padding:3px 1px; margin-right: 5px"></i> Cadastrar nova categoria
            </a>

        </ol>

        <script src="_ajax/produtos/categorias/controlador.js" type="text/javascript"></script>
        <style>td{vertical-align: middle !important;}.select2-drop{box-shadow: 1px 3px 6px #ccc !important;}
        .table-bordered > tbody > tr > td > b{ color: #0F0F0F;font-size: 13px;text-shadow: 2px 2px 2px #C2C2C2;}
        </style>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary panel-table">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3>Categorias da loja</h3>
                            <span>Gerênciamento de categorias </span>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                <th style="width: 94px; text-align: center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $idLoja = $_SESSION['userlogin']['site_code'];
                            $ReadCategoria = new Read();
                            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_loja = :id AND id_pai = :pai ORDER BY nome ASC", "id={$idLoja}&pai=0");
                            //Verifica se a loja tem categorias Cadastradas
                            if (!$ReadCategoria->getResult()) {
                                echo '<tr class="NullCadastro"><td colspan="3"><h4 style="text-align: center; margin: 15px 0;">Nenhuma categoria cadastrada no sistema</h4></td></tr>';
                            } else {
                                foreach ($ReadCategoria->getResult() as $cat) {
                                    extract($cat);
                                    echo "<tr id=\"{$id_categoria}\">
                                            <td>
                                                <i class=\"entypo-flow-tree\" style=\"font-size: 16px; margin:0 5px 0 0;\"></i>
                                                <b>{$nome}</b>
                                            </td>";
                                    if ($status == '1'):
                                        echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-green btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Ativa
                                             </td>";
                                    else:
                                        echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-red btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Inativa
                                              </td>";
                                    endif;


                                    $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_pai = :pai ORDER BY nome ASC", "pai={$id_categoria}");
                                    if (!$ReadCategoria->getResult()) {

                                        echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn btn-red tooltip-primary j_removeCat\"  id=\"{$id_categoria}\"   j_idPai=\"{$id_pai}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Remover categoria\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                    } else {
                                        echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn tooltip-primary j_desableCat\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Desabilitado\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                        foreach ($ReadCategoria->getResult() as $cat) {
                                            extract($cat);
                                            echo "<tr id=\"{$id_categoria}\">
                                            <td>
                                                <i class=\"entypo-flow-line\" style=\"font-size: 16px; margin:0 5px 0 30px;\"></i>
                                                <b>{$nome}</b>
                                            </td>";
                                            if ($status == '1'):
                                                echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-green btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Ativa
                                             </td>";
                                            else:
                                                echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-red btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Inativa
                                              </td>";
                                            endif;


                                            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_pai = :pai ORDER BY nome ASC", "pai={$id_categoria}");
                                            if (!$ReadCategoria->getResult()) {

                                                echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn btn-red tooltip-primary j_removeCat\"  id=\"{$id_categoria}\"   j_idPai=\"{$id_pai}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Remover categoria\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                            } else {
                                                echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn tooltip-primary j_desableCat\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Desabilitado\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                                foreach ($ReadCategoria->getResult() as $cat) {
                                                    extract($cat);
                                                    echo "<tr id=\"{$id_categoria}\">
                                            <td>
                                                <i class=\"entypo-flow-parallel\" style=\"font-size: 16px; margin:0 5px 0 60px;\"></i>
                                                <b>{$nome}</b>
                                            </td>";
                                                    if ($status == '1'):
                                                        echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-green btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Ativa
                                             </td>";
                                                    else:
                                                        echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-red btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Inativa
                                              </td>";
                                                    endif;


                                                    $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_pai = :pai ORDER BY nome ASC", "pai={$id_categoria}");
                                                    if (!$ReadCategoria->getResult()) {

                                                        echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn btn-red tooltip-primary j_removeCat\"  id=\"{$id_categoria}\"   j_idPai=\"{$id_pai}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Remover categoria\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                                    } else {
                                                        echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn tooltip-primary j_desableCat\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Desabilitado\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                                        foreach ($ReadCategoria->getResult() as $cat) {
                                                            extract($cat);
                                                            echo "<tr id=\"{$id_categoria}\">
                                            <td>
                                                <i class=\"entypo-flow-branch\" style=\"font-size: 16px; margin:0 5px 0 90px;\"></i>
                                                <b>{$nome}</b>
                                            </td>";
                                                            if ($status == '1'):
                                                                echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-green btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Ativa
                                             </td>";
                                                            else:
                                                                echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-red btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Inativa
                                              </td>";
                                                            endif;


                                                            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_pai = :pai ORDER BY nome ASC", "pai={$id_categoria}");
                                                            if (!$ReadCategoria->getResult()) {

                                                                echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn btn-red tooltip-primary j_removeCat\"  id=\"{$id_categoria}\"   j_idPai=\"{$id_pai}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Remover categoria\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                                            } else {
                                                                echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn tooltip-primary j_desableCat\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Desabilitado\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                                                foreach ($ReadCategoria->getResult() as $cat) {
                                                                    extract($cat);
                                                                    echo "<tr id=\"{$id_categoria}\">
                                            <td>
                                                <i class=\"entypo-flow-cascade\" style=\"font-size: 16px; margin:0 5px 0 120px;\"></i>
                                                <b>{$nome}</b>
                                            </td>";
                                                                    if ($status == '1'):
                                                                        echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-green btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Ativa
                                             </td>";
                                                                    else:
                                                                        echo "<td style=\"width: 120px;\">
                                                <a class=\"btn btn-red btn-xs\"><i class=\"fa fa-power-off\" style=\"padding:3px 1px;\"></i></a>
                                                Inativa
                                              </td>";
                                                                    endif;
                                                                    echo "<td>
                                            <div class=\"btn-group\">
                                                <button type=\"button\" class=\"btn btn-blue j_editCat tooltip-primary\" id=\"{$id_categoria}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar Categoria\"><i class=\"fa fa-pencil\" style=\"padding:3px 1px;\"></i></button>
                                                <button type=\"button\" class=\"btn btn-red tooltip-primary j_removeCat\"  id=\"{$id_categoria}\"   j_idPai=\"{$id_pai}\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Remover categoria\"><i class=\"glyphicon glyphicon-trash\" style=\"padding:1px 0 0 0;\"></i></button>
                                            </div>
                                        </td>
                                    </tr>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
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

<div id="mensagemAlert" class="toast-top-right">

</div>	

<!-- Modal 1 (Basic)-->
<div class="modal fade" data-backdrop="static">

</div>

<script type="text/javascript" src="_assets/js/jquery.mask.min.js"></script>   	
<script type="text/javascript" src="_assets/js/jquery.form.js"></script>

<link rel="stylesheet" href="_assets/js/select2/select2-bootstrap.css" >
<link rel="stylesheet" href="_assets/js/select2/select2.css">
<link rel="stylesheet" href="_assets/js/selectboxit/jquery.selectBoxIt.css">

<script src="_assets/js/select2/select2.min.js"></script>

