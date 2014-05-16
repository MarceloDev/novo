$(function() {
    var Url = 'produtos/categorias';

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
                var buttom = '<button type="submit" class="btn btn-success j_new"> Finalizar cadastro  <i class="fa fa-spinner carregando j_load" style="margin-left:10px; font-size:16px; display:none;"></i> </button>';
                var content = resposta;
                myModal('novo', '<i class="entypo-plus-circled"></i> Cadastrar nova categoria no sistema ', content, buttom, 'newCliente');
                replaceCheckboxes();
                $(".j_select").select2();
            },
            complete: function() {
                $('.toast-info').fadeOut('fast', function() {
                    $(this).remove();
                });
            }
        });
        return false;
    });

    //TIRA A AÇÃO DE SUBMIT DOS FURMULARIOS
    $('form').submit(function() {
        return false;
    });

    $('.modal').on("submit", "form[name=newCliente]", function() {

        var forma = $(this);
        var dados = $(this).serialize() + '&acao=new';
        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
                $('.j_load').fadeIn('fast');
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    myCallback('', 'warning', 'Campos em branco.', 'Favor preecher o nome da categoria.');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao cadastrar.', 'Categoria já cadastrada em nosso sistema!');
                } else if (datas == 3) {
                    $(location).attr('href', 'admin.php?exe=produtos/categoria/index');
                } else {
                    myCallback('', 'error', 'Erro no sistema.', 'Favor entre em contato com ADMIN');
                }
            },
            complete: function() {
                $('.j_load').fadeOut('fast');
            }
        });
        return false;
    });
    $('.modal').on("submit", "form[name=editaCategoria]", function() {
        var forma = $(this);
        var dados = $(this).serialize() + '&acao=update';
        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
                $('.j_load').fadeIn('fast');
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    myCallback('', 'warning', 'Campos em branco.', 'Favor preecher o nome da categoria.');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao cadastrar.', 'Categoria já cadastrada em nosso sistema!');
                } else if (datas == 3) {
                    $(location).attr('href', 'admin.php?exe=produtos/categoria/index');
                } else {
                    myCallback('', 'error', 'Erro no sistema.', 'Favor entre em contato com ADMIN' + datas);
                }
            },
            complete: function() {
                $('.j_load').fadeOut('fast');
            }
        });
        return false;
    });

    $('tbody').on('click', '.j_editCat', function() {
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
                if (datas == 6) {
                    myCallback('', 'error', 'Erro ao ler categoria!', 'Por favor  de um f5. e tente novamente!');
                } else {
                    var buttom = '<button type="submit" class="btn btn-info j_editCliente"> Finalizar alterações  <i class="fa fa-spinner carregando j_load" style="margin-left:10px; font-size:16px; display:none;"></i> </button>';
                    var content = datas;
                    myModal('edit', '<i class="fa fa-cogs"></i> Editar categoria no sistema ', content, buttom, 'editaCategoria');
                    replaceCheckboxes();
                    $(".j_select").select2();

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