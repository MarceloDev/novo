<?php

/**
 * Seo [ HELPER ]
 * Criação do SEO da pagina
 * @copyright (c) 2014, Marcelo Martins -  Desenvolvedor Back-end Pleno
 */
class Seo {

    private $Titulo;
    private $Conteudo;
    private $Url;
    private $Imagem;
    private $Tags;
    private $seoTags;

    /** pasta padrão de arquivos */
    const Pasta = 'uploads/';
    const Defalt = 'defalt.png';

    function __construct($Titulo, $Conteudo, $Tags = NULL, $Url = NULL, $Imagem = NULL) {
        $this->Titulo = Check::lmWord($Titulo, '80');
        $this->Conteudo = Check::lmWord($Conteudo, '200');
        $this->Url = BASE . '/' . $Url;
        $this->Imagem = $Imagem;
        $this->Tags = $Tags;
    }

    public function getSeoTags() {
        $this->montaSeo();
        return $this->seoTags;
    }
        
    private function montaSeo() {
        // recupera a imgem
        $this->Imagem = ($this->Imagem && file_exists(self::Pasta . $this->Imagem) && !is_dir(self::Pasta . $this->Imagem) ? BASE . '/' . self::Pasta . $this->Imagem : self::Pasta . self::Defalt);
        
        
        //Monsta o SEO da Pagina
        //NORMAL PAGE
        $this->seoTags = '<title>' . $this->Titulo . '</title> ' . "\n";
        $this->seoTags .= '<meta name="description" content="' . $this->Conteudo . '"/>' . "\n";
        $this->seoTags .= '<meta name="robots" content="index, follow" />' . "\n";
        $this->seoTags .= '<link rel="canonical" href="' . $this->Url . '">' . "\n";
        $this->seoTags .= "\n";

        //FACEBOOK
        $this->seoTags .= '<meta property="og:site_name" content="' . SITENAME . '" />' . "\n";
        $this->seoTags .= '<meta property="og:locale" content="pt_BR" />' . "\n";
        $this->seoTags .= '<meta property="og:title" content="' . $this->Titulo . '" />' . "\n";
        $this->seoTags .= '<meta property="og:description" content="' . $this->Conteudo . '" />' . "\n";
        $this->seoTags .= '<meta property="og:image" content="' . $this->Imagem . '" />' . "\n";
        $this->seoTags .= '<meta property="og:url" content="' . $this->Url . '" />' . "\n";
        $this->seoTags .= '<meta property="og:type" content="article" />' . "\n";
        $this->seoTags .= "\n";

        //ITEM GROUP (TWITTER)
        $this->seoTags .= '<meta itemprop="name" content="' . $this->Titulo . '">' . "\n";
        $this->seoTags .= '<meta itemprop="description" content="' . $this->Conteudo . '">' . "\n";
        $this->seoTags .= '<meta itemprop="url" content="' . $this->Url . '">' . "\n";
    }
    
    
}
