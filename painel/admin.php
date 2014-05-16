<?php

session_start();
require('../_app/Config.inc.php');

$login = new Login(1);
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$exe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if ($logoff):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=logoff');
    die();
endif;

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogin'];
endif;



if (!empty($exe)):
    if (file_exists('system/' . $exe . '.php')):
        $sessao = new Session(5);
        require_once('_inc/header.php');
        require('system/' . $exe . '.php');
        require_once('_inc/footer.php');
    else:
        require('system/painel/404.php');
    endif;
else:
    header('Location: admin.php?exe=painel/home');
endif;
?>