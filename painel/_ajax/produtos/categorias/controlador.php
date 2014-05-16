<?php

session_start();
require_once '../../../../_app/Config.inc.php';

$acao = filter_input(INPUT_POST, 'acao', FILTER_DEFAULT);

switch ($acao) {
    case'novo':
        $IdCategoria = null;
        include './formulario.php';
        break;

    case 'edita':
        $IdCategoria = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        include './formulario.php';
        break;

    case 'deleta':
        $IdCategoria = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        $ReadCategoria = new Read();
        $ReadCategoria->ExeRead('Wstore_categorias', 'WHERE id_categoria = :c', "c={$IdCategoria}");
        if ($ReadCategoria->getResult()):
            $Detela = new Delete();
            $Detela->ExeDelete('Wstore_categorias', 'WHERE id_categoria = :c', "c={$IdCategoria}");
            if ($Detela->getResult()):
                echo 1;
                $_SESSION['categoria_delet'] = 'sim';
            endif;
        else:
            echo 2;
        endif;
        break;

    case 'new':
        //pega o id da loja	apartir da sessão de login do usuario			
        $idLoja = $_SESSION['userlogin']['site_code'];

        //Pega o id da categoria pai so select do formulario de cadastro de categorias
        $idPai = filter_input(INPUT_POST, 'categoriaPai', FILTER_DEFAULT);

        $ReadCategoria = new Read;

        //verifica se o id pai e maior ou igual a 1, pois se for maior esse sera um cadastro de uma subcategoria
        if ($idPai != '0') {
            //pego o nivel categoria pai, para que ao cadastrar a filha fique um nivel abaixo
            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria = :id", "id={$idPai}");
            foreach ($ReadCategoria->getResult() as $pai)
                ;
        } else {
            $pai['nivel'] = 0;
        }

        //ternaria para deternimar o status da categoria 1 para ativo 2 para inativo
        if (filter_input(INPUT_POST, 'status', FILTER_DEFAULT) == 'sim' ? $status = '1' : $status = '2')
            ;

        // preparo as informações a serem cadastradas no array $f
        $f['id_loja'] = $idLoja;
        $f['nivel'] = $pai['nivel'] + 1;
        $f['status'] = $status;
        $f['id_pai'] = $idPai;
        $f['nome'] = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
        $f['descricao_seo'] = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
        $f['url'] = Check::Name($f['nome']);

        //gera id da categoria.
        $ReadCategoria->ExeRead('Wstore_categorias', "WHERE url = :url AND id_loja = :code", "url={$f['url']}&code={$idLoja}");
        if ($ReadCategoria->getResult()) {
            $numero = 0;
            for ($i = 1;; $i++) {
                $numero ++;
                $verificaUrl = $f['url'] . '-' . $numero;
                $ReadCategoria->ExeRead('Wstore_categorias', "WHERE url = :url AND id_loja = :code", "url={$verificaUrl}&code={$idLoja}");
                if (!$ReadCategoria->getResult()) {
                    break;
                }
            }
            $f['url'] = $verificaUrl;
        }


        //gera id da categoria.
        for ($i = 1;; $i++) {
            $GeraIdCategoria = Check::geraCode(6);
            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria = :code", "code={$GeraIdCategoria}");
            if (!$ReadCategoria->getResult()) {
                break;
            }
        }
        $f['id_categoria'] = $GeraIdCategoria;

        //verifico se o campo nome da categoria esta vazio	
        if ($f['nome'] == '') {
            echo'1';
        }//caso as validações acima retornem true realizo o cadastro
        else {
            //leitura do banco de dados para confirmar se nao tem nenhuma categoria cadastrada com mesmo nome no mesmo nivel. 
            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_loja = :id AND nome = :nome AND id_pai = :pai", "id={$f['id_loja']}&nome={$f['nome']}&pai={$f['id_pai']}");
            if ($ReadCategoria->getResult()) {
                echo('2');
            } else {
                echo'3';
                $CriaCategoria = new Create();
                $CriaCategoria->ExeCreate('Wstore_categorias', $f);
                $_SESSION['categoria_create'] = 'sim';
            }
        }
        break;

    case 'update':
        //pega o id da loja	apartir da sessão de login do usuario			
        $idLoja = $_SESSION['userlogin']['site_code'];

        //Pega o id da categoria pai so select do formulario de cadastro de categorias
        $idPai = filter_input(INPUT_POST, 'categoriaPai', FILTER_DEFAULT);

        // pega o id da categoria que esta sendo Editada
        $IdCategoria = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);

        $ReadCategoria = new Read;

        //verifica se o id pai e maior ou igual a 1, pois se for maior esse sera um cadastro de uma subcategoria
        if ($idPai != '0') {
            //pego o nivel categoria pai, para que ao cadastrar a filha fique um nivel abaixo
            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_categoria = :id", "id={$idPai}");
            foreach ($ReadCategoria->getResult() as $pai)
                ;
        } else {
            $pai['nivel'] = 0;
        }

        //ternaria para deternimar o status da categoria 1 para ativo 2 para inativo
        if (filter_input(INPUT_POST, 'status', FILTER_DEFAULT) == 'sim' ? $status = '1' : $status = '2')
            ;

        // preparo as informações a serem cadastradas no array $f
        $f['nivel'] = $pai['nivel'] + 1;
        $f['status'] = $status;
        $f['id_pai'] = $idPai;
        $f['nome'] = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
        $f['descricao_seo'] = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
        $f['url'] = Check::Name($f['nome']);


        //gera id da categoria.
        $ReadCategoria->ExeRead('Wstore_categorias', "WHERE url = :url AND id_loja = :code AND id_categoria != :id", "url={$f['url']}&code={$idLoja}&id={$IdCategoria}");
        if ($ReadCategoria->getResult()) {
            $numero = 0;
            for ($i = 1;; $i++) {
                $numero ++;
                $verificaUrl = $f['url'] . '-' . $numero;
                $ReadCategoria->ExeRead('Wstore_categorias', "WHERE url = :url AND id_loja = :code AND id_categoria != :id", "url={$verificaUrl}&code={$idLoja}&id={$IdCategoria}");
                if (!$ReadCategoria->getResult()) {
                    break;
                }
            }
            $f['url'] = $verificaUrl;
        }


        //verifico se o campo nome da categoria esta vazio	
        if ($f['nome'] == '') {
            echo'1';
        }//caso as validações acima retornem true realizo o cadastro
        else {
            $ReadCategoria->ExeRead('Wstore_categorias', "WHERE id_loja = :id AND nome = :nome AND id_pai = :pai AND id_categoria != :idCat", "id={$idLoja}&nome={$f['nome']}&pai={$f['id_pai']}&idCat={$IdCategoria}");
            if ($ReadCategoria->getResult()) {
                echo('2');
            } else {
                echo'3';
                $atualizaCategoria = new Update();
                $atualizaCategoria->ExeUpdate('Wstore_categorias', $f, "WHERE id_categoria = :id", "id={$IdCategoria}");
                $_SESSION['categoria_update'] = 'sim';
            }
        } break;




    default:
        echo 'Erro';
}
?>