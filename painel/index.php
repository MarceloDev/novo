<?php
session_start();
require('../_app/Config.inc.php');

$login = new Login(3);
if ($login->CheckLogin()):
    header('Location: painel.php');
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="language" content="pt-br" />
        <meta name="robots" content="noindex, nofollow">
        <meta name="author" content="Marcelo Martins" />
        
        <link rel="shortcut icon" href="http://localhost/geek/img/favicon.ico">

        <title>Painel Admin Geek - Administrativo da Agência Geek</title>

        <link rel="stylesheet" href="_assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
        <link rel="stylesheet" href="_assets/css/font-icons/entypo/css/entypo.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
        <link rel="stylesheet" href="_assets/css/bootstrap.css">
        <link rel="stylesheet" href="_assets/css/neon-core.css">
        <link rel="stylesheet" href="_assets/css/neon-theme.css">
        <link rel="stylesheet" href="_assets/css/neon-forms.css">
        <link rel="stylesheet" href="_assets/css/custom.css">
        <link rel="stylesheet" href="_assets/css/font-icons/font-awesome/css/font-awesome.min.css">

        <script src="_assets/js/jquery-1.11.0.min.js"></script>

        <script src="_assets/js/jquery-1.10.2.min.js"></script>
        <script src="_assets/js/jquery.form.js"></script>
        <script src="_ajax/login/controlador.js"></script>

        <!--[if lt IE 9]><script src="_assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


    </head>
    <body class="page-body login-page login-form-fall">


        <!-- This is needed when you send requests via Ajax --><script type="text/javascript">
            var baseurl = '';
        </script>

        <div class="login-container">

            <div class="login-header login-caret">

                <div class="login-content">

                    <a href="index.html" class="logo">
                        <img src="http://localhost/geek/img/logo.png" width="120" alt="" />
                    </a>

                    <p class="description">Caro cliente informe login e senha para ter acessar o Admin Painel!</p>
                    
                </div>

            </div>

            <div class="login-form">

                <div class="login-content">
                    <!--Verifica acesso restriro ou deslogar-->
                    <?php require './_inc/verificaAcesso.php'; ?>

                    <form method="post" role="form" id="form_login">

                        <div class="form-group">

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="entypo-user"></i>
                                </div>

                                <input type="text" class="form-control" name="user" id="username" placeholder="Usuario" autocomplete="off"/>
                            </div>

                        </div>

                        <div class="form-group">

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="entypo-key"></i>
                                </div>

                                <input type="password" class="form-control" name="pass" id="password" placeholder="Senha" autocomplete="off"/>
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">
                                <i class="entypo-login"></i>
                                Acessar painel
                            </button>
                        </div>			
                    </form>

                    <div class="login-bottom-links">
                        <a class="link">#GeekDigital</a>
                        <br />
                        &COPY; 2014 <a href="#">Agência Geek - Por uma web internet mais limpa!</a>
                    </div>
                </div>
            </div>

        </div>


        <!-- Bottom Scripts -->
        <script src="_assets/js/gsap/main-gsap.js"></script>
        <script src="_assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
        <script src="_assets/js/bootstrap.js"></script>
        <script src="_assets/js/joinable.js"></script>
        <script src="_assets/js/resizeable.js"></script>
        <script src="_assets/js/neon-api.js"></script>
        <script src="_assets/js/jquery.validate.min.js"></script>
        <script src="_assets/js/neon-login.js"></script>
        <script src="_assets/js/neon-custom.js"></script>
        <script src="_assets/js/neon-demo.js"></script>

        <div id="mensagemAlert" class="toast-top-right">
        </div>	

    </body>
</html>