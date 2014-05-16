$(function() {
    var Url = 'produtos/marcas';

    $('.j_novo').click(function() {
        var dados = 'acao=novo';

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
                myCallback('0', 'info', '', 'Carrengando...');
            },
            success: function(resposta) {
                var buttom = '<button type="submit" class="btn btn-success j_new"> Finalizar cadastro </button>';
                var content = resposta;
                myModal('novo', '<i class="entypo-plus-circled"></i> Cadastrar nova marca no sistema ', content, buttom, 'new');
                // Replaced File Input
                $("input.file2[type=file]").each(function(i, el) {
                    var $this = $(el), label = attrDefault($this, 'label', 'Browse');
                    $this.bootstrapFileInput(label);
                });
                replaceCheckboxes();
            },
            complete: function() {
                $('.toast-info').fadeOut('fast', function() {
                    $(this).remove();
                });
            }
        });
        return false;
    });

    $('tbody').on('click', '.j_editMac', function() {
        var id = $(this).attr('id');
        var dados = 'acao=edita&id=' + id;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
                myCallback('0', 'info', '', 'Carrengando...');
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 2) {
                    myCallback('', 'error', 'Erro ao ler', 'Não foi possivel ler informações dessa marca favor atualize a pagina!');
                } else {
                    var buttom = '<button type="submit" class="btn btn-success j_new"> Finalizar alterações </button>';
                    var content = resposta;
                    myModal('novo', '<i class="entypo-plus-circled"></i> Editar informações da grade no sistema ', content, buttom, 'editarMarca');
                    $("input.file2[type=file]").each(function(i, el) {
                        var $this = $(el), label = attrDefault($this, 'label', 'Browse');
                        $this.bootstrapFileInput(label);
                    });
                    replaceCheckboxes();
                }
            },
            complete: function() {
                $('.toast-info').fadeOut('fast', function() {
                    $(this).remove();
                });
            }
        });
        return false;
    });

    $('.modal').on("submit", "form[name=new]", function() {
        var form = $(this);
        var bar = form.find('.progress');
        var per = form.find('.progress-bar');
        $(this).ajaxSubmit({
            url: '_ajax/' + Url + '/controlador.php',
            data: {acao: 'new'},
            uploadProgress: function(evento, posicao, total, completo) {
                var porcento = completo + '%';
                bar.fadeIn("fast", function() {
                    per.width(porcento).text(porcento);
                });
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 3) {
                    myCallback('', 'error', 'Ocorreu um erro.', 'Tipo de logo não pode ser enviada, escolha do tipo: JPEG, PNG, ou GIF.');
                } else if (datas == 1) {
                    myCallback('', 'error', 'Ocorreu um erro.', 'Essa marca já foi cadastrada em nosso sistema verifique!');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Ocorreu um erro.', 'O campo NOME nao pode ficar em branco... Favor ferifique!');
                } else {
                                        alert(datas);

                    //$(location).attr('href', 'admin.php?exe=produtos/marcas/index');
                }
            },
            complete: function() {
                per.width('0%').text('0%');
            }
        });
        return false;
    });
    
    $('.modal').on("submit", "form[name=editarMarca]", function() {
        var form = $(this);
        var bar = form.find('.progress');
        var per = form.find('.progress-bar');
        $(this).ajaxSubmit({
            url: '_ajax/' + Url + '/controlador.php',
            data: {acao: 'update'},
            uploadProgress: function(evento, posicao, total, completo) {
                var porcento = completo + '%';
                bar.fadeIn("fast", function() {
                    per.width(porcento).text(porcento);
                });
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 3) {
                    myCallback('', 'error', 'Ocorreu um erro.', 'Tipo de logo não pode ser enviada, escolha do tipo: JPEG, PNG, ou GIF.');
                } else if (datas == 1) {
                    myCallback('', 'error', 'Ocorreu um erro.', 'Essa marca já foi cadastrada em nosso sistema verifique!');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Ocorreu um erro.', 'O campo NOME nao pode ficar em branco... Favor ferifique!');
                } else {
                    $(location).attr('href', 'admin.php?exe=produtos/marcas/index');
                }
            },
            complete: function() {
                per.width('0%').text('0%');
            }
        });
        return false;
    });
   

    $('tbody').on('click', '.j_desableCat', function() {
        myCallback('', 'warning', 'Atenção', 'Para remover uma categoria antes remova ou transfira suas categorias filhas.');
    });
    $('tbody').on('click', '.j_removeCat', function() {
        var id = $(this).attr('id');
        var dados = 'acao=deleta&id=' + id;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
                myCallback('0', 'info', '', 'Removendo...');
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    $(location).attr('href', 'admin.php?exe=produtos/categoria/index');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao ler categoria!', 'Por favor  de um f5. e tente novamente!');
                } else {
                    myCallback('', 'error', 'Ocorreu um erro!', 'Erro no sistema!');
                }
            },
            complete: function() {
                $('.toast-info').fadeOut('fast', function() {
                    $(this).remove();
                });
            }
        });
    });

});