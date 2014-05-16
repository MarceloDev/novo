<?php
if ($marca):
    $ReadMarca = new Read();
    $ReadMarca->ExeRead("Wstore_marcas", "WHERE id = :id ", "id={$marca}");
    if ($ReadMarca->getResult()):
        foreach ($ReadMarca->getResult() as $marca)
            ;
        extract($marca);
    endif;
endif;
?>

<blockquote><p>As marcas de produtos servem para organização dos produtos de sua loja assim como as categorias. Marcando como "Marca em Destaque" essa marca estara disponivel no carrosel de marcas no topo ou rodape de sua loja dependendo da estrutura de seu layout</p></blockquote>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="field-1" class="control-label">Nome da marca :</label>
            <input type="text" name="nome" class="form-control" autocomplete="off" value="<?php if ($marca != ''): echo $nome;
endif;
?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="float: left;width: 100%;">Marca ativa?</label>
            <div class="radio radio-replace color-blue" style="float: left;margin: 12px;">
                <input type="radio" name="status" value="sim" 
                <?php
                if ($marca != ''):
                    if ($status = 'sim'):
                        echo 'checked';
                    endif;
                else:
                    echo 'checked';
                endif;
                ?>>
                <label>Sim</label>
            </div>
            <div class="radio radio-replace color-blue" style="float: left;margin: 12px;">
                <input type="radio" name="status" value="nao"
                <?php
                if ($marca != ''):
                    if ($status = 'nao'):
                        echo 'checked';
                    endif;
                endif;
                ?>>
                <label>Não</label>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="float: left;width: 100%;">Marca em Destaque?</label>
            <div class="radio radio-replace color-blue" style="float: left;margin: 12px;">
                <input type="radio" name="destaque" value="sim"  
                <?php
                if ($marca != ''):
                    if ($destaque = 'sim'):
                        echo 'checked';
                    endif;
                else:
                    echo 'checked';
                endif;
                ?>>

                <label>Sim</label>
            </div>
            <div class="radio radio-replace color-blue" style="float: left;margin: 12px;">
                <input type="radio" name="destaque" value="nao" 
                <?php
                if ($marca != ''):
                    if ($destaque = 'nao'):
                        echo 'checked';
                    endif;
                endif;
                ?>>
                <label>Não</label>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label">Descição ( opcional importante para SEO da página ):</label>
            <textarea class="form-control" name="descricao" placeholder="Descrição da marca." rows="5"><?php if ($marca != ''): echo $descricao;
                endif;
                ?></textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <input type="file" name="logoMarcas" class="form-control file2 inline btn btn-gold" data-label="<i class='glyphicon glyphicon-file'></i> Escolher logo da marca" />
            <?php
            if ($marca != ''):
                if ($logo != ''):
                    echo ' <span class="file-input-name">';
                    $nomn2 = explode('/', $logo);
                    echo $nomn2[3];
                    echo '</span>';
                endif;
            endif;
            ?>
        </div>
    </div>
</div>

<div class="row" style="margin: 0">
    <div class="progress progress-striped active" style="height: 31px">
        <div class="progress-bar progress-bar-success" style="width: 0%; padding: 7px inherit;">
        </div>
    </div>

</div>