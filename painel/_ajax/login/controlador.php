<?php

require_once '../../../_app/Config.inc.php';

$dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($dataLogin['AdminLogin'])):
    $login = new Login(1);
    $login->ExeLogin($dataLogin);
    if (!$login->getResult()):
       echo 'erroSenha';
    else:
        echo 'sucess';
    endif;

endif;

?>