<?php
$readGrade = new Read();
$readGrade->ExeRead("Wsotre_grades_de_opcoes", "WHERE id = :id", "id={$idGrade}");
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="field-1" class="control-label">Nome da Grade:</label>
            <div class="input-group">
                <input type="text" name="nomeGradeEdit" class="form-control" id="field-1" placeholder="Nome da categoria" autocomplete="off" value="<?= $readGrade->getResult()[0]['nome'] ?>">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-gold btn-icon icon-right j_EditGrade">
                        Alterar nome
                        <i class="entypo-check"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal-header" style="padding-top: 0;"><h4 class="modal-title"><i class="entypo-plus-circled"></i>Cadastrar variações da grade </h4></div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="field-1" class="control-label">Variação da grade:</label>
                <div class="input-group">
                    <input type="text" name="nomeVariacao" class="form-control" id="field-1" placeholder="Nome da categoria" autocomplete="off">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-blue btn-icon icon-right j_newVaricao">
                            Criar nova variação
                            <i class="entypo-check"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">

            <ul class="list-group j_boxVariacao">

                <?php
                $readGrade->ExeRead('Wstore_variacoes_grade_de_opcoes', "WHERE id_op = :id ORDER BY nome ASC", "id={$idGrade}");
                //Verifica se a loja tem categorias Cadastradas
                if (!$readGrade->getResult()):
                    ?>
                    <li class="list-group-item j_nenhumav" style="text-align: center">
                        Nenhuma variação cadastrada nessa grade
                    </li>
                    <?php
                else:
                    foreach ($readGrade->getResult() as $grade):
                        ?>
                        <li class="list-group-item" id="<?= $grade['id'] ?>" >
                            <?= $grade['nome'] ?>
                            <button type="button" class="btn btn-red tooltip-primary btn-xs j_deletVaria" id="<?= $grade['id'] ?>" data-toggle="tooltip" data-placement="top" data-original-title="Remover variacão" style="float: right"><i class="glyphicon glyphicon-trash" style="padding:1px 0 0 0;"></i></button>
                        </li>
                        <?php
                    endforeach;
                endif;
                ?>

            </ul>
        </div>
        
    </div>

    <input type="hidden" name="idGrade" value="<?= $idGrade ?>">