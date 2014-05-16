<?php

/**
 * Diretorio [ HELPER ]
 * Classe resolponsavel por gestão de diretorios
 * @copyright (c) 2014, Marcelo Martins -  Desenvolvedor Back-end Pleno
 */
class Diretorio {

//---------- apaga diretorio
    public static function apagarDir($DirDest) {
        //Abrindo o diretorio
        $abreDir = opendir($DirDest);
        //Lendo todos os arquivos e pastas dentro do diretorio
        while (false !== ($file = readdir($abreDir))) {
            if ($file == ".." || $file == ".")
                continue;
            /*
              Verificando se o item é uma pasta
              Se for ele chama a função novamente para
              apagar os arquivos e pastas
              Se não for pasta a função apaga o arquivo
             */
            if (is_dir($cFile = ($DirDest . "/" . $file)))
                apagarDir($cFile);
            else if (is_file($cFile))
                @unlink($cFile); //Apagando arquivo
        }
        //Fechando o diretorio
        closedir($abreDir);
        //Deletando a pasta
        rmdir($DirDest);
    }

//---------- cria diretorio
    public static function criaDir($DirDest) {
        if (is_dir($DirDest)): apagarDir($DirDest);
        endif;
        //crio a pasta no local deseijado
        mkdir($DirDest, 0777, true);
    }

//---------- Copia Diretorio diretorio
    public static function CopiaDir($DirFont, $DirDest) {
        //verifica se já existe diretorio. se tiver apaga
        if (is_dir($DirDest)): apagarDir($DirDest);
        endif;

        mkdir($DirDest);
        if ($dd = opendir($DirFont)) {
            while (false !== ($Arq = readdir($dd))) {
                if ($Arq != "." && $Arq != "..") {
                    $PathIn = "$DirFont/$Arq";
                    $PathOut = "$DirDest/$Arq";
                    if (is_dir($PathIn)) {
                        CopiaDir($PathIn, $PathOut);
                    } elseif (is_file($PathIn)) {
                        copy($PathIn, $PathOut);
                    }
                }
            }
            closedir($dd);
        }
        return true;
    }

}
