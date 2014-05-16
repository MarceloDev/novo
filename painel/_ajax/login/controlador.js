$(function() {

    $('form').submit(function() {
        var login = $(this).serialize() + '&AdminLogin=Logar';
        //iniciando o ajax
        $.ajax({
            url: '_ajax/login/controlador.php',
            data: login,
            type: 'POST',
            // caso seija sucesso
            success: function(resposta) {
                if (resposta == 'erroCamposEmBranco') {
                    $(".login-page").removeClass('logging-in');
                    myCallback('', 'error', 'Ocorreu um erro!', 'Preencha todos os campos');

                } else if (resposta == 'sucess') {
                    myCallback('', 'success', 'Login efetuado com sucesso!', 'Aguarde... direcionando para painel administrativo.');

                    //fazendo redirecionamento com deley de 1 segundo
                    window.setTimeout(function() {
                        $(location).attr('href', 'admin.php');
                    }, 1000);

                } else if (resposta == 'erroSenha') {
                    $(".login-page").removeClass('logging-in');
                    myCallback('', 'error', 'Ocorreu um erro!', 'Dados não conferem, verifique e tente novamente')
                } else {
                    alert(resposta);
                }
            },
            error: function(datas) {
                alert(datas);
            }
        });
        return false;
    })

});