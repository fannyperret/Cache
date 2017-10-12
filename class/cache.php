<?php
class Cache{

    public $dirname;
    public $duration; // Durée de vie du cache en MINUTES
    public $buffer; // mémoire temporaire, zone de mémoire de taille limitée servant à stocker des données


    public function __construct($dirname, $duration){
        $this->dirname = $dirname;
        $this->duration = $duration;
    }

    //toutes les fonctions dépendent des fonctions WRITE et READ (modifier ces deux fonctions là changer de cache)
    public function write($filename, $content){
        return file_put_contents($this->dirname.'/'.$filename, $content);
    } //permet de stocker les contenus d'une variable dans un fichier

    public function read($filename){
        $file = $this->dirname.'/'.$filename;
        if(!file_exists($file)){
            return false;

        }
        $lifetime = (time() - filemtime($file)) / 60;
        if($lifetime > $this->duration){
            return false;
        }
        return file_get_contents($file);
    }

    public function delete($filename){
        //permet de nettoyer le cache. Cette fonction permet de supprimer à la volée des éléments de Cache
        if(file_exists($file)){
            unlink($file);
        }
    }

    public function clear(){
        //va chercher tous les fichiers dans le dossier
        $files = glob($this->dirname.'/*');
        foreach( $files as $file ){
            unlink($file);
        }
    }

    public function inc($file, $cachename = null)){ //gérer un système de cache en incluant un fichier
        if(!$cachename){
            $cachename = basename($file);
        }
        if ($content = $this->read($cachename)) {
            echo $content;
            return true;
        }
        ob_start();
        require $file;
        $content = ob_get_clean();
        $this->write($cachename, $content);
        echo $content;
        return true;
    }

    public function start($cachename){
        if($content = $this->read($cachename)){
            echo $content;
            $this->buffer = false;
            return true;
        }
        ob_start();
        $this->buffer = $cachename;
    }

    public function end(){
        if(!$this->buffer){
            return false;
        }
        $content = ob_get_clean();
        echo $content
        $this->write($this->buffer, $content);

    }
}