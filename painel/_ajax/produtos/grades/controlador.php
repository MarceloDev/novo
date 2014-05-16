<?php

session_start();
require_once '../../../../_app/Config.inc.php';

$acao = filter_input(INPUT_POST, 'acao', FILTER_DEFAULT);

switch ($acao) {
    case'novo':
        $f['nome'] = filter_input(INPUT_POST, 'nomeGrade', FILTER_DEFAULT);
        $f['id_loja'] = $_SESSION['userlogin']['site_code'];
        $f['tipo'] = 2;
        if ($f['nome'] == ''):
            echo 1;
        else:
            $readGrade = new Read();
            $readGrade->ExeRead("Wsotre_grades_de_opcoes", "WHERE nome = :n AND id_loja = :id", "n={$f['nome']}&id={$f['id_loja']}");
            if ($readGrade->getResult()):
                echo 2;
            else:
                $CriaGrade = new Create();
                $CriaGrade->ExeCreate('Wsotre_grades_de_opcoes', $f);

                $idGrade = $CriaGrade->getResult();
                include './formulario.php';

            endif;

        endif;

        break;
    case'edita':
        $idLoja = $_SESSION['userlogin']['site_code'];
        $idGrade = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        $readGrade = new Read();
        $readGrade->ExeRead("Wsotre_grades_de_opcoes", "WHERE id_loja = :id AND id = :myid", "id={$idLoja}&myid={$idGrade}");
        if (!$readGrade->getResult()):
            echo 2;
        else:
            include './formulario.php';
        endif;
        break;
        
    case 'deletaGrade':
        $idGrade = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        $readGrade = new Read();
        $readGrade->ExeRead('Wsotre_grades_de_opcoes', 'WHERE id = :c', "c={$idGrade}");
        if ($readGrade->getResult()):
            $Detela = new Delete();
            $Detela->ExeDelete('Wstore_variacoes_grade_de_opcoes', 'WHERE id_op = :c', "c={$idGrade}");
            $Detela->ExeDelete('Wsotre_grades_de_opcoes', 'WHERE id = :c', "c={$idGrade}");
            if ($Detela->getResult()):
                echo 1;
            endif;
        else:
            echo 2;
        endif;
        break;

    case'EditGrade':
        $f['nome'] = filter_input(INPUT_POST, 'nomeGrade', FILTER_DEFAULT);
        $idLoja = $_SESSION['userlogin']['site_code'];
        $idGrade = filter_input(INPUT_POST, 'idGrade', FILTER_DEFAULT);
        if ($f['nome'] == ''):
            echo 1;
        else:
            $readGrade = new Read();
            $readGrade->ExeRead("Wsotre_grades_de_opcoes", "WHERE nome = :n AND id_loja = :id AND id != :myid", "n={$f['nome']}&id={$idLoja}&myid={$idGrade}");
            if ($readGrade->getResult()):
                echo 2;
            else:
                $AtualzaGrade = new Update();
                $AtualzaGrade->ExeUpdate('Wsotre_grades_de_opcoes', $f, "WHERE id = :myid", "myid={$idGrade}");
                echo 3;
            endif;

        endif;

        break;

    case 'deletaV':
        $idVaria = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        $ReadVaria = new Read();
        $ReadVaria->ExeRead('Wstore_variacoes_grade_de_opcoes', 'WHERE id = :c', "c={$idVaria}");
        if ($ReadVaria->getResult()):
            $Detela = new Delete();
            $Detela->ExeDelete('Wstore_variacoes_grade_de_opcoes', 'WHERE id = :c', "c={$idVaria}");
            if ($Detela->getResult()):
                echo 1;
            endif;
        else:
            echo 2;
        endif;
        break;



    case'novoVaria':
        $f['nome'] = filter_input(INPUT_POST, 'nomeVaria', FILTER_DEFAULT);
        $f['id_op'] = filter_input(INPUT_POST, 'idGrade', FILTER_DEFAULT);
        $f['id_loja'] = $_SESSION['userlogin']['site_code'];
        if ($f['nome'] == ''):
            echo 1;
        else:
            $readGrade = new Read();
            $readGrade->ExeRead("Wstore_variacoes_grade_de_opcoes", "WHERE nome = :n AND id_loja = :id AND id_op = :idp", "n={$f['nome']}&id={$f['id_loja']}&idp={$f['id_op']}");
            if ($readGrade->getResult()):
                echo 2;
            else:
                $CriaGrade = new Create();
                $CriaGrade->ExeCreate('Wstore_variacoes_grade_de_opcoes', $f);
                echo $CriaGrade->getResult();

            endif;

        endif;

        break;




    default:
        echo 'Erro';
}
?>