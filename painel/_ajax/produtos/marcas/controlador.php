<?php

session_start();
require_once '../../../../_app/Config.inc.php';

$acao = filter_input(INPUT_POST, 'acao', FILTER_DEFAULT);

switch ($acao) {
    case'novo':
        $marca = null;
        include './formulario.php';
        break;
    case 'edita':
        $marca = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        $ReadMarca = new Read();
        $ReadMarca->ExeRead("Wstore_marcas", "WHERE id = :id ", "id={$marca}");
        if (!$ReadMarca->getResult()):
            echo 2;
        else:
            include './formulario.php';
        endif;
        break;

    case 'new':
        //pego o id da artistas apartir da sessão do usuario
        $idLoja = $_SESSION['userlogin']['site_code'];

        $c['nome'] = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
        $c['status'] = filter_input(INPUT_POST, 'status', FILTER_DEFAULT);
        $c['destaque'] = filter_input(INPUT_POST, 'destaque', FILTER_DEFAULT);
        $c['id_loja'] = $idLoja;

        $ReadMarca = new Read();
        $ReadMarca->ExeRead('Wstore_marcas', "WHERE nome = :nome AND id_loja = :idLoja", "nome={$c['nome']}&idLoja={$c['id_loja']}");
        if ($ReadMarca->getResult()) {
            die('1');
        }

        if (in_array('', $c)) {
            die('2');
        }
        $c['descricao'] = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);

        if (empty($_FILES['logoMarcas']['tmp_name'])) {
            if ($_FILES['logoMarcas']['name']):
                die('3');
            else:
                $cadastra = new Create();
                $cadastra->ExeCreate('Wstore_marcas', $c);
                $_SESSION['marca_create'] = 'sim';
            endif;
        } else {
            $diretorio = '../../../../uploads/' . $idLoja . '/';
            $upload = new Upload($diretorio);
            $upload->Image($_FILES['logoMarcas']);
            if (!$upload->getError()) {
                $c['logo'] = $upload->getResult();
                $cadastra = new Create();
                $cadastra->ExeCreate('Wstore_marcas', $c);
                $_SESSION['marca_create'] = 'sim';
            } else {
                echo $upload->getError();
            }
        }
        break;
    case 'update':
        print_r($_POST);
        print_r($_FILES);
        break;

    default:
        echo 'Erro';
}
?>