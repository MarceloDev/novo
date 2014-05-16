<?php
$idCat = 0;

if ($IdCategoria != ''):
    $idCat = $IdCategoria;
    $ReadCategoria = new Read();
    $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria = :code", "code={$IdCategoria}");
    if (!$ReadCategoria->getResult()):
        echo 6;
        die();
    else:
        foreach ($ReadCategoria->getResult() as $categoria)
            ;
    endif;
endif;

$temFilhos = '';
if ($IdCategoria != ''):
    $ReadCategoria = new Read();
    $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_pai = :code", "code={$IdCategoria}");
    if ($ReadCategoria->getResult()):
        $temFilhos = 'true';
    endif;
endif;
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="field-1" class="control-label">Nome:</label>
            <input type="text" name="nome" class="form-control" id="field-1" placeholder="Nome da categoria" autocomplete="off" <?php
            if ($IdCategoria != ''): echo "value=\"{$categoria['nome']}\"";
            endif;
            ?> >
        </div>
    </div>

</div>



<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Descição:</label>
            <textarea class="form-control" name="descricao" placeholder="Descrição da categoria." rows="5"><?php
                if ($IdCategoria != ''): echo "{$categoria['descricao_seo']}";
                endif;
                ?></textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Categoria Pai:</label>
            <?php if ($temFilhos == ''): ?>
                <select name="categoriaPai" class="j_select">
                    <option value="0">[ Raiz ]</option>

                    <optgroup label="Escolha a categoria pai abaixo">

                        <?php
                        $idLoja = $_SESSION['userlogin']['site_code'];
                        $ReadCategoria = new Read();
                        $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria != :idC AND id_loja = :id AND id_pai = :pai ORDER BY nome ASC", "idC={$idCat}&id={$idLoja}&pai=0");
                        //Verifica se a loja tem categorias Cadastradas
                        if ($ReadCategoria->getResult()) {
                            foreach ($ReadCategoria->getResult() as $cat) {
                                extract($cat);
                                echo "<option value=\"{$id_categoria}\"";
                                if ($IdCategoria != '' && $id_categoria == $categoria['id_pai']) {
                                    echo ' selected="selected" ';
                                }
                                echo "> -- {$nome} </option>";

                                $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria != :id AND id_pai = :pai ORDER BY nome ASC", "id={$idCat}&pai={$id_categoria}");
                                if ($ReadCategoria->getResult()) {
                                    foreach ($ReadCategoria->getResult() as $cat) {
                                        extract($cat);
                                        echo "<option value=\"{$id_categoria}\"";
                                        if ($IdCategoria != '' && $id_categoria == $categoria['id_pai']) {
                                            echo ' selected="selected" ';
                                        }
                                        echo "> -- -- {$nome}</option>";

                                        $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria != :id AND id_pai = :pai ORDER BY nome ASC", "id={$idCat}&pai={$id_categoria}");
                                        if ($ReadCategoria->getResult()) {
                                            foreach ($ReadCategoria->getResult() as $cat) {
                                                extract($cat);
                                                echo "<option value=\"{$id_categoria}\"";
                                                if ($IdCategoria != '' && $id_categoria == $categoria['id_pai']) {
                                                    echo ' selected="selected" ';
                                                }
                                                echo "> -- -- -- {$nome} </option>";

                                                $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria != :id AND id_pai = :pai ORDER BY nome ASC", "id={$idCat}&pai={$id_categoria}");
                                                if ($ReadCategoria->getResult()) {
                                                    foreach ($ReadCategoria->getResult() as $cat) {
                                                        extract($cat);
                                                        echo "<option value=\"{$id_categoria}\"";
                                                        if ($IdCategoria != '' && $id_categoria == $categoria['id_pai']) {
                                                            echo ' selected="selected" ';
                                                        }
                                                        echo "> -- -- -- -- {$nome}</option>";
                                                    }// fim foreach caterorias nivel 4
                                                }// verifica se tem categorias cadastradas
                                            }// fim foreach caterorias nivel 3
                                        }// verifica se tem categorias cadastradas
                                    }// fim foreach caterorias nivel 2
                                }// verifica se tem categorias cadastradas
                            }// fim foreach caterorias nivel 1
                        }// verifica se tem categorias cadastradas
                        ?>
                    </optgroup>
                </select>
                <?php
            else:
                echo "<input type=\"text\" class=\"form-control\" disabled value=\"Não pode ser Alterado\">";
                echo "<input type=\"hidden\" name=\"categoriaPai\" value=\"{$categoria['id_pai']}\">";
            endif;
            ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" style="float: left;width: 100%;">Categoria ativa?</label>
            <div class="radio radio-replace color-blue" style="float: left;margin: 12px;">
                <input type="radio" name="status" value="sim" <?php
                if ($IdCategoria != '' && $categoria['status'] == 1): echo 'checked';
                else: echo 'checked';
                endif;
                ?> >
                <label>Sim</label>
            </div>
            <div class="radio radio-replace color-blue" style="float: left;margin: 12px;">
                <input type="radio" name="status" value="nao" <?php
                if ($IdCategoria != '' && $categoria['status'] == 2): echo 'checked';
                endif;
                ?> >
                <label>Não</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        if ($temFilhos == ''):
            echo "<blockquote><p>Selecione uma categoria pai para organizar suas categorias hierarquicamente. Sempre que você seleciona uma categoria pai, sua categoria se tornará filha dela, ou seja, sempre será mostrada abaixo da categoria pai. Por exemplo, uma categoria pai pode ser Acessórios e as categorias filhas podem ser Cintos, Gravatas ou Meias.</p></blockquote>";
        else:
            echo "<blockquote><p>Esta categoria não pode ter sua CATEGORIA PAI editada,  pois esta possui categorias filhas. Sendo assim primeiramente certifeque-se que a categoria não possua filhas pois estas nao podem ser editadas ou excluidas do sistema!</p></blockquote>";
        endif;
        ?>
        
    </div>
</div>

<?php
if ($IdCategoria != ''):
    echo "<input type=\"hidden\" name=\"id\" value=\"{$IdCategoria}\">";
endif;
?>