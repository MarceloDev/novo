<?php
if (!empty($_SESSION['categoria_delet'])):
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
                <strong><i class="entypo-bookmarks"></i> Gerênciar Grades de Opções</strong>
            </li>

            <a class="btn btn-success btn-sm j_novo" style="float: right; margin-top: -5px;">
                <i class="fa fa-plus" style="padding:3px 1px; margin-right: 5px"></i> Cadastrar nova grade
            </a>

            <input type="text" name="nomeGrade" class="form-control" id="field-1" placeholder="Nome da Grade" autocomplete="off" style="float: right; margin-top: -5px; margin-right: 10px; width: 200px;">

        </ol>

        <script src="_ajax/produtos/grades/controlador.js" type="text/javascript"></script>
        <style>td{vertical-align: middle !important;}.select2-drop{box-shadow: 1px 3px 6px #ccc !important;}
            .table-bordered > tbody > tr > td > b{ color: #0F0F0F;font-size: 13px;text-shadow: 2px 2px 2px #C2C2C2;}
        </style>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary panel-table">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3>Grade de opções para o produto</h3>
                            <span>Depois de criar as grades para um produto você definirá os valores, por exemplo: Amarelo, Azul e Verde para Cor; P, M e G para Tamanho; 110v e 220v para Tensão.</span>
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
                            $readGrade = new Read();
                            $readGrade->ExeRead('Wsotre_grades_de_opcoes', "WHERE id_loja = :id OR id_loja = :idA ORDER BY tipo DESC, nome ASC", "id={$idLoja}&idA=ADMIN");
                            //Verifica se a loja tem categorias Cadastradas
                            if (!$readGrade->getResult()):
                                echo '<tr class="NullCadastro"><td colspan="3"><h4 style="text-align: center; margin: 15px 0;">Nenhuma grade cadastrada no sistema</h4></td></tr>';
                            else:
                                foreach ($readGrade->getResult() as $grade):
                                    ?>
                                    <tr id="<?= $grade['id'] ?>">
                                        <td>
                                            <i class="entypo-bookmarks" style="font-size: 20px; margin:0 5px 0 0; float: left"></i>
                                            <b><?= $grade['nome'] ?> <span style="font-weight: normal"><?php if($grade['descricao'] != ''){ echo " - ".$grade['descricao']; } ?></span></b> 
                                            <?php
                                            $ReadVaria = clone $readGrade;
                                            $ReadVaria->ExeRead("Wstore_variacoes_grade_de_opcoes", "WHERE id_op = :id  ORDER BY nome ASC", "id={$grade['id']}");
                                            if ($ReadVaria->getResult()):
                                                $conta = $ReadVaria->getRowCount() - 1;
                                                echo '<p style="margin: 0 0 0 40px;">';
                                                foreach ($ReadVaria->getResult() as $key => $varia):
                                                    if ($key != $conta):
                                                        echo $varia['nome'] . ', ';
                                                    else:
                                                        echo $varia['nome'];
                                                    endif;
                                                endforeach;
                                                echo '</p>';
                                            else:
                                                echo '<p style="margin: 0 0 0 40px;">Nenhuma variação cadastrada nessa grade</p>';
                                            endif;
                                            ?>
                                        </td><td style="width: 200px;">
                                            <?php
                                            $ReadProd = clone $readGrade;
                                            $ReadProd->ExeRead("Wstore_produtos_com_opcoes", "WHERE id_grade = :id  ORDER BY nome ASC", "id={$grade['id']}");
                                            if ($ReadProd->getResult()):
                                                $qtdeP = $ReadProd->getRowCount();
                                            else:
                                                $qtdeP = 0;
                                            endif;
                                            ?>
                                            <a class="btn btn-green btn-xs"><?= $qtdeP ?></a>
                                            Produtos Vinculados
                                        </td>
                                        <td>
                                            <?php if ($grade['tipo'] == '2') { ?>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-blue j_editCat tooltip-primary" id="<?= $grade['id'] ?>" data-toggle="tooltip" data-placement="top" data-original-title="Editar Categoria"><i class="fa fa-pencil" style="padding:3px 1px;"></i></button>
                                                    <?php if ($qtdeP == 0): ?>
                                                    <button type="button" class="btn btn-red tooltip-primary j_removeGrad" id="<?= $grade['id'] ?>"  data-toggle="tooltip" data-placement="top" data-original-title="Remover categoria"><i class="glyphicon glyphicon-trash" style="padding:1px 0 0 0;"></i></button>
                                                    <?php else: ?>
                                                    <button type="button" class="btn tooltip-primary j_pordutTu " data-toggle="tooltip" data-placement="top" data-original-title="Desabilitado"><i class="glyphicon glyphicon-trash" style="padding:1px 0 0 0;"></i></button>
                                                    <?php endif; ?>                                                
                                                </div>
                                            <?php } else { ?>
                                                <div class="btn-group">
                                                    <button type="button" class="btn tooltip-primary j_nativa" data-toggle="tooltip" data-placement="top" data-original-title="Desabilitado"><i class="fa fa-pencil" style="padding:3px 1px;"></i></button>
                                                    <button type="button" class="btn tooltip-primary j_nativa" data-toggle="tooltip" data-placement="top" data-original-title="Desabilitado"><i class="glyphicon glyphicon-trash" style="padding:1px 0 0 0;"></i></button>
                                                </div>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
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

