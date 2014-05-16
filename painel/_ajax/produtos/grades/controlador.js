$(function() {
    var Url = 'produtos/grades';

    $('.modal').on('click', '.j_close', function() {
        $(location).attr('href', 'admin.php?exe=produtos/grades/index');
    });

    $('.j_nativa').click(function() {
        myCallback('', 'warning', 'Atenção', 'Não é possivel remover ou editar Grades NATIVAS do sistema.');
    });
    $('.j_pordutTu').click(function() {
        myCallback('', 'warning', 'Atenção', 'Esta GRADE não pode ser REMOVIDA pois existem produtos cadastrados na mesma!');
    });


    $('.j_novo').click(function() {

        var grade = $("input[name=nomeGrade]").val();
        var dados = 'acao=novo&nomeGrade=' + grade;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    myCallback('', 'warning', 'Informar nome.', 'Favor preecher o nome da grade.');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao cadastrar', 'Não e possivel cadastrar essa grade a mesma já existe. Verifique!');
                } else {
                    var buttom = '<button type="button" class="btn btn-success j_close" data-dismiss="modal"> Finalizar </button>';
                    var content = resposta;
                    myModal('novo', '<i class="entypo-plus-circled"></i> Cadastrar nova grade no sistema ', content, buttom, 'newCliente');
                }
            },
            complete: function() {
            }
        });
        return false;
    });

    $('.j_editCat').click(function() {

        var id = $(this).attr('id');
        var dados = 'acao=edita&id=' + id;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    myCallback('', 'warning', 'Informar nome.', 'Favor preecher o nome da grade.');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao ler', 'Não foi possivel ler informações dessa categoria favor atualize a pagina!');
                } else {
                    var buttom = '<button type="button" class="btn btn-success j_close" data-dismiss="modal"> Finalizar </button>';
                    var content = resposta;
                    myModal('novo', '<i class="entypo-plus-circled"></i> Editar informações da grade no sistema ', content, buttom, 'newCliente');
                }
            },
            complete: function() {
            }
        });
        return false;
    });


    $('.modal').on('click', '.j_EditGrade', function() {
        var idGrade = $("input[name=idGrade]").val();
        var grade = $("input[name=nomeGradeEdit]").val();
        var dados = 'acao=EditGrade&nomeGrade=' + grade + '&idGrade=' + idGrade;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    myCallback('', 'warning', 'Informar nome.', 'Favor preecher o nome da grade.');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao cadastrar', 'Não e possivel cadastrar essa grade a mesma já existe. Verifique!');
                } else if (datas == 3) {
                    myCallback('', 'success', 'Sucesso!', 'Nome da grade alterada com sucesso no sistema!');
                } else {
                    alert(datas)
                }
            },
            complete: function() {
            }
        });
        return false;
    });

    $('.modal').on('click', '.j_newVaricao', function() {
        var idGrade = $("input[name=idGrade]").val();
        var variacao = $("input[name=nomeVariacao]").val();
        var dados = 'acao=novoVaria&nomeVaria=' + variacao + '&idGrade=' + idGrade;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
            beforeSend: function() {
            },
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    myCallback('', 'warning', 'Informar nome.', 'Favor preecher o nome da variação.');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao cadastrar', 'Não e possivel cadastrar essa variação a mesma já existe. Verifique!');
                } else {


                    $("input[name=nomeVariacao]").val('');
                    $('.j_nenhumav').fadeOut('fast');
                    $('.j_boxVariacao').prepend('<li class="list-group-item" id="' + datas + '">'
                            + variacao
                            + '<button type="button" class="btn btn-red tooltip-primary btn-xs j_deletVaria" id="' + datas + '" data-toggle="tooltip" data-placement="top" data-original-title="Remover variacão" style="float: right"><i class="glyphicon glyphicon-trash" style="padding:1px 0 0 0;"></i></button>'
                            + '</li>');
                    myCallback('', 'success', 'Sucesso!', 'Variação cadastrada com sucesso no sistema!');
                    tooltipReplace();
                    $("input[name=nomeVariacao]").focus();

                }
            },
            complete: function() {
            }
        });
        return false;
    });



    $('.j_removeGrad').click(function() {

        var id = $(this).attr('id');
        var dados = 'acao=deletaGrade&id=' + id;

        $.ajax({
            url: '_ajax/' + Url + '/controlador.php',
            data: dados,
            type: 'POST',
           
            success: function(resposta) {
                var datas = trim(resposta);
                if (datas == 1) {
                    $('tbody #' + id).fadeOut('fast', function() {
                        $this.remove();
                    });
                    myCallback('', 'success', 'Sucesso!', 'Grade removida com sucesso no sistema!');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao ler Grade!', 'Por favor  de um f5. e tente novamente!');
                } else {
                    myCallback('', 'error', 'Ocorreu um erro!', 'Erro no sistema!');
                }
            },
            
        });
        return false;
    });

    $('.modal').on('click', '.j_deletVaria', function() {
        var id = $(this).attr('id');
        var dados = 'acao=deletaV&id=' + id;

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
                    $('.j_boxVariacao #' + id).fadeOut('fast', function() {
                        $this.remove();
                    });
                    myCallback('', 'success', 'Sucesso!', 'Variação removida com sucesso no sistema!');
                } else if (datas == 2) {
                    myCallback('', 'error', 'Erro ao ler grade!', 'Por favor  de um f5. e tente novamente!');
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