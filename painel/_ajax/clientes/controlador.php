<?php

session_start();
require_once '../../../_app/Config.inc.php';

$acao = filter_input(INPUT_POST, 'acao', FILTER_DEFAULT);

switch ($acao) {
    case'novo':
        $idCliente = null;
        include './formulario.php';
        break;

    case 'edita':
        $idCliente = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        include './formulario.php';
        break;

    case 'deleta':
        $idCliente = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
        $ReadCliente = new Read();
        $ReadCliente->ExeRead('all_cadastro', 'WHERE site_code = :c', "c={$idCliente}");
        if ($ReadCliente->getResult()):
            $Detela = new Delete();
            $Detela->ExeDelete('all_cadastro', 'WHERE site_code = :c', "c={$idCliente}");
            $Detela->ExeDelete('site_configuracao', 'WHERE site_code = :c', "c={$idCliente}");
            if($Detela->getResult()):
                echo 1;
            endif;
        else:
            echo 2;
        endif;
        break;

    case 'new':

        $c['nome'] = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
        $c['email'] = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
        $c['tipo'] = filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT);
        $c['telefone'] = filter_input(INPUT_POST, 'fone', FILTER_DEFAULT);
        $c['code'] = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
        $c['senha'] = md5($c['code']);
        $c['data'] = date('Y-m-d H:i:s');
        $c['funcao'] = "Super Admin";
        $c['nivel'] = 1;

        $senha = filter_input(INPUT_POST, 'senhaC', FILTER_DEFAULT);

        $ReadCliente = new Read();

        // gera site_code
        for ($i = 1;; $i++) {
            $GeraIdsite = Check::geraCode(5, false);
            $ReadCliente->ExeRead('all_cadastro', "WHERE site_code = :code", "code={$GeraIdsite}");
            if (!$ReadCliente->getResult()) {
                break;
            }
        }
        // Armazeno o codigo gerado em  no array $c
        $c['site_code'] = $GeraIdsite;

        $m['slide'] = filter_input(INPUT_POST, 'slide', FILTER_DEFAULT);
        $m['equipe'] = filter_input(INPUT_POST, 'equipe', FILTER_DEFAULT);
        $m['sobre'] = filter_input(INPUT_POST, 'sobre', FILTER_DEFAULT);
        $m['agenda'] = filter_input(INPUT_POST, 'agenda', FILTER_DEFAULT);
        $m['videos'] = filter_input(INPUT_POST, 'video', FILTER_DEFAULT);
        $m['galeria'] = filter_input(INPUT_POST, 'galeria', FILTER_DEFAULT);
        $m['noticias'] = filter_input(INPUT_POST, 'noticias', FILTER_DEFAULT);
        $m['depoimentos'] = filter_input(INPUT_POST, 'depoimentos', FILTER_DEFAULT);
        $m['vitrine'] = filter_input(INPUT_POST, 'vitrine', FILTER_DEFAULT);
        $m['clipping'] = filter_input(INPUT_POST, 'clipping', FILTER_DEFAULT);
        $m['discografia'] = filter_input(INPUT_POST, 'discografia', FILTER_DEFAULT);
        $m['newslatter'] = filter_input(INPUT_POST, 'newslatter', FILTER_DEFAULT);

        $m['slide'] = $m['slide'] == '' ? 'nao' : 'sim';
        $m['equipe'] = $m['equipe'] == '' ? 'nao' : 'sim';
        $m['agenda'] = $m['agenda'] == '' ? 'nao' : 'sim';
        $m['galeria'] = $m['galeria'] == '' ? 'nao' : 'sim';
        $m['noticias'] = $m['noticias'] == '' ? 'nao' : 'sim';
        $m['depoimentos'] = $m['depoimentos'] == '' ? 'nao' : 'sim';
        $m['sobre'] = $m['sobre'] == '' ? 'nao' : 'sim';
        $m['videos'] = $m['videos'] == '' ? 'nao' : 'sim';
        $m['vitrine'] = $m['vitrine'] == '' ? 'nao' : 'sim';
        $m['clipping'] = $m['clipping'] == '' ? 'nao' : 'sim';
        $m['discografia'] = $m['discografia'] == '' ? 'nao' : 'sim';
        $m['newslatter'] = $m['newslatter'] == '' ? 'nao' : 'sim';
        $m['site_code'] = $c['site_code'];

        $h['site_code'] = $_SESSION['userlogin']['site_code'];
        $h['acao'] = 'Cadastrou novo Cliente "' . $c['nome'] . '"';
        $h['autor'] = $_SESSION['userlogin']['nome'];
        $h['data'] = date('Y-m-d H:i:s');

        //leitura do banco de dados para ver se já existe algum cliente com esse email
        $ReadCliente->ExeRead('all_cadastro', "WHERE email = :m", "m={$c['email']}");

        if (in_array('', $c)) {
            echo 1;
            die;
        } elseif (!Check::Email($c['email'])) {
            echo 2;
            die;
        } elseif ($ReadCliente->getResult()) {
            echo 3;
            die;
        } elseif ($c['code'] != $senha) {
            echo 4;
            die;
        } elseif (strlen($c['code']) < 6 || strlen($c['code']) > 12) {
            echo 5;
            die;
        } else {
            $cadastro = new Create();
            $cadastro->ExeCreate('all_cadastro', $c);
            $cadastro->ExeCreate('site_configuracao', $m);
            $cadastro->ExeCreate('all_historico', $h);
            echo '<tr id="' . $c['site_code'] . '">';
            echo '<td>' . $c['site_code'] . '</td>';
            echo '<td>' . date('d/m/Y H:i', strtotime($c['data'])) . ' Hs</td>';
            echo '<td>' . $c['nome'] . '</td>';
            echo '<td>' . $c['telefone'] . '</td>';
            echo '<td><a href="#" class="btn btn-blue btn-sm btn-icon icon-left j_edit" id="' . $c['site_code'] . '">';
            echo '<i class="entypo-pencil"></i>Editar';
            echo '</a></td>';
            echo '</tr>';
        }
        break;

    case 'update':

        $c['nome'] = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
        $c['email'] = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
        $c['tipo'] = filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT);
        $c['telefone'] = filter_input(INPUT_POST, 'fone', FILTER_DEFAULT);
        $c['code'] = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
        $c['senha'] = md5($c['code']);
        $c['data'] = date('Y-m-d H:i:s');
        $c['funcao'] = "Super Admin";
        $c['nivel'] = 1;

        $senha = filter_input(INPUT_POST, 'senhaC', FILTER_DEFAULT);
        $site_code = filter_input(INPUT_POST, 'site_code', FILTER_DEFAULT);

        $ReadCliente = new Read();

        $m['slide'] = filter_input(INPUT_POST, 'slide', FILTER_DEFAULT);
        $m['equipe'] = filter_input(INPUT_POST, 'equipe', FILTER_DEFAULT);
        $m['sobre'] = filter_input(INPUT_POST, 'sobre', FILTER_DEFAULT);
        $m['agenda'] = filter_input(INPUT_POST, 'agenda', FILTER_DEFAULT);
        $m['videos'] = filter_input(INPUT_POST, 'video', FILTER_DEFAULT);
        $m['galeria'] = filter_input(INPUT_POST, 'galeria', FILTER_DEFAULT);
        $m['noticias'] = filter_input(INPUT_POST, 'noticias', FILTER_DEFAULT);
        $m['depoimentos'] = filter_input(INPUT_POST, 'depoimentos', FILTER_DEFAULT);
        $m['vitrine'] = filter_input(INPUT_POST, 'vitrine', FILTER_DEFAULT);
        $m['clipping'] = filter_input(INPUT_POST, 'clipping', FILTER_DEFAULT);
        $m['discografia'] = filter_input(INPUT_POST, 'discografia', FILTER_DEFAULT);
        $m['newslatter'] = filter_input(INPUT_POST, 'newslatter', FILTER_DEFAULT);

        $m['slide'] = $m['slide'] == '' ? 'nao' : 'sim';
        $m['equipe'] = $m['equipe'] == '' ? 'nao' : 'sim';
        $m['agenda'] = $m['agenda'] == '' ? 'nao' : 'sim';
        $m['galeria'] = $m['galeria'] == '' ? 'nao' : 'sim';
        $m['noticias'] = $m['noticias'] == '' ? 'nao' : 'sim';
        $m['depoimentos'] = $m['depoimentos'] == '' ? 'nao' : 'sim';
        $m['sobre'] = $m['sobre'] == '' ? 'nao' : 'sim';
        $m['videos'] = $m['videos'] == '' ? 'nao' : 'sim';
        $m['vitrine'] = $m['vitrine'] == '' ? 'nao' : 'sim';
        $m['clipping'] = $m['clipping'] == '' ? 'nao' : 'sim';
        $m['discografia'] = $m['discografia'] == '' ? 'nao' : 'sim';
        $m['newslatter'] = $m['newslatter'] == '' ? 'nao' : 'sim';

        $h['site_code'] = $_SESSION['userlogin']['site_code'];
        $h['acao'] = 'Editou dados do cliente "' . $c['nome'] . '"';
        $h['autor'] = $_SESSION['userlogin']['nome'];
        $h['data'] = date('Y-m-d H:i:s');

        //leitura do banco de dados para ver se já existe algum cliente com esse email
        $ReadCliente->ExeRead('all_cadastro', "WHERE email = :m AND site_code != :c", "m={$c['email']}&c={$site_code}");

        if (in_array('', $c)) {
            echo 1;
            die;
        } elseif (!Check::Email($c['email'])) {
            echo 2;
            die;
        } elseif ($ReadCliente->getResult()) {
            echo 3;
            die;
        } elseif ($c['code'] != $senha) {
            echo 4;
            die;
        } elseif (strlen($c['code']) < 6 || strlen($c['code']) > 12) {
            echo 5;
            die;
        } else {
            $atualiza = new Update();
            $atualiza->ExeUpdate('all_cadastro', $c, "WHERE site_code = :c", "c={$site_code}");
            $atualiza->ExeUpdate('site_configuracao', $m, "WHERE site_code = :c", "c={$site_code}");
            $cadastro = new Create();
            $cadastro->ExeCreate('all_historico', $h);
            echo '<td>' . $site_code . '</td>';
            echo '<td>' . date('d/m/Y H:i', strtotime($c['data'])) . ' Hs</td>';
            echo '<td>' . $c['nome'] . '</td>';
            echo '<td>' . $c['telefone'] . '</td>';
            echo '<td><a href="#" class="btn btn-blue btn-sm btn-icon icon-left j_edit" id="' . $site_code . '">';
            echo '<i class="entypo-pencil"></i>Editar';
            echo '</a></td>';
        }
        break;




    default:
        echo 'Erro';
}
?>