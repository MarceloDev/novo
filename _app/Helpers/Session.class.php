<?php

/**
 * Session.class [ HELPER ]
 * Responsável pelas estatísticas, sessões e atualizações de tráfego do sistema!
 * 
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Session {

    private $Date;
    private $Cache;
    private $Traffic;
    private $Browser;
    
    const siteCode = SITECODE;

    function __construct($Cache = null) {
        $this->CheckSession($Cache);
    }

    //Verifica e executa todos os métodos da classe!
    private function CheckSession($Cache = null) {
        $this->Date = date('Y-m-d');
        $this->Cache = ( (int) $Cache ? $Cache : 20 );

        if (empty($_SESSION['useronline'])):
            $this->setTraffic();
            $this->setSession();
            $this->CheckBrowser();
            $this->setUsuario();
            $this->BrowserUpdate();
        else:
            $this->TrafficUpdate();
            $this->sessionUpdate();
            $this->CheckBrowser();
            $this->UsuarioUpdate();
        endif;

        $this->Date = null;
    }

    /*
     * ***************************************
     * ********   SESSÃO DO USUÁRIO   ********
     * ***************************************
     */

    //Inicia a sessão do usuário
    private function setSession() {
        $_SESSION['useronline'] = [
            "online_session" => session_id(),
            "online_startview" => date('Y-m-d H:i:s'),
            "online_endview" => date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes")),
            "online_ip" => filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP),
            "online_url" => filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT),
            "online_agent" => filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT),
            "agent_site_code" => self::siteCode
        ];
    }

    //Atualiza sessão do usuário!
    private function sessionUpdate() {
        $_SESSION['useronline']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes"));
        $_SESSION['useronline']['online_url'] = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
    }

    /*
     * ***************************************
     * *** USUÁRIOS, VISITAS, ATUALIZAÇÕES ***
     * ***************************************
     */

    //Verifica e insere o tráfego na tabela
    private function setTraffic() {
        $this->getTraffic();
        if (!$this->Traffic):
            $ArrSiteViews = [ 'siteviews_date' => $this->Date, 'siteviews_users' => 1, 'siteviews_views' => 1, 'siteviews_pages' => 1, 'siteviews_site_code' => self::siteCode];
            $createSiteViews = new Create;
            $createSiteViews->ExeCreate('all_siteviews', $ArrSiteViews);
        else:
            if (!$this->getCookie()):
                $ArrSiteViews = [ 'siteviews_users' => $this->Traffic['siteviews_users'] + 1, 'siteviews_views' => $this->Traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
            else:
                $ArrSiteViews = [ 'siteviews_views' => $this->Traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
            endif;

            $updateSiteViews = new Update;
            $updateSiteViews->ExeUpdate('all_siteviews', $ArrSiteViews, "WHERE siteviews_date = :date AND siteviews_site_code = :code", "date={$this->Date}&code=".self::siteCode);

        endif;
    }

    //Verifica e atualiza os pageviews
    private function TrafficUpdate() {
        $this->getTraffic();
        $ArrSiteViews = [ 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
        $updatePageViews = new Update;
        $updatePageViews->ExeUpdate('all_siteviews', $ArrSiteViews, "WHERE siteviews_date = :date AND siteviews_site_code = :code", "date={$this->Date}&code=".self::siteCode);

        $this->Traffic = null;
    }

    //Obtém dados da tabele [ HELPER TRAFFIC ]
    //ws_siteviews
    private function getTraffic() {
        $readSiteViews = new Read;
        $readSiteViews->ExeRead('all_siteviews', "WHERE siteviews_date = :date AND siteviews_site_code = :code", "date={$this->Date}&code=".self::siteCode);
        if ($readSiteViews->getRowCount()):
            $this->Traffic = $readSiteViews->getResult()[0];
        endif;
    }

    //Verifica, cria e atualiza o cookie do usuário [ HELPER TRAFFIC ]
    private function getCookie() {
        $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        setcookie("useronline", base64_encode("geek"), time() + 86400);
        if (!$Cookie):
            return false;
        else:
            return true;
        endif;
    }

    /*
     * ***************************************
     * *******  NAVEGADORES DE ACESSO   ******
     * ***************************************
     */

    //Identifica navegador do usuário!
    private function CheckBrowser() {
        $this->Browser = $_SESSION['useronline']['online_agent'];
        if (strpos($this->Browser, 'OPR') or strpos($this->Browser, 'Opera')):
            $this->Browser = 'opera';
        elseif (strpos($this->Browser, 'Chrome')):
            $this->Browser = 'chrome';
        elseif (strpos($this->Browser, 'Firefox')):
            $this->Browser = 'firefox';
        elseif (strpos($this->Browser, 'MSIE') || strpos($this->Browser, 'Trident/')):
            $this->Browser = 'ie';
        elseif (strpos($this->Browser, 'Safari')):
            $this->Browser = 'safari';
        else:
            $this->Browser = 'outros';
        endif;
    }

    //Atualiza tabela com dados de navegadores!
    private function BrowserUpdate() {
        $readAgent = new Read;
        $readAgent->ExeRead('all_siteviews_agent', "WHERE site_code = :agent", "agent=".self::siteCode);
        if (!$readAgent->getResult()):
            $ArrAgent = [$this->Browser =>  1, 'site_code' => self::siteCode];
            $createAgent = new Create;
            $createAgent->ExeCreate('all_siteviews_agent', $ArrAgent);
        else:
            $ArrAgent = [ $this->Browser => $readAgent->getResult()[0][$this->Browser] + 1];
            $updateAgent = new Update;
            $updateAgent->ExeUpdate('all_siteviews_agent', $ArrAgent, "WHERE site_code = :agent", "agent=".self::siteCode);
        endif;
    }

    /*
     * ***************************************
     * *********   USUÁRIOS ONLINE   *********
     * ***************************************
     */

    //Cadastra usuário online na tabela!
    private function setUsuario() {
        $sesOnline = $_SESSION['useronline'];
        $sesOnline['agent_name'] = $this->Browser;

        $userCreate = new Create;
        $userCreate->ExeCreate('all_siteviews_online', $sesOnline);
    }

    //Atualiza navegação do usuário online!
    private function UsuarioUpdate() {
        $ArrOnlone = [
            'online_endview' => $_SESSION['useronline']['online_endview'],
            'online_url' => $_SESSION['useronline']['online_url']
        ];

        $userUpdate = new Update;
        $userUpdate->ExeUpdate('all_siteviews_online', $ArrOnlone, "WHERE online_session = :ses", "ses={$_SESSION['useronline']['online_session']}");

        if (!$userUpdate->getRowCount()):
            $readSes = new Read;
            $readSes->ExeRead('all_siteviews_online', 'WHERE online_session = :onses', "onses={$_SESSION['useronline']['online_session']}");
            if (!$readSes->getRowCount()):
                $this->setUsuario();
            endif;
        endif;
    }

}
