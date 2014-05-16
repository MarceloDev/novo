$(function() {

    var Url = 'clientes';

    $('.modal').on("focusin", ".telefone", function() {
        $(".telefone").mask('(00) 0000-00000');

    });

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
                myModal('novo', '<i class="entypo-plus-circled"></i> Cadastrar novo cliente no sistema ', content, buttom, 'newCliente');
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
                    myCallback('', 'error', 'Campos em branco.', 'Favor preecher todos campos!');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Email invalido.', 'Favor informe um email verdadeiro!');
                } else if (datas == 3) {
                    myCallback('', 'error', 'Ocorreu um erro!.', 'Cliente já cadastrado, verifique!');
                } else if (datas == 4) {
                    myCallback('', 'error', 'Ocorreu um erro!.', 'Senhas não conferem! verifique.');
                } else if (datas == 5) {
                    myCallback('', 'error', 'Ocorreu um erro!.', 'A senha deve ter entre 6 e 12 caracteres.');
                } else {
                    $('table tbody .NullCadastro').fadeOut('fast');
                    $('table tbody').prepend(datas);
                    $('.modal').modal('hide');
                    myCallback('', 'success', 'Sucesso.', 'Cliente cadastrado com sucesso!');
                }
            },
            complete: function() {
                $('.j_load').fadeOut('fast');
            }
        });
        return false;
    });
    $('.modal').on("submit", "form[name=editaCliente]", function() {
        var id        = $("input[name=site_code]").val();
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
                    myCallback('', 'error', 'Campos em branco.', 'Favor preecher todos campos!');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Email invalido.', 'Favor informe um email verdadeiro!');
                } else if (datas == 3) {
                    myCallback('', 'error', 'Ocorreu um erro!.', 'Cliente já cadastrado, verifique!');
                } else if (datas == 4) {
                    myCallback('', 'error', 'Ocorreu um erro!.', 'Senhas não conferem! verifique.');
                } else if (datas == 5) {
                    myCallback('', 'error', 'Ocorreu um erro!.', 'A senha deve ter entre 6 e 12 caracteres.');
                } else {
                    $('table tbody #'+id).empty();
                    $('table tbody #'+id).html(datas);
                    $('.modal').modal('hide');
                    myCallback('', 'success', 'Sucesso.', 'Cliente editado com sucesso!');
                }
            },
            complete: function() {
                $('.j_load').fadeOut('fast');
            }
        });
        return false;
    });

    $('tbody').on('click', '.j_edit', function() {
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
                    myCallback('', 'error', 'Erro ao ler Cliente!', 'Por favor  de um f5. e tente novamente!');
                } else {
                    var buttom = '<button type="submit" class="btn btn-info j_editCliente"> Finalizar alterações  <i class="fa fa-spinner carregando j_load" style="margin-left:10px; font-size:16px; display:none;"></i> </button>'
                            + '<a href="#" style="float:left" class="btn btn-danger j_del" id="' + id + '">Deletar</a>';
                    var content = datas;
                    myModal('edit', '<i class="fa fa-cogs"></i> Editar dados do cliente', content, buttom, 'editaCliente');
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
    
    $('.modal').on('click', '.j_del', function() {
        var id = $(this).attr('id');
        var dados = 'acao=deleta&id=' + id;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    $("tbody #" + id).fadeOut('fast', function() {
                        $(this).remove();
                    });
                    myCallback('', 'success', 'Sucesso.', 'Cliente deletado com sucesso!');
                    $('.modal').modal('hide');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao ler Cliente!', 'Por favor  de um f5. e tente novamente!');
                } else {
                    myCallback('', 'error', 'Ocorreu um erro!', 'Erro no sistema!');
                }
            },
            complete: function() {

            }
        });
    });

});