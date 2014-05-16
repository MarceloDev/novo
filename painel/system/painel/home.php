
<div class="page-container">	
    <?php include '_inc/menu.php'; ?>

    <div class="main-content">
        <?php include '_inc/topo.php'; ?>

        <hr />

        <script type="text/javascript">
            jQuery(document).ready(function($)
            {
                // Sample Toastr Notification
                setTimeout(function()
                {
                    var opts = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
                        "toastClass": "black",
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                }, 3000);


                $(".users-online").sparkline([1, 5, 6, 7, 10, 12, 8.9, 8.7, 7, 8, 7, 6, 5.6, 5, 7, 5, 4, 5, 6, 7, 8, 6, 7, 6, 3, 2], {
                    type: 'line',
                    width: '100%',
                    height: '55',
                    lineColor: '#ff4e50',
                    fillColor: 'rgba(255, 78, 80, 0.21)',
                    lineWidth: 2,
                    spotColor: '#a9282a',
                    minSpotColor: '#a9282a',
                    maxSpotColor: '#a9282a',
                    highlightSpotColor: '#a9282a',
                    highlightLineColor: '#f4c3c4',
                    spotRadius: 2,
                    drawNormalOnTop: true
                });


                $(".daily-visitors").sparkline([1, 5, 5.5, 5.4, 5.8, 6, 8, 9, 13, 12, 10, 11.5, 9, 8, 5, 8, 9], {
                    type: 'line',
                    width: '100%',
                    height: '55',
                    lineColor: '#00b29e',
                    fillColor: 'rgba(0, 178, 158, 0.21)',
                    lineWidth: 2,
                    spotColor: '#0D8D7F',
                    minSpotColor: '#0D8D7F',
                    maxSpotColor: '#0D8D7F',
                    highlightSpotColor: '#0D8D7F',
                    highlightLineColor: '#28AC9D',
                    spotRadius: 2,
                    drawNormalOnTop: true
                });


                $(".stock-market").sparkline([1, 5, 6, 7, 10, 12, 16, 11, 9, 8.9, 8.7, 7, 8, 7, 6, 5.6, 5, 7, 5], {
                    type: 'line',
                    width: '100%',
                    height: '55',
                    lineColor: '#ffa812',
                    fillColor: 'rgba(255, 168, 18, 0.2)',
                    lineWidth: 2,
                    spotColor: '#E49309',
                    minSpotColor: '#E49309',
                    maxSpotColor: '#E49309',
                    highlightSpotColor: '#E49309',
                    highlightLineColor: '#EEA426',
                    spotRadius: 2,
                    drawNormalOnTop: true
                });

            });

        </script>

        <style>
            .jqstooltip{display: none !important;}
        </style>

        <?php
        // fazendo leitura para peencher os campos
        $idCliente = $_SESSION['userlogin']['site_code'];
        $dataAtual = date('Y-m-d');
        $ReadStatisticas = new Read();
        $ReadStatisticas->ExeRead('all_siteviews', "WHERE siteviews_site_code = :c AND siteviews_date = :d", "c={$idCliente}&d={$dataAtual}");
        $siteViews = $ReadStatisticas->getResult();
        $siteViews = ($siteViews ? $siteViews : '0');
        $ReadStatisticas->ExeRead('all_siteviews_agent', "WHERE site_code = :c", "c={$idCliente}");
        $navegadores = $ReadStatisticas->getResult();
        $dataAtual = date('Y-m-d H:i:s');
        $ReadStatisticas->ExeRead('all_siteviews_online', "WHERE agent_site_code = :c AND online_endview >= :d", "c={$idCliente}&d={$dataAtual}");
        // Criando as variaveis
        $online = $ReadStatisticas->getRowCount();
        $visitas = ( $siteViews == '0' ? '0' : $siteViews[0]['siteviews_views']);
        $pageViews = ( $siteViews == '0' ? '0' : $siteViews[0]['siteviews_pages']);

        //estatisticas de navegador
        $ReadStatisticas->ExeRead('all_siteviews_agent', "WHERE site_code = :c", "c={$idCliente}");
        if (!$ReadStatisticas->getResult()):
            $chrome = 0;
            $opera = 0;
            $safari = 0;
            $firefox = 0;
            $ie = 0;
            $outros = 0;
        else:
            $navegadores = $ReadStatisticas->getResult();
            $chrome = ($navegadores[0]['chrome'] != null ? $navegadores[0]['chrome'] : 0);
            $opera = ($navegadores[0]['opera'] != null ? $navegadores[0]['opera'] : 0);
            $safari = ($navegadores[0]['safari'] != null ? $navegadores[0]['safari'] : 0);
            $firefox = ($navegadores[0]['firefox'] != null ? $navegadores[0]['firefox'] : 0);
            $ie = ($navegadores[0]['ie'] != null ? $navegadores[0]['ie'] : 0);
            $outros = ($navegadores[0]['outros'] != null ? $navegadores[0]['outros'] : 0);

            $total = ($chrome + $opera + $safari + $firefox + $ie + $outros);

            $chrome = substr(( $chrome / $total ) * 100, 0, 4);
            $opera = substr(( $opera / $total ) * 100, 0, 4);
            $safari = substr(( $safari / $total ) * 100, 0, 4);
            $firefox = substr(( $firefox / $total ) * 100, 0, 4);
            $ie = substr(( $ie / $total ) * 100, 0, 4);
            $outros = substr(( $outros / $total ) * 100, 0, 4);
        endif;

        //media de visitas diarias
        $ReadStatisticas->ExeRead('all_siteviews', "WHERE siteviews_site_code = :c", "c={$idCliente}");
        if ($ReadStatisticas->getResult()):
            $totalVisitas = 0;
            foreach ($ReadStatisticas->getResult() as $media):
                $totalVisitas += $media['siteviews_views'] . ' <br> ';
            endforeach;
            $totaldias = $ReadStatisticas->getRowCount();
            $mediaVisitas = round($totalVisitas / $totaldias);
        else:
            $mediaVisitas = 0;
        endif;
        ?>

        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="tile-stats tile-white stat-tile">
                    <h3>Visitas: <?= $visitas ?></h3>
                    <p>Qtde. Vizitas hoje.</p>
                    <span class="daily-visitors"></span>
                </div>		
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="tile-stats tile-white stat-tile">
                    <h3>Users Online:  <?= $online ?></h3>
                    <p>Qtde. Users online agora.</p>
                    <span class="users-online"></span>
                </div>		
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="tile-stats tile-white stat-tile">
                    <h3>Page views:  <?= $pageViews ?></h3>
                    <p>Qtde. Vizualizações hoje.</p>
                    <span class="stock-market"></span>
                </div>		
            </div>
        </div>

        <br />

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-primary panel-table">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3>Navegadores Utilizados</h3>
                            <span>Fique por dentro do perfil do usuario que acessa seu site!</span>
                        </div>

                    </div>
                    <div class="panel-body">	
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <h5>Google Chrome <b style="float:right;"><?= $chrome ?>%</b></h5>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $chrome ?>%; background-color: #00c0ef;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <h5>Opera<b style="float:right;"><?= $opera ?>%</b></h5>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $opera ?>%; background-color: #FF1A5A;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <h5>Safari <b style="float:right;"><?= $safari ?>%</b></h5>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $safari ?>%; background-color: #1896BE;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <h5>Firefox <b style="float:right;"><?= $firefox ?>%</b></h5>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $firefox ?>%; background-color: #ffa812">
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-4">
                                    <h5>Internet Explorer <b style="float:right;"><?= $ie ?>%</b></h5>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $ie ?>%; background-color:#EC503B ">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <h5>Outros <b style="float:right;"><?= $outros ?>%</b></h5>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $outros ?>%; background-color:#ba79cb">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="tile-stats tile-blue">
                    <div class="icon"><i class="entypo-flag"></i></div>
                    <div class="num"><?= $idCliente ?></div>
                    <h3>Codigo do Site</h3>
                    <p>Codigo de identidade no PAINEL GEEK</p>
                </div>	

                <br />

                <div class="tile-stats tile-primary">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="<?= $mediaVisitas ?>" data-postfix="" data-duration="1400" data-delay="0"><?= $mediaVisitas ?></div>
                    <h3>Média Diaria de visitas</h3>
                    <p>Media de visitas diarias do site</p>
                </div>	

            </div>
        </div>

        <br />

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary panel-table">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3>Historico de ações</h3>
                            <span>Saiba tudo que ocorre em seu painel. Transparencia total</span>
                        </div>


                    </div>
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 150px;">Data</th>
                                <th>Oque foi feito?</th>
                                <th>Por quem?</th>
                            </tr>
                        </thead>

                        <tbody style="background:#fff !important;">
                            <?php
                           
                            $read = new Read();
                            $read->ExeRead('all_historico', "WHERE site_code = :code ORDER BY id DESC LIMIT :limit", "code={$idCliente}&limit=10");
                            if (!$read->getResult()):
                                echo '<tr class="NullCadastro"><td colspan="3"><h4 style="text-align: center; margin: 15px 0;">Nenhum resgistro de atividade no sistema! </h4></td></tr>';
                            else:

                                foreach ($read->getResult() as $h):
                                    extract($h);
                                    ?>
                                    <tr>
                                        <td><?=date('d/m/Y H:i', strtotime($data)); ?> Hs</td>
                                        <td><?=$acao?></td>
                                        <td><?=$autor?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>

        </div><!-- Footer -->
        <footer class="main">
            &copy; 2014 <strong>Painel Geek </strong> developed by: <a href="#">Marcelo Martins </a> 
        </footer>	
    </div>
</div>

<script src="_assets/js/jquery.sparkline.min.js"></script>
