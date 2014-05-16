<?php
$modulos = '';
if ($idCliente != ''):
    $ReadCliente = new Read();
    $ReadCliente->ExeRead('all_cadastro', 'WHERE site_code = :code', "code={$idCliente}");
    if (!$ReadCliente->getResult()):
        echo 6;
        die();
    else:
       foreach ($ReadCliente->getResult() as $clientes);
        extract($clientes);
        unset($site_code);
        unset($id);
        $ReadCliente->ExeRead('site_configuracao', 'WHERE site_code = :code', "code={$idCliente}");
        if ($ReadCliente->getResult()):
            $modulos = 'Sim';
            foreach ($ReadCliente->getResult() as $Modulos);
            extract($Modulos);
        endif;
    endif;
endif;
?>



<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="field-1" class="control-label">Responsavel</label>
            <input type="text" name="nome" class="form-control" id="field-1" placeholder="Nome responsavel" autocomplete="off" <?php if($idCliente != ''): echo "value=\"{$nome}\""; endif; ?> >
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="field-1" class="control-label">E-mail</label>
            <input type="text" name="email" class="form-control" id="field-1" placeholder="E-mail" autocomplete="off" <?php if($idCliente != ''): echo "value=\"{$email}\""; endif; ?> >
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="field-1" class="control-label">Senha</label>
            <input type="password" name="senha" class="form-control" id="field-1" autocomplete="off" <?php if($idCliente != ''): echo "value=\"{$code}\""; endif; ?> >
        </div></div><div class="col-md-6"><div class="form-group">
            <label for="field-1" class="control-label">Confirma senha</label>
            <input type="password" name="senhaC" class="form-control" id="field-1" autocomplete="off" <?php if($idCliente != ''): echo "value=\"{$code}\""; endif; ?> >
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="field-1" class="control-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" id="field-1" placeholder="Ex: Musico, Produtora, etc." autocomplete="off" <?php if($idCliente != ''): echo "value=\"{$tipo}\""; endif; ?> >
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="field-1" class="control-label">Telefone</label>
            <input type="text" name="fone" class="form-control telefone" placeholder="(00) 0000-0000" autocomplete="off" <?php if($idCliente != ''): echo "value=\"{$telefone}\""; endif; ?> >
        </div>
    </div>
</div>
<hr>
<div class="panel-title"><i class="entypo-tools"></i> Selecione as opções de gerenciamento do cliente</div>
<hr>
<div class="row">

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="slide" <?php if($modulos != '' && $slide == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Slider</label>
        </div>  
    </div>
    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="equipe" <?php if($modulos != '' && $equipe == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Equipe</label>
        </div>  
    </div>
    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="sobre" <?php if($modulos != '' && $sobre == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Sobre Nós</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="agenda" <?php if($modulos != '' && $agenda == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Agenda</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="video" <?php if($modulos != '' && $videos == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Video</label>
        </div>  
    </div>
    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="galeria" <?php if($modulos != '' && $galeria == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Galeria</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="noticias" <?php if($modulos != '' && $noticias == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Noticias</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="depoimentos" <?php if($modulos != '' && $depoimentos == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Depoimentos</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="vitrine" <?php if($modulos != '' && $vitrine == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Vitrine de produtos</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="clipping" <?php if($modulos != '' && $clipping == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerenciar Clipping</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="discografia" <?php if($modulos != '' && $discografia == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerênciar Discografia</label>
        </div>  
    </div>

    <div class="col-md-4"> 
        <div class="checkbox checkbox-replace color-blue">
            <input type="checkbox" name="newslatter" <?php if($modulos != '' && $newslatter == 'sim'): echo " checked=\"checked\""; endif; ?> >
            <label>Gerênciar Newslatter</label>
        </div>  
    </div>
    
    <?php if($idCliente != ''): echo "<input type=\"hidden\" name=\"site_code\" value=\"{$site_code}\">"; endif; ?> 
    

</div>