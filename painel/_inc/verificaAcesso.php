<?php

$get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
if (!empty($get)):
    if ($get == 'restrito'):
        ?>

        <script type="text/javascript">
            $(function($) {
                myCallback('', 'error', 'Acesso restiro!', 'Efetue login para ter acesso ao painel.');
            });
        </script>

    <?php elseif ($get == 'logoff'):
        ?>
        <script type="text/javascript">
            $(function() {
              myCallback('', 'success', 'Sucesso!', 'Você deslogou com sucesso.');
            });
        </script>
        <?php

    endif;
endif;
?>