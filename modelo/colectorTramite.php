<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of colectorTramite
 *
 * @author g-proceso
 */
class colectorTramite {
    private $listaTramite;
    public function __construct() {
       $this->listaTramite= new ArrayObject(); ;
    }

        public function añadirTramite($tramite){
        
        $this->listaTramite->append($tramite);
    }
    public function obtenerTramite(){
        return $this->listaTramite;
    }
}
